<?php

namespace NotificationChannels\Webhook;

class WebhookMessage
{
    /** @var mixed */
    protected $data;

    /** @var array|null */
    protected $headers;

    /** @var string|null */
    protected $userAgent;

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
     * @param mixed $data
     *
     * @return static
     */
    public static function create($data = '', $key = 'data', $json = true)
    {
        return new static($data, $key, $json);
    }

    /**
     * @param mixed $data
     */
    public function __construct($data = '', $key = 'data', $json = true)
    {
        $this->data = $data;
        $this->dataKey = $key;
        $this->encodeAsJSON = $json;
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
