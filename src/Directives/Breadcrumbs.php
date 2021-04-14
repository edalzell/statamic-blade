<?php

namespace Edalzell\Blade\Directives;

use Edalzell\Blade\Concerns\IsDirective;
use Statamic\Facades\Antlers;
use Statamic\Facades\Data;
use Statamic\Facades\Site;
use Statamic\Facades\URL;
use Statamic\Support\Str;
use Statamic\Tags\Nav as NavTag;

class Breadcrumbs extends NavTag
{
    use IsDirective;

    protected string $directive = 'breadcrumbs';
    protected string $key = 'item';
    protected string $type = 'loop';
    public $method = 'handleBreadcrumbs';

    public function handleBreadcrumbs(array $params = [])
    {
        $this->setParser(Antlers::parser());
        $this->setContext([]);
        $this->setParameters($params);

        return $this->breadcrumbs();
    }

    public function breadcrumbs()
    {
        $currentUrl = URL::makeAbsolute(URL::getCurrent());
        $url = Str::removeLeft($currentUrl, Site::current()->absoluteUrl());
        $url = Str::ensureLeft($url, '/');
        $segments = explode('/', $url);
        $segments[0] = '/';

        if (! $this->params->bool('include_home', true)) {
            array_shift($segments);
        }

        $crumbs = collect($segments)->map(function () use (&$segments) {
            $uri = URL::tidy(join('/', $segments));
            array_pop($segments);

            return $uri;
        })->mapWithKeys(function ($uri) {
            $uri = Str::ensureLeft($uri, '/');

            return [$uri => Data::findByUri($uri, Site::current()->handle())];
        })->filter();

        if (! $this->params->bool('reverse', false)) {
            $crumbs = $crumbs->reverse();
        }

        if ($this->params->bool('trim', true)) {
            $this->content = trim($this->content);
        }

        $crumbs = $crumbs->values()->map(function ($crumb) {
            $crumb->setSupplement('is_current', URL::getCurrent() === $crumb->url());

            return $crumb;
        });

        return $crumbs->toAugmentedArray();
    }
}
