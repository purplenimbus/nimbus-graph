<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\Tenant::class, function (Faker $faker) {
    return [
        'name' => $faker->company,
    ];
});

$factory->define(App\User::class, function (Faker $faker) {
    return [
        'fname' => $faker->name,
        'lname' => $faker->name,
        'email' => $faker->email,
        'address' => $faker->address,
		'image_url' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQi1SYU1kgu3FtGlMpm5W7K2zuZHLgBQZzf34TQ3_Qe8LUd8s5C'
    ];
});

$factory->define(App\Activity::class, function (Faker $faker) {
	$types =	[
		[
			'type' => 'course',
			'action' => [
				'type' 	=> 'registration',
				'verb'	=> 'registered for'
			],
		],[
			'type' => 'content',
			'action' => [
				'type' 	=> 'like',
				'verb'	=> 'liked'
			],
		],[
			'type' => 'content',
			'action' => [
				'type' 	=> 'share',
				'verb'	=> 'shared'
			],
		]
	];
	
	$rand_type_index = mt_rand(0,sizeof($types) - 1);
	
	$data = [
        'meta' => [
			'subject' => [
				'name' => $faker->sentence(6,true),
				'url' => '#',
				'description' => $faker->text(200),
				//'images' => [],
			]
		]
    ];
	
	$data['meta']['action'] = $types[$rand_type_index]['action'];
	
	$data['meta']['subject']['type'] = $types[$rand_type_index]['type'];
	
	if($types[$rand_type_index]['action']['type'] == 'share' || $types[$rand_type_index]['action']['type'] == 'like'){	
		$data['meta']['subject']['featuredImage'] = 'https://images.pexels.com/photos/239908/pexels-photo-239908.jpeg?h=350&auto=compress&cs=tinysrgb'; 
	}
	
    return $data;
});