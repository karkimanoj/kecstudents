<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Event1;
use App\Event1Member;
use App\Post;
use App\Project;
use App\Observers\Event1Observer;
use App\Observers\PostObserver;
use App\Observers\Event1MemberObserver;
use App\Observers\ProjectObserver;

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
        Event1Member::observe(Event1MemberObserver::class);
        Project::observe(ProjectObserver::class);
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
