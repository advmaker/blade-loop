<?php

namespace Advmaker\BladeLoop;

use Illuminate\Contracts\Foundation\Application;
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

        $this->app->extend('blade.compiler', function (BladeCompiler $blade, Application $app) {
            $blade = $this->addLoopDirectives($blade);

            if (version_compare($app->version(), '5.2.21', '<')) {
                $blade = $this->addLoopControlDirectives($blade);
            }

            return $blade;
        });
    }

    /**
     * Extend blade by loop directives.
     *
     * @param  BladeCompiler $blade
     *
     * @return BladeCompiler
     */
    private function addLoopDirectives(BladeCompiler $blade)
    {
        $blade->extend(function ($value) {
            $pattern = '/(?<!\\w)(\\s*)@loop(?:\\s*)\\((.*)(?:\\sas\\s)([^)]*)\\)/';
            $replacement = <<<'EOT'
$1<?php
$loop = app('blade.loop')->newLoop($2);
foreach($loop->getItems() as $3):
    $loop = app('blade.loop')->loop();
?>
EOT;
            return preg_replace($pattern, $replacement, $value);
        });

        $blade->extend(function ($value) {
            $pattern = '/(?<!\\w)(\\s*)@endloop(\\s*)/';
            $replacement = <<<'EOT'
$1<?php
endforeach;
app('blade.loop')->endLoop($loop);
?>$2
EOT;
            return preg_replace($pattern, $replacement, $value);
        });

        return $blade;
    }

    /**
     * Extend blade by continue and break directives.
     *
     * @param  BladeCompiler $blade
     *
     * @return BladeCompiler
     */
    private function addLoopControlDirectives(BladeCompiler $blade)
    {
        $blade->extend(function ($value) {
            $pattern = '/(?<!\\w)(\\s*)@continue\\s*\\(([^)]*)\\)/';
            $replacement = '$1<?php if ($2) { continue; } ?>';

            return preg_replace($pattern, $replacement, $value);
        });

        $blade->extend(function ($value) {
            $pattern = '/(?<!\\w)(\\s*)@break\\s*\\(([^)]*)\\)/';
            $replacement = '$1<?php if ($2) { break; } ?>';

            return preg_replace($pattern, $replacement, $value);
        });

        return $blade;
    }
}
