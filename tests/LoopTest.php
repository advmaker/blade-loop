<?php

namespace Advmaker\BladeLoop;

use Advmaker\BladeLoop\Support\Foo;
use Illuminate\Support\Collection;
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
     * Clear compiled views.
     * 
     * @param $files
     * @param $path
     */
    private function clearViewsCache($files, $path)
    {
        foreach ($files->files($path) as $file) {
            $files->delete($file);
        }
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

    public function testFirstAndLast()
    {
        $this->assertEquals('1;5;', view('first_and_last', ['arr' => range(1, 5)])->render());
    }

    public function testLoopWithCollection()
    {
        $collection = new Collection(range(0, 5));
        $i = 0;

        $loop = $this->app['blade.loop']->newLoop($collection);
        foreach ($loop->getItems() as $item) {
            $loop = $this->app['blade.loop']->loop();
            $this->assertEquals($i, $loop->index);
            $this->assertEquals(6-$i, $loop->revindex1);
            $this->assertEquals(6, $loop->length);
            $i++;
        }
        $this->app['blade.loop']->endLoop($loop);
    }

    public function testLoopWithObject()
    {
        $obj = new \stdClass();
        $obj->foo = 1;
        $obj->bar = 2;
        $loop = $this->app['blade.loop']->newLoop($obj);
        foreach ($loop->getItems() as $p) {
            $loop = $this->app['blade.loop']->loop();
            $this->assertEquals($p, $loop->index1);
            $this->assertEquals(null, $loop->length);
        }
        $this->app['blade.loop']->endLoop($loop);
    }

    public function testLoopWithCountableIteratorAggregate()
    {
        $obj = new Foo(range(0, 5));

        $loop = $this->app['blade.loop']->newLoop($obj);
        foreach ($loop->getItems() as $p) {
            $loop = $this->app['blade.loop']->loop();
            $this->assertEquals($p, $loop->index);
            $this->assertEquals(6, $loop->length);
        }

        $this->app['blade.loop']->endLoop($loop);
    }

    public function testLoopByDatePeriod()
    {
        $period = new \DatePeriod(new \DateTime('2015-01-28'), new \DateInterval('P1D'), new \DateTime('2015-02-02'));

        $result = <<<'EOT'
1: 2015-01-28
2: 2015-01-29
3: 2015-01-30
4: 2015-01-31
5: 2015-02-01

EOT;
        $this->assertEquals($result, view('loop_by_period', compact('period'))->render());
    }
}
