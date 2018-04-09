<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class FailureHistory extends Model
{
    protected $table = 'failure_history';

    protected $guarded = ['id'];

    public $timestamps = false;

    protected $dates = ['date'];

    public function check()
    {
        return $this->morphTo();
    }
}
