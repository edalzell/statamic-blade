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
        Blade::directive('collection', function ($expression) {
            return "<?php foreach (Edalzell\Blade\Facades\Blade::collection(${expression}) as \$entry) { ?>";
        });

        Blade::directive('endcollection', function () {
            return '<?php } ?>';
        });
    }
}
