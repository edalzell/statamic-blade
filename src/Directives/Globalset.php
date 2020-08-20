<?php

namespace Edalzell\Blade\Directives;

use Statamic\Facades\GlobalSet as GlobalSetAPI;

class GlobalSet
{
    public function handleKey(string $handle, string $key = null)
    {
        return GlobalSetAPI::findByHandle($handle)->inCurrentSite()->get($key);
    }

    public function handleSet(string $handle)
    {
        return GlobalSetAPI::findByHandle($handle)->inCurrentSite()->data()->all();
    }
}
