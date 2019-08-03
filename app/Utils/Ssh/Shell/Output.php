<?php

namespace App\Utils\Ssh\Shell;

use Illuminate\Support\Str;

class Output
{
    /**
     * @var string
     */
    protected $output = '';

    /**
     * Invoke the class.
     *
     * @param string $type
     * @param string $line
     * @return void
     */
    public function __invoke($type, $line)
    {
        $this->output .= $line;
    }

    /**
     * Render the output as a string.
     *
     * @return string
     */
    public function __toString()
    {
        if (Str::startsWith($this->output, 'Warning:')) {
            $this->output = substr($this->output, strpos($this->output, "\n") + 1);
        }

        return trim($this->output);
    }
}
