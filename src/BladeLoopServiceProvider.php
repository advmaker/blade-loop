<?php

namespace Advmaker\BladeForeachExtend;

use Illuminate\Support\ServiceProvider;

class BladeLoopServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $directives = $this->app->make('files')->getRequire( __DIR__ . '/directives.php');

        /** @var \Illuminate\View\Compilers\BladeCompiler $blade */
        $blade  = $this->app->make('view')->getEngineResolver()->resolve('blade')->getCompiler();

        $this->app->singleton('blade.loop', LoopFactory::class);
        foreach ($directives as $name => $directive) {
            $blade->extend(function ($value) use ($directive) {
                return preg_replace($directive[ 'pattern' ], $directive[ 'replacement' ], $value);
            });
        }
    }
}