<?php

namespace App\Server\Modules\PHP;

use App\Meta\Fields\MultiSelect;
use App\Server\Module as BaseModule;
use App\Contracts\Server\Modules\Configuration;

abstract class Module extends BaseModule
{
    /**
     * @return string
     */
    abstract public function version(): string;

    /**
     * Get module title
     * @return string
     */
    public function title(): string
    {
        return 'PHP ' . $this->humanReadableVersion();
    }

    /**
     * Get current version of PHP
     * @return string
     */
    public function humanReadableVersion(): string
    {
        return implode('.', str_split($this->version()));
    }

    /**
     * Get module key
     * @return string
     */
    public function key(): string
    {
        return 'php' . $this->version();
    }

    /**
     * @return array
     */
    protected function fields(): array
    {
        return [
            (new MultiSelect('modules', 'Modules', $this->availableModules()))
                ->addValidationRule('required')
                ->addValidationRule('array')
        ];
    }

    /**
     * @return array
     */
    public function defaultSettings(): array
    {
        return [
            'modules' => ['cli', 'dev', 'sqlite3', 'gd', 'curl', 'mbstring', 'xml', 'zip', 'bcmath', 'intl']
        ];
    }

    /**
     * @return array
     */
    public function availableModules(): array
    {
        return [
            'cli', 'dev', 'sqlite3', 'gd', 'curl', 'mbstring', 'xml', 'zip', 'bcmath', 'intl', 'ftp',
            'iconv', 'imap', 'ldap', 'mcrypt', 'mongodb', 'mysqli', 'pdo', 'apc', 'openssl', 'tidy', 'xsl',
            'sockets', 'libxml', 'ctype', 'dom'
        ];
    }

    /**
     * Get module configuration
     *
     * @return Configuration
     */
    public function configuration(): Configuration
    {
        return new \App\Server\Modules\PHP\Configuration($this);
    }
 }
