<?php

namespace App\Http\Requests;

use App\Contracts\Http\Request\Formatter;
use Illuminate\Support\Arr;
use Illuminate\Validation\ValidationRuleParser;
use InvalidArgumentException;

class Sanitizer
{
    /**
     *  Data to sanitize
     * @var array
     */
    protected $data;

    /**
     *  Filters to apply
     * @var array
     */
    protected $rules;

    /**
     * @var array
     */
    protected $filters;

    /**
     * @param array $data
     * @param array $rules Rules to be applied to each data attribute
     * @param array $filters
     */
    public function __construct(array $data, array $rules, array $filters)
    {
        $this->data = $data;
        $this->rules = $this->parseRulesArray($rules);
        $this->filters = $filters;
    }

    /**
     * Parse a rules array.
     *
     * @param array $rules
     * @return array
     */
    protected function parseRulesArray(array $rules)
    {
        $parsedRules = [];

        $rawRules = (new ValidationRuleParser($this->data))->explode($rules);

        foreach ($rawRules->rules as $attribute => $attributeRules) {
            foreach ($attributeRules as $attributeRule) {
                $parsedRule = $this->parseRuleString($attributeRule);
                if ($parsedRule) {
                    $parsedRules[$attribute][] = $parsedRule;
                }
            }
        }

        return $parsedRules;
    }

    /**
     * Parse a rule string formatted as filterName:option1, option2
     * into an array formatted as [name => filterName, options => [option1, option2]]
     *
     * @param string $rule Formatted as 'filterName:option1, option2' or just 'filterName'
     * @return array Formatted as [name => filterName, options => [option1, option2]]. Empty array if no filter name was found.
     */
    protected function parseRuleString($rule): array
    {
        if (strpos($rule, ':') !== false) {
            list($name, $options) = explode(':', $rule, 2);
            $options = array_map('trim', explode(',', $options));
        } else {
            $name = $rule;
            $options = [];
        }
        if (!$name) {
            return [];
        }

        return compact('name', 'options');
    }

    /**
     *  Apply the given filter by its name
     * @param string $name
     * @param mixed $value
     * @param array $options
     * @return Formatter
     */
    protected function applyFilter(string $name, $value, array $options = [])
    {
        // If the filter does not exist, throw an Exception:
        if (!isset($this->filters[$name])) {
            throw new InvalidArgumentException("No filter found by the name of $name");
        }

        $filter = $this->filters[$name];
        if ($filter instanceof \Closure) {
            return call_user_func_array($filter, [$value, $options]);
        }

        return app($filter)->apply($value, $options);
    }

    /**
     * Sanitize the given data
     * @return array
     */
    public function sanitize(): array
    {
        $sanitized = $this->data;

        foreach ($this->rules as $attr => $rules) {
            if (Arr::has($this->data, $attr)) {
                $value = Arr::get($this->data, $attr);

                foreach ($rules as $rule) {
                    $value = $this->applyFilter($rule['name'], $value, $rule['options']);
                }

                Arr::set($sanitized, $attr, $value);
            }
        }

        return $sanitized;
    }

    /**
     *  Sanitize the given attribute
     *
     * @param string $attribute Attribute name
     * @param mixed $value Attribute value
     * @return mixed Sanitized value
     */
    protected function sanitizeAttribute(string $attribute, $value)
    {
        if (isset($this->rules[$attribute])) {
            foreach ($this->rules[$attribute] as $rule) {
                $value = $this->applyFilter($rule['name'], $value, $rule['options']);
            }
        }

        return $value;
    }
}