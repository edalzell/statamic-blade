<?php

namespace Edalzell\Blade\Directives;

use Edalzell\Blade\Concerns\IsDirective;
use Illuminate\Support\Facades\Blade;
use Statamic\Sites\Sites;
use Statamic\Support\Arr;

class Site
{
    use IsDirective;

    protected string $directive = 'site';
    protected string $key = 'site';
    protected string $type = 'both';
    protected string $method = 'handle';

    public function handle()
    {
        return $this->getAugmentedValue($this->site());
    }

    public function handleKey(string $key = null)
    {
        return Arr::get($this->getAugmentedValue($this->site()), $key);
    }

    public function bootBoth()
    {
        Blade::directive(
            $this->directive,
            function ($expression) {
                if ($expression) {
                    return $this->asString(get_class($this), "{$this->method}Key", $expression);
                }

                return $this->asArray($this->key, get_class($this), $this->method, $expression);
            }
        );

        Blade::directive(
            "end{$this->directive}",
            fn () => $this->endAsArray($this->key)
        );
    }

    private function site()
    {
        return app(Sites::class)->current();
    }
}
