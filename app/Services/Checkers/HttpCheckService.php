<?php

namespace App\Services\Checkers;

use App\Contracts\CheckInterface;
use App\HttpCheck;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Promise;
use Psr\Http\Message\ResponseInterface;

class HttpCheckService extends AbstractChecker
{
    const EMPTY_RESPONSE_THRESHOLD = 10; // strlen
    const CONCURRENT_REQUESTS = 10;

    /** @var Client */
    protected $client;

    /** @var Promise\PromiseInterface[]|array */
    protected $requests = [];
    /** @var HttpCheck[]|array */
    protected $checkMap = [];
    /** @var bool */
    protected $isRetrying = false;

    public function __construct()
    {
        $this->client = new Client([
            'timeout' => 15.0,
            'headers' => [
                'User-Agent' => 'Website status checker by TK',
            ],
            'redirect.disable' => true,
            'allow_redirects' => false,
            'http_errors' => true,
        ]);
    }

    public function run()
    {
        HttpCheck::all()->each(function (HttpCheck $check) {
            if (!$check->isDueAt(static::getNow())) {
                return;
            }

            $this->checkMap[] = $check;
        });

        $this->prepareRequests();

        $this->fireRequests();
    }

    protected function prepareRequests()
    {
        foreach ($this->checkMap as $idx => $check) {
            $this->requests[$idx] = $this->client->getAsync($check->url);
        }
    }

    protected function fireRequests()
    {
        $each = Promise\each_limit(
            $this->requests,
            static::CONCURRENT_REQUESTS,
            function (ResponseInterface $result, int $idx) {
                // fulfilled
                if ($this->checkResponse($result, $this->checkMap[$idx])) {
                    unset($this->checkMap[$idx]);
                    unset($this->requests[$idx]);
                }
            },
            function (RequestException $reason, int $idx) {
                // rejected
                $this->checkFailed($this->checkMap[$idx], $reason->getMessage());
            }
        );
        $each->wait();

        if (!$this->isRetrying) {
            if (sizeof($this->checkMap) == 0) {
                return;
            }
            $this->isRetrying = true;
            $this->prepareRequests();
            $this->fireRequests();
        }
    }

    protected function checkFailed(CheckInterface $check, string $reason)
    {
        if ($this->isRetrying) {
            parent::checkFailed($check, $reason);
        }
    }

    protected function checkResponse(ResponseInterface $response, CheckInterface $check): bool
    {
        if ($response->getBody()->getSize() < static::EMPTY_RESPONSE_THRESHOLD) {
            $this->checkFailed($check, 'Empty or short response-body: '.$response->getBody()->getContents());

            return false;
        }

        return true;
    }
}
