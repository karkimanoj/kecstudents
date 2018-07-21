<?php

namespace App\Observers;

use App\Post;

class PostObserver
{
    /**
     * Listen to the User created event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function saving(Post $post)
    {   
       

        $sliced_content = implode(' ', array_slice(explode(' ', strip_tags($post->content)), 0, 15));
        

        $slug = str_slug($sliced_content);
        $counter = 1;
        while(Post::where('slug', $slug)->first())
        {
            $slug = $slug.'-'.$counter;
            $counter++;
        }

        $post->slug = $slug;
        //dd('aaaaa');
    }

    /**
     * Listen to the User deleting event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function deleting(Event1 $event)
    {
        //
    }
}