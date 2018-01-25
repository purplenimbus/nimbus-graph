<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use App\User as User;
use App\Activity as Activity;
use App\Tenant as Tenant;
use App\Transaction as Transaction;
use App\Service as Service;
use App\Http\Requests\StoreTenant as StoreTenant;


class TenantController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

	/**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
	
	public function tenants(Request $request){
		
		$tenants = 	$request->has('paginate') ? 
				Tenant::all()
					->paginate($request->paginate)							
			: 	Tenant::all();
				
		if(sizeof($tenants)){
			return response()->json($tenants,200);
		}else{
			
			$message = 'no tenants found';
			
			return response()->json(['message' => $message],401);
		}
	}
	
	public function newTenant(StoreTenant $request){
		
		$tenant = Tenant::create($request->all());
		
		$user = User::create(["email" => $tenant->email,"tenant_id" => $tenant->id, "password" => app('hash')->make($request->password) , "access_level" => "admin"]);
	
		return response()->json(['data' => $tenant],200);
	}
	
	public function users($tenant , Request $request){
		
		$tenant_id = $this->getTenant($tenant);
		
		if(isset($tenant_id->id)){
			$query = [
				['tenant_id', '=', $tenant_id->id]
			];
			
			if($request->has('user_type')){
				array_push($query,['meta->user_type', '=', $request->user_type]);
			}
		
			$users = 	$request->has('paginate') ? 
					User::with('tenant')->where($query)
						->paginate($request->paginate)							
				: 	User::with('tenant')->where($query)
						->get();
					
			if(sizeof($users)){
				return response()->json($users,200);
			}else{
				
				$message = 'no users found for tenant : '.$tenant_id;
				
				return response()->json(['message' => $message],401);
			}
		}else{
			$message = 'tenant : '.$tenant.' does not exist';
				
			return response()->json(['message' => $message],404);
		}
	}
	
	public function user($tenant,$user_id){
		
		$tenant_id = $this->getTenant($tenant);
		
		if(isset($tenant_id->id)){
			$user = User::where([
						['tenant_id', '=', $tenant_id->id],
						['id', '=', $user_id],
					])->get();
									
			if(sizeof($user)){
				return response()->json($user,200);
			}else{
				
				$message = 'no user id: '.$user_id.' found for tenant : '.$tenant;
				
				return response()->json(['message' => $message],401);
			}
		}else{
			$message = 'tenant : '.$tenant.' does not exist';
				
			return response()->json(['message' => $message],404);
		}
	}
	
	public function userSave($tenant,$user_id,Request $request){
		
		$tenant_id = $this->getTenant($tenant);
		$data = $request->all();
		unset($data['id']);
		unset($data['meta']);
				
		//var_dump($data);
		
		if(isset($tenant_id->id)){
			
			try {
				$user = User::where([
						['tenant_id', '=', $tenant_id->id],
						['id', '=', $request->id],
					])->first();
			  
				$user->meta = $request->meta;
				
				$user->fill($data)->save();
			  
				return response()->json($user,200);
			} catch (ModelNotFoundException $ex) {
			  	$message = 'no user id: '.$user_id.' found for tenant : '.$tenant;
				
				return response()->json(['message' => $message],401);
			}
		
		}else{
			$message = 'tenant : '.$tenant.' does not exist';
				
			return response()->json(['message' => $message],404);
		}
	}
	
	public function activities($tenant,Request $request){
		
		$tenant_id = $this->getTenant($tenant);
		
		if(isset($tenant_id->id)){
		
			$query = [
						['tenant_id', '=', $tenant_id->id]
					];
			
			if($request->has('user_id')){
				array_push($query,['user_id', '=', $request->user_id]);
			}
			
			if($request->has('type')){
				array_push($query,['meta->action->type', $request->type]);
			}
					
			$activities = $request->has('paginate') ? Activity::where($query)->paginate($request->paginate) : Activity::where($query)->get();
							
			if(sizeof($activities)){
				return response()->json($activities,200);
			}else{
				
				$message = 'no activities found for tenant : '.$tenant;
				
				return response()->json(['message' => $message],401);
			}
		
		}else{
			$message = 'tenant : '.$tenant.' does not exist';
				
			return response()->json(['message' => $message],404);
		}
	}
	
	public function getTenant($tenant){
		try{
			$tenant = Tenant::where('username', $tenant)->first();
			
			return $tenant;
			
		}catch(Exception $e){
			return false;
		}
	}
	
	public function transactions($tenant,Request $request){
		
		$query = [];
		
		$tenant_id = $this->getTenant($tenant);
		
		if(isset($tenant_id->id)){
		
			$query = [
						['tenant_id', '=', $tenant_id->id]
					];
			

			if($request->has('type')){
				array_push($query,['meta->type', '=', $request->type]);
			}
					
			$transactions = $request->has('paginate') ? Transaction::with('currency')->where($query)->paginate($request->paginate) : Transaction::with('currency')->where($query)->get();
							
			if(sizeof($transactions)){
				return response()->json($transactions,200);
			}else{
				
				$message = 'no transactions found for tenant : '.$tenant;
				
				return response()->json(['message' => $message],401);
			}
		
		}else{
			$message = 'tenant : '.$tenant.' does not exist';
				
			return response()->json(['message' => $message],404);
		}
	}
	
	public function services(Request $request){
		
		$query = [];
		
		if($request->has('tenant')){
			
			$tenant_id = $this->getTenant($tenant);
			
			if(isset($tenant_id->id)){
				array_push($query,['tenant_id', '=', $tenant_id->id]);
			}
		}
				
		$services = $request->has('paginate') ? Service::with('currency')->where($query)->paginate($request->paginate) : Service::with('currency')->where($query)->get();
						
		if(sizeof($services)){
			return response()->json($services,200);
		}else{
			
			$message = $request->has('tenant') ? 'no services found for tenant : '.$tenant : 'no services found';
			
			return response()->json(['message' => $message],401);
		}
	}
}
