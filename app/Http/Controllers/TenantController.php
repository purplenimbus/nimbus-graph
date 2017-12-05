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
					User::where($query)
						->paginate($request->paginate)							
				: 	User::where($query)
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
		
		if(isset($tenant_id->id)){
			$user = User::where([
						['tenant_id', '=', $tenant_id->id],
						['id', '=', $request->id],
					])->update($data)->save();
									
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
		
		$tenant_id = $this->getTenant($tenant);
		
		if(isset($tenant_id->id)){
		
			$query = [
						['tenant_id', '=', $tenant_id->id]
					];
			
			if($request->has('type')){
				array_push($query,['meta->type', '=', $request->type]);
			}
					
			$transactions = $request->has('paginate') ? Transaction::where($query)->paginate($request->paginate) : Transaction::where($query)->get();
							
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
}
