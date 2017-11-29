<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class TenantController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
	use App\User as User;
	use App\Activity as Activity;
	/**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
	
	public function users($tenant_id , Request $request){
				
		$users = 	$request->has('paginate') ? 
						User::where('tenant_id',$tenant_id)
							->paginate($request->paginate)							
					: 	User::where('tenant_id',$tenant_id)
							->get();
				
		if(sizeof($users)){
			return response()->json($users,200);
		}else{
			
			$message = 'no users found for tenant id : '.$tenant_id;
			
			return response()->json(['message' => $message],401);
		}
	}
	
	public function user($tenant_id,$user_id){
		
		$user = User::where([
					['tenant_id', '=', $tenant_id],
					['id', '=', $user_id],
				])->paginate(10);
								
		if(sizeof($user)){
			return response()->json($user,200);
		}else{
			
			$message = 'no user id: '.$user_id.' found for tenant id : '.$tenant_id;
			
			return response()->json(['message' => $message],401);
		}
	}
	
	public function activities($tenant_id,Request $request){
		$query = [
					['tenant_id', '=', $tenant_id]
				];
		
		if($request->has('user_id')){
			array_push($query,['user_id', '=', $request->user_id]);
		}
		
		if($request->has('type')){
			array_push($query,['meta->action->type', $request->type]);
		}
				
		$activities = $request->has('paginate') ? Activity::with('user')->where($query)->paginate($request->paginate) : Activity::with('user')->where($query)->get();
						
		if(sizeof($activities)){
			return response()->json($activities,200);
		}else{
			
			$message = 'no activities found for tenant id : '.$tenant_id;
			
			return response()->json(['message' => $message],401);
		}
	}
}
