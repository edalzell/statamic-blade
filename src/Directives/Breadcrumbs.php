<?php

namespace Edalzell\Blade\Directives;

use Edalzell\Blade\Concerns\IsDirective;
use Statamic\Facades\Antlers;
use Statamic\Tags\Structure;

class Breadcrumbs extends Structure
{
    use IsDirective;

    protected string $directive = 'breadcrumbs';
    protected string $key = 'variables';
    public $method = 'handleBreadcrumbs';
    protected string $type = 'loop';

    public function handleBreadcrumbs($context, $params = [])
    {
        $this->setParser(Antlers::parser());
        $this->setContext($context);
        $this->setParameters($params);

        return $this->breadcrumbs();
    }
}
