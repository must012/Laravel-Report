<?php

use Faker\Generator as Faker;

$factory->define(App\Post::class, function (Faker $faker) {
    return [
        //
        'writer'=>$faker->email,
        'name'=>'Admin',
        'title'=>sprintf('%s %s',str_random(5),str_random(5)),
        'content'=>sprintf('%s %s',str_random(13),str_random(13))
    ];
});
