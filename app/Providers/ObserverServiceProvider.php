<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Event1;
use App\Post;
use App\Observers\Event1Observer;
use App\Observers\PostObserver;

class ObserverServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.y
     *
     * @return void
     */
    public function boot()
    {
        Event1::observe(Event1Observer::class);
        Post::observe(PostObserver::class);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
