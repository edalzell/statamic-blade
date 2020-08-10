<?php

namespace Edalzell\Blade;

use Illuminate\Support\Facades\Blade;
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
        $this->bootBard();
        $this->bootCollection();
    }

    private function bootBard()
    {
        Blade::directive(
            'bard',
            fn ($expression) => $this->startPHP("foreach (Facades\Edalzell\Blade\Directives\Bard::handle(${expression}) as \$sets)")
        );

        Blade::directive('endbard', fn () => $this->endPHP());
    }

    private function bootCollection()
    {
        Blade::directive(
            'collection',
            fn ($expression) => $this->startPHP("foreach (Facades\Edalzell\Blade\Directives\Collection::handle(${expression}) as \$entry)")
        );

        Blade::directive('endcollection', fn () => $this->endPHP());
    }

    private function startPHP($php)
    {
        return "<?php {$php} { ?>";
    }

    private function endPHP()
    {
        return '<?php } ?>';
    }
}
