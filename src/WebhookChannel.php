<?php

namespace NotificationChannels\Webhook;

use GuzzleHttp\Client;
use Illuminate\Support\Arr;
use NotificationChannels\Webhook\Exceptions\CouldNotSendNotification;
use Illuminate\Notifications\Notification;

class WebhookChannel
{
    /** @var Client */
    protected $client;

    /**
     * The request data key.
     *
     * @var string
     */
    public $dataKey;

    /**
     * Encode data as JSON.
     *
     * @var bool
     */
    public $encodeAsJSON;

    /**
     * @param Client $client
     */
    public function __construct(Client $client, $key = 'data', $json = true)
    {
        $this->client = $client;
        $this->dataKey = $key;
        $this->encodeAsJSON = $json;
    }

    /**
     * Send the given notification.
     *
     * @param mixed $notifiable
     * @param \Illuminate\Notifications\Notification $notification
     *
     * @throws \NotificationChannels\Webhook\Exceptions\CouldNotSendNotification
     */
    public function send($notifiable, Notification $notification)
    {
        if (! $url = $notifiable->routeNotificationFor('Webhook')) {
            return;
        }

        $webhookData = $notification->toWebhook($notifiable)->toArray();

        $key = Arr::get($webhookData, 'dataKey') ?: $this->dataKey;
        $data = Arr::get($webhookData, 'data');
        if ($this->encodeAsJSON === true) {
            $data = json_encode($data);
        }

        $response = $this->client->post($url, [
            $key => $data,
            'verify' => false,
            'headers' => Arr::get($webhookData, 'headers'),
        ]);

        if ($response->getStatusCode() >= 300 || $response->getStatusCode() < 200) {
            throw CouldNotSendNotification::serviceRespondedWithAnError($response);
        }
    }
}
