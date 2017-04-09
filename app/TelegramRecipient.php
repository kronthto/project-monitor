<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

/**
 * @property int $chat_id
 * @property string|null $name
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 */
class TelegramRecipient extends Model
{
    use Notifiable;

    protected $table = 'recipients';

    protected $guarded = ['created_at', 'updated_at'];

    public $incrementing = false;

    protected $primaryKey = 'chat_id';
}
