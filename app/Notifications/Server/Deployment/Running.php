<?php

namespace App\Notifications\Server\Deployment;

use App\Models\Server\Deployment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class Running extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * @var Deployment
     */
    protected $deployment;

    /**
     * @param Deployment $deployment
     */
    public function __construct(Deployment $deployment)
    {
        $this->deployment = $deployment;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject("New deployment is running on your server {$this->deployment->server->name}")
            ->markdown('mail.server.deployment.running', [
                'server' => $this->deployment->server,
                'deployment' => $this->deployment,
            ]);
    }
}