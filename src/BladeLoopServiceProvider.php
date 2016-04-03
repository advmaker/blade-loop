<?php

namespace Advmaker\BladeLoop;

use Illuminate\Support\ServiceProvider;
use Illuminate\View\Compilers\BladeCompiler;

class BladeLoopServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('blade.loop', LoopFactory::class);

        $this->app->extend('blade.compiler', function ($blade) {
            return $this->extendBladeEngine($blade);
        });
    }

    /**
     * Extend blade by new directives.
     *
     * @param  BladeCompiler $blade
     *
     * @return BladeCompiler
     */
    public function extendBladeEngine(BladeCompiler $blade)
    {
        $directives = $this->app->make('files')->getRequire(__DIR__ . '/directives.php');

        foreach ($directives as $name => $directive) {
            $blade->extend(function ($value) use ($directive) {
                return preg_replace($directive['pattern'], $directive['replacement'], $value);
            });
        }

        return $blade;
    }
}
