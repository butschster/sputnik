<?php

namespace App\Meta;

use App\Contracts\Meta\Field as FieldContract;
use App\Contracts\Meta\Formatter;
use App\Meta\Fields\Formatter\Text;
use Illuminate\Database\Eloquent\Builder;

abstract class Field implements FieldContract
{
    use Fields\Concerns\ValidationRules;

    /**
     * @var string
     */
    protected $key;

    /**
     * @var string
     */
    protected $title;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var Formatter
     */
    protected $formatter;

    /**
     * @param string $key
     * @param string $title
     * @param string $description
     */
    public function __construct(string $key, string $title, string $description = '')
    {
        $this->key = $key;
        $this->title = $title;
        $this->description = $description;
    }

    /**
     * {@inheritDoc}
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * {@inheritDoc}
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * {@inheritDoc}
     */
    public function getKey(): string
    {
        return $this->key;
    }

    /**
     * {@inheritDoc}
     */
    public function getMeta(): array
    {
        return [];
    }

    /**
     * {@inheritDoc}
     */
    public function getFormatter(): Formatter
    {
        return $this->formatter ?: new Text();
    }

    /**
     * @param Formatter $formatter
     *
     * @return $this
     */
    public function setFormatter(Formatter $formatter)
    {
        $this->formatter = $formatter;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function prepareValue($value)
    {
        return $value;
    }

    /**
     * {@inheritDoc}
     */
    public function toArray()
    {
        return [
            'key' => $this->getKey(),
            'title' => $this->getTitle(),
            'description' => $this->getDescription(),
            'type' => class_basename($this),
            'meta' => $this->getMeta()
        ];
    }
}
