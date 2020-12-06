<?php

namespace Edalzell\Blade\Directives;

use Edalzell\Blade\Concerns\IsDirective;
use Statamic\Sites\Sites;
use Statamic\Support\Arr;

class Site
{
    use IsDirective;

    public $directive = 'site';
    public $key = 'site';
    public $type = 'both';
    public $method = 'handle';

    public function handle()
    {
        return $this->getAugmentedValue($this->site());
    }

    public function handleKey(string $key = null)
    {
        return Arr::get($this->getAugmentedValue($this->site()), $key);
    }

    private function site()
    {
        return app(Sites::class)->current();
    }
}
