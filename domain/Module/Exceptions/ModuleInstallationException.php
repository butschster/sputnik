<?php

namespace Domain\Module\Exceptions;

use App\Models\Server\Module;

class ModuleInstallationException extends \RuntimeException
{
    /**
     * @param Module $module
     * @param \Exception $e
     * @return static
     */
    public static function for(Module $module, \Exception $e)
    {
        return new static(sprintf('Module %s was not installed', $module->name), 0, $e);
    }
}