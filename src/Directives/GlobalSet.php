<?php

namespace Edalzell\Blade\Directives;

use Statamic\Facades\GlobalSet as GlobalSetAPI;

class Globalset
{
    public function handle(string $handle, string $key = null)
    {
        if (! $key) {
            return ['globalset', GlobalSetAPI::findByHandle($handle)->inCurrentSite()->data()->all()];
        }

        return ['key', GlobalSetAPI::findByHandle($handle)->inCurrentSite()->get($key)];
    }
}
