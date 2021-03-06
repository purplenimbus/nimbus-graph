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
			
		$records = factory(App\Tenant::class, 1)
			->create()
			->each(function($tenant){
				
				factory(App\User::class,'student',7)
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
				
				factory(App\User::class,'teacher',2)
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
				
				factory(App\Transaction::class,'income',15)
				->create([
					'tenant_id' => $tenant->id,
				]);
				
				factory(App\Transaction::class,'expense',5)
				->create([
					'tenant_id' => $tenant->id,
				]);
			});
		
		$services = [
			[
				'name' => 'nimbus learning',
				"currency_id" => 1,
				'meta' => [
					'endpoint' => '',
					'cost' => 0,
					'rate' => 'monthly',
					'icon' => 'https://d30y9cdsu7xlg0.cloudfront.net/png/1134418-200.png',
					'description' => ''
				],
			],[
				'name' => 'nimbus HR',
				"currency_id" => 1,
				'meta' => [
					'endpoint' => '',
					'cost' => 0,
					'rate' => 'monthly',
					'icon' => 'https://d30y9cdsu7xlg0.cloudfront.net/png/1134418-200.png',
					'description' => ''
				],
			],[
				'name' => 'nimbus accounting',
				"currency_id" => 1,
				'meta' => [
					'endpoint' => '',
					'cost' => 0,
					'rate' => 'monthly',
					'icon' => 'https://d30y9cdsu7xlg0.cloudfront.net/png/1134418-200.png',
					'description' => ''
				],
			],[
				'name' => 'nimbus inventory',
				"currency_id" => 1,
				'meta' => [
					'endpoint' => '',
					'cost' => 0,
					'rate' => 'monthly',
					'icon' => 'https://d30y9cdsu7xlg0.cloudfront.net/png/1134418-200.png',
					'description' => ''
				],
			]
		];
		
		foreach($services as $service){
			App\Service::create($service);
		}
		
		$currencies = [
			[
				'short_name' => 'NGN',
				'long_name'  => 'naira',
				'symbol'	=>	'₦'
			]
		];
		
		foreach($currencies as $currency){
			App\Currency::create($currency);
		}
		
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
	}
}
