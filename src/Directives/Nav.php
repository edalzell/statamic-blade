<?php

namespace Edalzell\Blade\Directives;

use Edalzell\Blade\Concerns\IsDirective;
use Statamic\Tags\Structure;

class Nav extends Structure
{
    use IsDirective;

    protected string $directive = 'nav';
    protected string $key = 'item';
    public $method = 'handleNav';
    protected string $type = 'loop';

    public function handleNav(string $handle, $params = [])
    {
        return tag(
            'nav',
            array_merge(['handle'=>$handle], $params)
        );
    }
}
