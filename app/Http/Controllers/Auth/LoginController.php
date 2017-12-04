<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('guest')->except('logout');
    }
	
	public function authenticate(Request $request)
    {
		
        $credentials = $request->only('email', 'password');
		
		//$tenant_id = $this->getTenant($request->tenant)->id;
				
		$auth = Auth::attempt($request->only('email', 'password'));
		
		var_dump($credentials);
		
        /*try {
            // verify the credentials and create a token for the user
			$query = 	[
							['email', '=', $credentials['email']],
							['password', '=', $credentials['password']],
							//['tenant_id', '=', $tenant_id],
						];
						
			$user = App\User::where($query)->firstOrFail();
			
			var_dump($user);
			
			var_dump($query);
			
            if (! $user) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        } catch (Exception $e) {
            // something went wrong
            return response()->json(['error' => 'could_not_create_token'], 500);
        }*/
		
        // if no errors are encountered we can return a JWT
        return response()->json(compact(['token','user']));
    }
	
	public function getTenant($tenant){
		try{
			$tenant = Tenant::where('username', $tenant)->first();
			
			return $tenant;
			
		}catch(Exception $e){
			return false;
		}
	}
}
