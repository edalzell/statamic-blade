<?php

namespace Edalzell\Blade\Augmentation;

use Illuminate\View\Factory;
use Illuminate\View\ViewServiceProvider;

class AugmentationViewServiceProvider extends ViewServiceProvider
{
    protected function createFactory($resolver, $finder, $events): Factory
    {
        return new AugmentationViewFactory($resolver, $finder, $events);
    }
}
