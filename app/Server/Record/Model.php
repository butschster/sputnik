<?php

namespace App\Server\Record;

use App\Contracts\Http\Request\Sanitizer\Factory as FactoryContract;
use Illuminate\Database\Eloquent\Concerns;
use Illuminate\Database\Eloquent\MassAssignmentException;

abstract class Model implements \App\Contracts\Server\Records\Model
{
    use Concerns\HasAttributes,
        Concerns\HidesAttributes,
        Concerns\GuardsAttributes;

    /**
     * The name of the "created at" column.
     *
     * @var string
     */
    const CREATED_AT = 'created_at';

    /**
     * The name of the "updated at" column.
     *
     * @var string
     */
    const UPDATED_AT = 'updated_at';

    /**
     * @param array $attributes
     * @return void
     */
    public function __construct(array $attributes = [])
    {
        $this->syncOriginal();

        $this->fill($attributes);
    }

    /**
     * Fill the model with an array of attributes.
     *
     * @param array $attributes
     *
     * @throws \Illuminate\Database\Eloquent\MassAssignmentException
     */
    public function fill(array $attributes): void
    {
        $attributes = $this->sanitize($attributes);

        $totallyGuarded = $this->totallyGuarded();

        foreach ($this->fillableFromArray($attributes) as $key => $value) {
            // The developers may choose to place some attributes in the "fillable" array
            // which means only those attributes may be set through mass assignment to
            // the model, and all others will just get ignored for security reasons.
            if ($this->isFillable($key)) {
                $this->setAttribute($key, $value);
            } elseif ($totallyGuarded) {
                throw new MassAssignmentException(sprintf(
                    'Add [%s] to fillable property to allow mass assignment on [%s].',
                    $key, get_class($this)
                ));
            }
        }
    }


    /**
     * Fill the model with an array of attributes. Force mass assignment.
     *
     * @param  array  $attributes
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function forceFill(array $attributes)
    {
        return static::unguarded(function () use ($attributes) {
            return $this->fill($attributes);
        });
    }

    /**
     * Sync the original attributes with the current.
     */
    public function syncOriginal(): void
    {
        $this->original = $this->attributes;
    }

    /**
     * Filters to be applied to the input.
     *
     * @return array
     */
    protected function filters(): array
    {
        return [];
    }

    /**
     * @param array $attributes
     * @return array
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    protected function sanitize(array $attributes): array
    {
        $filters = $this->filters();

        if (empty($filters)) {
            return $attributes;
        }

        $sanitizer = app(FactoryContract::class)->make($attributes, $this->filters());

        return $sanitizer->sanitize();
    }

    /**
     * @return bool
     */
    protected function usesTimestamps(): bool
    {
        return false;
    }

    /**
     * @return bool
     */
    public function getIncrementing(): bool
    {
        return false;
    }

    /**
     * {@inheritDoc}
     */
    public function getMetaAttributes(): array
    {
        return $this->getAttributes();
    }

    /**
     * {@inheritDoc}
     */
    public function toArray()
    {
        return array_merge(
            [
                'module' => $this->module(),
                'feature' => $this->feature(),
                'key' => $this->key()
            ],
            $this->attributesToArray()
        );
    }
}