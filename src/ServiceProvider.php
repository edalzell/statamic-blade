<?php

namespace Edalzell\Blade;

use Statamic\Providers\AddonServiceProvider;

class ServiceProvider extends AddonServiceProvider
{
    public function boot()
    {
        parent::boot();

        $this->bootDirectives();
    }

    private function bootDirectives()
    {
        foreach ($this->app['files']->files(__DIR__.'/Directives') as $file) {
            $fqcn = "Facades\\Edalzell\\Blade\\Directives\\{$file->getBasename('.php')}";
            $fqcn::boot();
        }
    }
}
