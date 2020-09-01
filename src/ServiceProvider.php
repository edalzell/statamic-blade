<?php

namespace Edalzell\Blade;

use Edalzell\Blade\Directives\Glide;
use Illuminate\Support\Facades\Blade;
use Statamic\Providers\AddonServiceProvider;
use Statamic\Support\Str;

class ServiceProvider extends AddonServiceProvider
{
    protected $publishAfterInstall = false;

    public function boot()
    {
        parent::boot();

        $this->bootDirectives();
    }

    private function bootDirectives()
    {
        $this->bootBard();
        $this->bootCollection();
        $this->bootGlide();
        $this->bootGlobal();
    }

    private function bootBard()
    {
        Blade::directive(
            'bard',
            fn ($expression) => $this->startPHPLoop("Facades\Edalzell\Blade\Directives\Bard::handle(${expression})", 'set')
        );

        Blade::directive('endbard', fn () => $this->endPHPLoop());
    }

    private function bootCollection()
    {
        Blade::directive(
            'collection',
            fn ($expression) => $this->startPHPLoop("Facades\Edalzell\Blade\Directives\Collection::handle(${expression})", 'entry')
        );

        Blade::directive('endcollection', fn () => $this->endPHPLoop());
    }

    private function bootGlide()
    {
        Blade::directive(
            'glide',
            fn ($expression) => $this->asArray('glide', Glide::class, 'handle', $expression)
        );

        Blade::directive(
            'endglide',
            fn () => $this->endAsArray('glide')
        );
    }

    private function bootGlobal()
    {
        Blade::directive(
            'globalset',
            function ($expression) {
                if (Str::contains($expression, ',')) {
                    return $this->php('echo Facades\Edalzell\Blade\Directives\GlobalSet::handleKey('.$expression.');');
                }

                return $this->php('extract($globalset = Facades\Edalzell\Blade\Directives\GlobalSet::handleSet('.$expression.'));');
            }
        );

        Blade::directive(
            'endglobalset',
            fn () => $this->endAsArray('globalset')
        );
    }

    private function asArray($key, $class, $method, $params)
    {
        return $this->php("extract($${key} = Facades\\${class}::${method}(${params}));");
    }

    private function asString($class, $method, $params)
    {
        return $this->php("echo Facades\\${class}::${method}(${params}));");
    }

    private function endAsArray($variable)
    {
        return
            '<?php
                foreach($'.$variable.' as $key => $value) {
                    unset($key);
                }
                unset($'.$variable.');
            ?>';
    }

    private function startPHPLoop($arrayStatement, $as)
    {
        return $this->php("foreach(${arrayStatement} as $${as}) {");
    }

    private function endPHPLoop()
    {
        return $this->php('}');
    }

    private function php($php)
    {
        return "<?php {$php} ?>";
    }
}
