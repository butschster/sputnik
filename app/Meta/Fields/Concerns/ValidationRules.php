<?php

namespace App\Meta\Fields\Concerns;

trait ValidationRules
{
    /**
     * @var array
     */
    protected $rules = [];

    /**
     * get validation rules
     *
     * @return array
     */
    public function getValidationRules(): array
    {
        return $this->rules;
    }

    /**
     * Set validation rules
     *
     * @param array ...$validationRules
     *
     * @return $this
     */
    public function setValidationRules(...$validationRules)
    {
        $this->rules = [];
        foreach ($validationRules as $rule) {
            $rules = explode('|', $rule);

            foreach ($rules as $rule) {
                $this->addValidationRule($rule);
            }
        }

        return $this;
    }

    /**
     * Add new validation rule
     *
     * @param string $rule
     *
     * @return $this
     */
    public function addValidationRule(string $rule)
    {
        $this->rules[] = $rule;

        return $this;
    }
}
