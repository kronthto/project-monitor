<?php

namespace App;

use App\Contracts\CheckInterface;
use App\Contracts\CheckDueHelper;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $url
 * @property string $name
 * @property int $every
 * @property int $offset
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 */
class HttpCheck extends Model implements CheckInterface
{
    use CheckDueHelper;

    protected $table = 'http_checks';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function getName(): string
    {
        return sprintf('%s (%s)', $this->name, $this->url);
    }

    public function getInterval(): int
    {
        return $this->every;
    }

    public function getOffset(): int
    {
        return $this->offset;
    }
}
