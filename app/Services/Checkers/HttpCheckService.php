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
    const EMPTY_RESPONSE_THRESHOLD = 10;
    const CONCURRENT_REQUESTS = 10;

    /** @var Client */
    protected $client;

    /** @var Promise\PromiseInterface[]|array */
    protected $requests = [];
    /** @var CheckInterface[]|array */
    protected $checkMap = [];

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
            $this->requests[] = $this->client->getAsync($check->url);
        });

        $each = Promise\each_limit($this->requests, static::CONCURRENT_REQUESTS, function (ResponseInterface $result, int $idx) {
            // fulfilled
            $this->checkResponse($result, $this->checkMap[$idx]);
        }, function (RequestException $reason, int $idx) {
            // rejected
            $this->checkFailed($this->checkMap[$idx], $reason->getMessage());
        });
        $each->wait();
    }

    protected function checkResponse(ResponseInterface $response, CheckInterface $check)
    {
        if ($response->getBody()->getSize() < static::EMPTY_RESPONSE_THRESHOLD) {
            $this->checkFailed($check, 'Empty or short response-body: '.$response->getBody()->getContents());

            return false;
        }

        return true;
    }
}
