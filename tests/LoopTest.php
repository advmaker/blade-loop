<?php

namespace Advmaker\BladeLoop;

use Orchestra\Testbench\TestCase;

class LoopTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        if (version_compare($this->app->version(), '5.1', '<')) {
            $this->clearViewsCache($this->app['files'], $this->app['config']['view.compiled']);
        } else {
            $this->artisan('view:clear');
        }
    }

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
        $this->assertEquals($result, view('loop')->render());
    }

    public function testInlineLoop()
    {
        $result = '1=1;2=2;3=3;4=4;5=5;';
        $this->assertEquals($result, view('inline_loop')->render());
    }

    public function testContinueAndEven()
    {
        $result = <<<'EOT'
1=1
3=3
5=5

EOT;
        $this->assertEquals($result, view('continue_if_even')->render());
    }

    public function testInlineLoopAndContinueOdd()
    {
        $result = '0=0;2=2;4=4;';
        $this->assertEquals($result, view('continue_if_odd_inline')->render());
    }

    public function testLoopInLoop()
    {
        $result = '';
        $arr = range(0, 3);
        $arr_inner = range(1, 3);
        foreach ($arr as $i) {
            $result .= "{$i}={$i}\n";
            foreach ($arr_inner as $j) {
                $result .= "{$i}{$j}={$i}{$j}\n";
            }
            $temp = $i+1;
            $result .= "{$i}={$temp}\n";
        }

        $this->assertEquals($result, view('loop_in_loop', compact('arr', 'arr_inner'))->render());
    }

    private function clearViewsCache($files, $path)
    {
        foreach ($files->files($path) as $file) {
            $files->delete($file);
        }
    }
}
