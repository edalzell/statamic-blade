<?php

namespace Edalzell\Blade\Tests\Unit;

use Edalzell\Blade\Tests\TestCase;

class DirectivesTest extends TestCase
{
    /** @test */
    public function does_display_collection_correctly()
    {
        $blade = "@collection('foo')";
        $expected = "<?php foreach(Facades\Edalzell\Blade\Directives\Collection::handle('foo') as \$entry) { ?>";

        $this->assertSame($expected, $this->blade->compileString($blade));
    }

    /** @test */
    public function does_display_bard_correctly()
    {
        $blade = '@bard([])';
        $expected = "<?php foreach(Facades\Edalzell\Blade\Directives\Bard::handle([]) as \$set) { ?>";

        $this->assertSame($expected, $this->blade->compileString($blade));
    }

    /** @test */
    public function does_display_bard_with_many_fields_in_set_correctly()
    {
        $blade = "@bard([['type' => 'image', 'content' => ['src' => 'an-image-url', 'alt' => 'An alternative text']]])";
        $expected = "<?php foreach(Facades\Edalzell\Blade\Directives\Bard::handle([['type' => 'image', 'content' => ['src' => 'an-image-url', 'alt' => 'An alternative text']]]) as \$set) { ?>";

        $this->assertSame($expected, $this->blade->compileString($blade));
    }
}
