<?php

namespace GeekCms\Menu\Providers;

use GeekCms\Menu\Libs\Facade;
use GeekCms\Menu\Libs\MenuBuilder;
use GeekCms\PackagesManager\Support\ServiceProvider as MainServiceProvider;
use Illuminate\Support\Facades\Blade;

/**
 * Class InitServiceProvider.
 */
class InitServiceProvider extends MainServiceProvider
{
    /**
     * {@inheritdoc}
     */
    public function boot()
    {
        parent::boot();
        $this->app->instance(\MenuBuilder::class, function () {
            return new MenuBuilder();
        });

        class_alias(Facade::class, 'MenuBuilder');
    }

    /**
     * {@inheritdoc}
     */
    public function registerBladeDirective()
    {
        Blade::directive($this->name, function ($arguments) {
            list($name, $layout) = explode(',', str_replace(['(', ')', ' ', "'"], '', $arguments));

            return "<?php 
                        echo \\View::make('{$layout}')
                            ->with('{$this->name}', \\MenuBuilder::get('{$name}'))
                            ->render(); 
                    ?>";
        });
    }
}
