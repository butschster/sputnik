<?php

namespace Domain\SourceProvider\ValueObjects;

class SourceProvider
{
    /**
     * @var string
     */
    protected $type;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var array
     */
    protected $scopes;

    /**
     * @var string|null
     */
    protected $icon;

    /**
     * @param string $type
     * @param array $scopes
     * @param string|null $icon
     */
    public function __construct(string $type, array $scopes = [], ?string $icon = null)
    {
        $this->type = $type;
        $this->scopes = $scopes;
        $this->icon = $icon;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName(): string
    {
        return trans('auth.provider.' . $this->getType());
    }

    /**
     * Get scopes
     *
     * @return array
     */
    public function getScopes(): array
    {
        return $this->scopes;
    }

    /**
     * Get icon
     *
     * @return string
     */
    public function getIcon(): string
    {
        return $this->icon ?? 'fa-' . $this->getType();
    }

    /**
     * Compare with another source provider
     *
     * @param SourceProvider $provider
     *
     * @return bool
     */
    public function equal(SourceProvider $provider): bool
    {
        return $this->getType() === $provider->getType();
    }

    public function __toString()
    {
        return $this->getType();
    }

}
