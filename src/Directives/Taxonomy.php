<?php

namespace Edalzell\Blade\Directives;

use Edalzell\Blade\Concerns\IsDirective;
use Statamic\Facades\Term;

class Taxonomy
{
    use IsDirective;

    public $directive = 'taxonomy';
    public $key = 'term';
    public $type = 'loop';
    public $method = 'handle';

    public function handle(string $handle)
    {
        return $this->getAugmentedValue(Term::whereTaxonomy($handle));
    }
}
