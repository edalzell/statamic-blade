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
        Blade::directive('bard', function ($expression) {
            return "<?php foreach (Facades\Edalzell\Blade\Directives\Bard::handle(${expression}) as \$set) { ?>";
        });

        Blade::directive('endbard', function () {
            return '<?php } ?>';
        });
    }

    private function bootCollection()
    {
        Blade::directive('collection', function ($expression) {
            return "<?php foreach (Facades\Edalzell\Blade\Directives\Collection::handle(${expression}) as \$entry) { ?>";
        });

        Blade::directive('endcollection', function () {
            return '<?php } ?>';
        });
    }
}
