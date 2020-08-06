<?php

namespace Edalzell\Blade\Tests;

use Edalzell\Blade\ServiceProvider;
use Orchestra\Testbench\TestCase as OrchestraTestCase;
use Statamic\Extend\Manifest;
use Statamic\Providers\StatamicServiceProvider;
use Statamic\Statamic;

class TestCase extends OrchestraTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->blade = app('blade.compiler');
    }

    protected function getPackageProviders($app)
    {
        return [StatamicServiceProvider::class, ServiceProvider::class];
    }

    protected function getPackageAliases($app)
    {
        return [
            'Statamic' => Statamic::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        parent::getEnvironmentSetUp($app);

        $app->make(Manifest::class)->manifest = [
            'edalzell/blade' => [
                'id' => 'edalzell/blade-directives',
                'namespace' => 'Edalzell\\Blade\\',
            ],
        ];
    }

    protected function resolveApplicationConfiguration($app)
    {
        parent::resolveApplicationConfiguration($app);

        $configs = ['assets', 'cp', 'forms', 'routes', 'static_caching', 'sites', 'stache', 'system', 'users'];

        foreach ($configs as $config) {
            $app['config']->set("statamic.$config", require __DIR__."/../vendor/statamic/cms/config/{$config}.php");
        }
    }

    // https://stevegrunwell.com/blog/custom-laravel-blade-directives/
    protected function assertDirectiveOutput($expected, $expression, $variables = [], $message = '')
    {
        $compiled = $this->blade->compileString($expression);

        ob_start();
        extract($variables);
        eval(' ?>'.$compiled.'<?php ');

        $output = ob_get_clean();

        $this->assertSame($expected, $output, $message);
    }
}
