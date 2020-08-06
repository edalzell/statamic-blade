<?php

namespace Edalzell\Blade\Tests\Unit;

use Edalzell\Blade\Tests\TestCase;

class DirectivesTest extends TestCase
{
    /** @test */
    public function does_display_correctly()
    {
        $blade = "@collection('foo')";
        $expected = "<?php foreach (Edalzell\Blade\Facades\Blade::collection('foo') as \$entry) { ?>";

        $this->assertSame($expected, $this->blade->compileString($blade));
    }
}
