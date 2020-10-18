<?php

namespace Edalzell\Blade\Directives;

use Statamic\Sites\Sites;
use Statamic\Support\Arr;

class Site
{
    public function handleKey(string $key = null)
    {
        return Arr::get(app(Sites::class)->current()->augmentedArrayData(), $key);
    }

    public function handle()
    {
        return app(Sites::class)->current()->augmentedArrayData();
    }
}
