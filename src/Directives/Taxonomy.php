<?php

namespace Edalzell\Blade\Directives;

use Edalzell\Blade\Concerns\IsDirective;
use Statamic\Facades\Term;

class Taxonomy
{
    use IsDirective;

    protected string $directive = 'taxonomy';
    protected string $key = 'term';
    protected string $type = 'loop';
    protected string $method = 'handle';

    public function handle(string $handle)
    {
        return $this->getAugmentedValue(Term::whereTaxonomy($handle));
    }
}
