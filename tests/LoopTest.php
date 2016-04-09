<?php

namespace Advmaker\BladeLoop;

use Orchestra\Testbench\TestCase;

class LoopTest extends TestCase
{
    protected function getPackageProviders($app)
    {
        return ['Advmaker\BladeLoop\BladeLoopServiceProvider'];
    }

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('view.paths', [__DIR__ . '/views']);
    }

    /**
     * Test that true does in fact equal true
     */
    public function testSimpleLoop()
    {
        $result = <<<'EOT'
0=0
1=1
2=2
3=3
4=4
5=5

EOT;
        $this->assertEquals($result, \View::make('loop')->render());
    }

    public function testInlineLoop()
    {
        $result = '1=1;2=2;3=3;4=4;5=5;';
        $this->assertEquals($result, \View::make('inline_loop')->render());
    }
}
