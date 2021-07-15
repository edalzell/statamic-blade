<?php

namespace Edalzell\Blade\Augmentation;

use Edalzell\Blade\Concerns\AugmentsValues;
use Illuminate\View\View;
use Statamic\Statamic;

class AugmentedView extends View
{
    use AugmentsValues;

    public function gatherData(): array
    {
        $variables = parent::gatherData();

        if (!$this->isRouteServedByStatamic($variables)) {
            return $variables;
        }

        if (Statamic::isCpRoute()) {
            return $variables;
        }

        return array_map(function ($data) {
            return $this->getAugmentedValue($data);
        }, $variables);
    }

    private function isRouteServedByStatamic(array $variables): bool
    {
        return isset($variables['cp_url']);
    }
}
