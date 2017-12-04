<?php

use Illuminate\Database\Seeder;
use GuzzleHttp\Client as GuzzleClient;

class DatabaseSeeder extends Seeder
{
    function __construct(){
		$this->guzzle = new GuzzleHttp\Client();
	}
	/**
     * Run the database seeds.
     *
     * @return void
     */
	public function run()
	{
		$admin 	=	factory(App\User::class,'admin',1)->create([
						'tenant_id' => 1,
						'image_url' =>	'https://www.victoria147.com/wp-content/uploads/2014/10/user-avatar-placeholder.png',
						'fname'		=>	'anthony',
						'lname'		=>	'akpan',
						'email'		=>	'anthony.akpan@hotmail.com',
						'password'	=>	app('hash')->make('easier')
					])->each(function($user){
						
						factory(App\Activity::class,5)
							->create([ 
								'user_id' => $user->id,
								'tenant_id' => $user->tenant_id,
							]);
						
					});
			
		$records = factory(App\Tenant::class, 1)
			->create()
			->each(function($tenant){
				
				factory(App\User::class,'student',10)
				->create([
					'tenant_id' => $tenant->id,
					'image_url' =>	'https://www.victoria147.com/wp-content/uploads/2014/10/user-avatar-placeholder.png',
				])
				->each(function($user)use($tenant){
					
					//Get course list
					//$url = env('EDU_API').$tenant->id.'/courses';
					
					//$options = [	'form_params' =>	[ 'user_id' => $user->id , 'grade' => $user->meta->grade ] ];
					
					//$response = $this->guzzle->request('POST',$url,$options);
					
					//register courses via edu api
					//$url = env('EDU_API').$tenant->id.'/registration';
					
					//$options = [	'form_params' =>	[ 'user_id' => $user->id , 'courses' => $courses ]	];
					
					//$response = $this->guzzle->request('POST',$url,$options);
					
					factory(App\Activity::class,5)
					->create([ 
						'user_id' => $user->id,
						'tenant_id' => $tenant->id,
						//'course_id' => $tenant->id,
					]);
					
				});
				
				factory(App\User::class,'teacher',5)
				->create([
					'tenant_id' => $tenant->id,
					'image_url' =>	'https://www.victoria147.com/wp-content/uploads/2014/10/user-avatar-placeholder.png',
				])
				->each(function($user)use($tenant){
					
					//Get course list
					//$url = env('EDU_API').$tenant->id.'/courses';
					
					//$options = [	'form_params' =>	[ 'user_id' => $user->id , 'grade' => $user->meta->grade ] ];
					
					//$response = $this->guzzle->request('POST',$url,$options);
					
					//register courses via edu api
					//$url = env('EDU_API').$tenant->id.'/registration';
					
					//$options = [	'form_params' =>	[ 'user_id' => $user->id , 'courses' => $courses ]	];
					
					//$response = $this->guzzle->request('POST',$url,$options);
					
					factory(App\Activity::class,5)
					->create([ 
						'user_id' => $user->id,
						'tenant_id' => $tenant->id,
						//'course_id' => $tenant->id,
					]);
					
				});

			});
		
	}
}
