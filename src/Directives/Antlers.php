<?php

namespace Edalzell\Blade\Directives;

use Illuminate\Support\Facades\Blade;

class Antlers
{
    public function boot()
    {
        Blade::directive('antlers', function ($expression) {
            return "<?php echo \Statamic\Facades\Antlers::parse({$expression}); ?>";
        });
    }
}
