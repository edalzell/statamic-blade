<?php

namespace Edalzell\Blade\Directives;

use Statamic\Tags\ArrayAccessor;
use Statamic\Tags\Structure;

class Nav extends Structure
{
    public function __construct()
    {
        // Because this extends the `structure` tag, have to fake the parameters
        // Can't use Parameter because that expects even more variables to be set
        // @TODO is there a nicer way to do this?
        $this->params = ArrayAccessor::make(['include_home' => false]);
    }

    public function handleNav(string $handle)
    {
        return $this->structure($handle);
    }
}
