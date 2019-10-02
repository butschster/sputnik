<?php

namespace App\Server\Modules;

use App\Contracts\Server\Module;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class Builder
{
    /**
     * @var array
     */
    protected $data;

    /**
     * @param array $data
     * @return Module
     */
    public static function buildFromArray(array $data): Module
    {
        return (new static($data))->build();
    }

    /**
     * @param array $data
     */
    protected function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * @return Module
     */
    public function build(): Module
    {
        return new class(
            $this->data['title'],
            $this->data['key'],
            Arr::get($this->data, 'categories', []),
            Arr::get($this->data, 'dependencies', []),
            Arr::get($this->data, 'conflicts', []),
            Arr::except($this->data, ['title', 'key', 'categories', 'categories', 'actions']),
            Arr::get($this->data, 'actions', [])
        ) extends \App\Server\Module
        {
            protected $title;
            protected $key;
            protected $categories;
            protected $dependencies;
            protected $actions;
            protected $meta;
            /**
             * @var array
             */
            protected $conflicts;

            public function __construct(string $title, string $key, array $categories, array $dependencies, array $conflicts, array $meta, array $actions)
            {
                $this->title = $title;
                $this->key = $key;
                $this->categories = $categories;
                $this->dependencies = $dependencies;
                $this->meta = $meta;
                $this->conflicts = $conflicts;
                $this->actions = $this->buildActions($actions);
            }

            public function title(): string
            {
                return $this->title;
            }

            public function key(): string
            {
                return $this->key;
            }

            public function meta(): array
            {
                return $this->meta;
            }

            public function categories(): array
            {
                return $this->categories;
            }

            public function dependencies(): array
            {
                return $this->dependencies;
            }

            public function conflicts(): array
            {
                return $this->conflicts;
            }

            public function actions(): array
            {
                return $this->actions;
            }

            /**
             * @param array $actions
             * @return array
             */
            protected function buildActions(array $actions): array
            {
                return collect($actions)->mapWithKeys(function ($data, $key) {
                    if (is_string($data)) {
                        $data = ['script_view' => $data];
                    }

                    $data['name'] = Str::title($key) . ' ' . $this->title();

                    return [$key => $this->buildAction($key, $data)];
                })->all();
            }

            /**
             * @param string $key
             * @param array $data
             * @return \App\Contracts\Server\Modules\Action
             */
            protected function buildAction(string $key, array $data): \App\Contracts\Server\Modules\Action
            {
                $action = new Action(
                    $this, $key, $data['name'], $data['script_view'], Arr::get($data, 'callbacks', [])
                );

                if (isset($data['extensions'])) {
                    foreach ($data['extensions'] as $extension) {
                        $action->registerExtension(
                            app($extension)
                        );
                    }
                }

                return $action;
            }
        };
    }
}