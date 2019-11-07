<?php

namespace Domain\Alert;

use App\Models\Server;
use Exception;

class Builder
{
    /**
     * @param Server $server
     * @param Exception $exception
     * @return Builder
     */
    public static function for(Server $server, Exception $exception): self
    {
        return new self($server, $exception);
    }

    /**
     * @var Server
     */
    protected $server;

    /**
     * @var Exception
     */
    protected $exception;

    /**
     * @var array
     */
    protected $meta;

    /**
     * @var string
     */
    protected $level = 'error';

    /**
     * @var string
     */
    protected $type = 'failed';

    /**
     * @var string
     */
    protected $message;

    /**
     * @param Server $server
     * @param Exception $exception
     */
    public function __construct(Server $server, Exception $exception)
    {
        $this->server = $server;
        $this->exception = get_class($exception);
        $this->message = $exception->getMessage();
    }

    /**
     * Set alert's type
     *
     * @param string $type
     * @return $this
     */
    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Set alert's additional data
     *
     * @param array $meta
     * @return $this
     */
    public function setMeta(array $meta): self
    {
        $this->meta = $meta;

        return $this;
    }

    /**
     * Set alert's level
     *
     * @param string $level
     * @return $this
     */
    public function setLevel(string $level): self
    {
        $this->level = $level;

        return $this;
    }

    /**
     * Store alert to the database
     *
     * @return Server\Alert
     */
    public function store(): Server\Alert
    {
        return $this->server->alerts()->create([
            'type' => $this->type,
            'exception' => $this->exception,
            'message' => $this->message,
            'meta' => $this->meta,
        ]);
    }
}