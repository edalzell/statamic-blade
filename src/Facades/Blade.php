<?php

namespace Edalzell\Blade\Facades;

use Edalzell\Blade\Directives;
use Illuminate\Support\Facades\Facade;

/**
 * @method static mixed collection($expression)
 *
 * @see \Statamic\View\Blade\Directives
 */
class Blade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Directives::class;
    }
}
