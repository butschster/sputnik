<?php

namespace App\Modules;

use Illuminate\Foundation\PackageManifest;

class Manifest extends PackageManifest
{
    /**
     * @return array
     */
    public function getModulesComposerFilePaths(): array
    {
        $paths = [];

        foreach ($this->files->directories(modules_path()) as $directory) {
            $composer = $directory.DIRECTORY_SEPARATOR.'composer.json';

            if ($this->files->isFile($composer)) {
                $paths[] = $composer;
            }
        }

        return $paths;
    }

    /**
     * Build the manifest for modules and write it to disk.
     *
     * @return void
     */
    public function build()
    {
        $packages = [];

        foreach ($this->getModulesComposerFilePaths() as $path) {
            if ($this->files->exists($path)) {
                $packages[] = json_decode($this->files->get($path), true);
            }
        }

        $ignoreAll = in_array('*', $ignore = $this->packagesToIgnore());

        $this->write(collect($packages)->mapWithKeys(function ($package) {
            return [$this->format($package['name']) => $package['extra']['laravel'] ?? []];
        })->each(function ($configuration) use (&$ignore) {
            $ignore += $configuration['dont-discover'] ?? [];
        })->reject(function ($configuration, $package) use ($ignore, $ignoreAll) {
            return $ignoreAll || in_array($package, $ignore);
        })->filter()->all());
    }
}