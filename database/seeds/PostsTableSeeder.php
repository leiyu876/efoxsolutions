<?php

use Illuminate\Database\Seeder;
use App\Post;
use App\User;


class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(User::all()->isEmpty()) {
            factory(App\User::class)->create();
        }

        $user = User::first();
        
        $user->posts()->saveMany( factory(App\Post::class, 200)->make() );
    }
}
