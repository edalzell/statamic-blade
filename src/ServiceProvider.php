<?php

namespace Edalzell\Blade;

use Illuminate\Support\Facades\Blade;
use Statamic\Providers\AddonServiceProvider;

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
        $this->bootGlobal();
    }

    private function bootBard()
    {
        Blade::directive(
            'bard',
            fn ($expression) => $this->startPHPLoop("foreach (Facades\Edalzell\Blade\Directives\Bard::handle(${expression}) as \$set)")
        );

        Blade::directive('endbard', fn () => $this->endPHPLoop());
    }

    private function bootCollection()
    {
        Blade::directive(
            'collection',
            fn ($expression) => $this->startPHPLoop("foreach (Facades\Edalzell\Blade\Directives\Collection::handle(${expression}) as \$entry)")
        );

        Blade::directive('endcollection', fn () => $this->endPHPLoop());
    }

    private function bootGlobal()
    {
        Blade::directive(
            'globalset',
            fn ($expression) => '<?php
                list($type, $value) = Facades\Edalzell\Blade\Directives\GlobalSet::handle('.$expression.');
                if ($type == \'globalset\') {
                    extract($value);
                } else {
                    echo $value;
                }
            ?>'
        );

        Blade::directive(
            'endglobalset',
            fn () => '<?php
                if ($type == \'array\') {
                    foreach($globalset as $key => $value) {
                        unset($key);
                    }
                    unset($globalset);
                }
            ?>'
        );
    }

    private function startPHPLoop($php)
    {
        return "<?php {$php} { ?>";
    }

    private function endPHPLoop()
    {
        return '<?php } ?>';
    }
}
