<?php

namespace NotificationChannels\Webhook;

class WebhookMessage
{
    /**
     * The POST data of the Webhook request.
     *
     * @var mixed
     */
    protected $data;

    /**
     * The headers to send with the request.
     *
     * @var array|null
     */
    protected $headers;

    /**
     * The user agent header.
     *
     * @var string|null
     */
    protected $userAgent;

    /**
     * @param mixed $data
     *
     * @return static
     */
    public static function create($data = '')
    {
        return new static($data);
    }

    /**
     * @param mixed $data
     */
    public function __construct($data = '')
    {
        $this->data = $data;
    }

    /**
     * Set the Webhook data to be JSON encoded.
     *
     * @param mixed $data
     *
     * @return $this
     */
    public function data($data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Add a Webhook request custom header.
     *
     * @param string $name
     * @param string $value
     *
     * @return $this
     */
    public function header($name, $value)
    {
        $this->headers[$name] = $value;

        return $this;
    }

    /**
     * Set the Webhook request UserAgent.
     *
     * @param string $userAgent
     *
     * @return $this
     */
    public function userAgent($userAgent)
    {
        $this->headers['User-Agent'] = $userAgent;

        return $this;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'data' => $this->data,
            'headers' => $this->headers,
        ];
    }
}
