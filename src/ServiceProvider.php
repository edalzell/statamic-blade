<?php

namespace Edalzell\Blade;

use Edalzell\Blade\Directives\Bard;
use Edalzell\Blade\Directives\Collection;
use Edalzell\Blade\Directives\Glide;
use Edalzell\Blade\Directives\GlobalSet;
use Edalzell\Blade\Directives\Nav;
use Edalzell\Blade\Directives\Site;
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
        $this->bootNav();
        $this->bootSite();
    }

    private function bootBard()
    {
        Blade::directive(
            'bard',
            fn ($expression) => $this->asLoop(Bard::class, 'handle', $expression, 'set')
        );

        Blade::directive('endbard', fn () => $this->endAsLoop());
    }

    private function bootCollection()
    {
        Blade::directive(
            'collection',
            fn ($expression) => $this->asLoop(Collection::class, 'handle', $expression, 'entry')
        );

        Blade::directive('endcollection', fn () => $this->endAsLoop());
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
                    return $this->asString(GlobalSet::class, 'handleKey', $expression);
                }

                return $this->asArray('globalset', GlobalSet::class, 'handleSet', $expression);
            }
        );

        Blade::directive(
            'endglobalset',
            fn () => $this->endAsArray('globalset')
        );
    }

    private function bootNav()
    {
        Blade::directive(
            'nav',
            fn ($expression) => $this->asLoop(Nav::class, 'handleNav', $expression, 'item')
        );

        Blade::directive(
            'endnav',
            fn () => $this->endAsLoop('nav')
        );
    }

    private function bootSite()
    {
        Blade::directive(
            'site',
            function ($expression) {
                if ($expression) {
                    return $this->asString(Site::class, 'handleKey', $expression);
                }

                return $this->asArray('site', Site::class, 'handle');
            }
        );

        Blade::directive(
            'endsite',
            fn () => $this->endAsArray('site')
        );
    }

    private function asArray($key, $class, $method, $params = null)
    {
        return $this->php("extract($${key} = Facades\\${class}::${method}(${params}));");
    }

    private function asString($class, $method, $params)
    {
        return $this->php("echo Facades\\${class}::${method}(${params});");
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

    private function asLoop($class, $method, $params, $as)
    {
        return $this->php("foreach(Facades\\${class}::${method}(${params}) as $${as}) {");
    }

    private function endAsLoop()
    {
        return $this->php('}');
    }

    private function php($php)
    {
        return "<?php {$php} ?>";
    }
}
