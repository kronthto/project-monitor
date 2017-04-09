<?php

namespace App\Notifications;

use App\Contracts\CheckInterface;
use App\TelegramRecipient;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;

class PanicNotification extends Notification
{
    /** @var CheckInterface */
    protected $check;
    /** @var string */
    protected $message;

    /**
     * Create a new notification instance.
     *
     * @param CheckInterface $check
     * @param string         $reason
     */
    public function __construct(CheckInterface $check, string $reason)
    {
        $this->check = $check;
        $this->message = $reason;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     *
     * @return array
     */
    public function via($notifiable)
    {
        return [TelegramChannel::class];
    }

    public function toTelegram(TelegramRecipient $notifiable)
    {
        return TelegramMessage::create()
            ->to($notifiable->chat_id)// Optional.
            ->content(sprintf('*%s*: %s', $this->check->getName(), $this->message)); // Markdown supported.
    }
}
