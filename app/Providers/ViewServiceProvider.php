<?php

namespace App\Providers;

use Illuminate\View\FileViewFinder;
use Illuminate\View\ViewServiceProvider as ConcreteViewServiceProvider;

class ViewServiceProvider extends ConcreteViewServiceProvider
{
    /**
     * Register the view finder implementation.
     *
     * @return void
     */
    public function registerViewFinder()
    {
        $this->app->bind('view.finder', function ($app) {
            $paths = $app['config']['view.paths'];
			
			$template = $app['config']['view.template'];

            //change your paths here
            foreach ($paths as &$path)
            {
                $path .= '/'.$template;
            }
            return new FileViewFinder($app['files'], $paths);
        });
    }
}