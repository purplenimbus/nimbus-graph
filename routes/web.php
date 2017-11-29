<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
/* Tenants */
Route::get('/login', 'LoginController@authenticate'); //List all users for a certain tenant

/* Tenants */
Route::get('{tenant_id}/users', 'TenantController@users'); //List all users for a certain tenant
Route::post('{tenant_id}/users', 'TenantController@users'); //Update users for a certain tenant
Route::get('{tenant_id}/users/{user_id}', 'TenantController@user'); //List all details for a certain user
Route::post('{tenant_id}/users/{user_id}', 'TenantController@user'); //Update details for a certain user
Route::get('{tenant_id}/activities/', 'TenantController@activities'); //List all activities for a certain tenant
Route::post('{tenant_id}/activities/', 'TenantController@activities'); //Update activities for a certain tenant

/*Route::get('/', function () {
    // Build the query parameter string to pass auth information to our request
    $query = http_build_query([
        'client_id' => 3,
        'redirect_uri' => 'http://localhost/callback',
        'response_type' => 'code',
        'scope' => 'graph'
    ]);

    // Redirect the user to the OAuth authorization page
    return redirect('http://localhost/oauth/authorize?' . $query);
});

// Route that user is forwarded back to after approving on server
Route::get('callback', function (Request $request) {
    $http = new GuzzleHttp\Client;

    $response = $http->post('http://localhost/oauth/token', [
        'form_params' => [
            'grant_type' => 'authorization_code',
            'client_id' => 3, // from admin panel above
            'client_secret' => 'PNxO5aJbgni3IVjqOnxCwOxZmTRgVv6Mgqns6RCN', // from admin panel above
            'redirect_uri' => 'http://localhost/callback',
            'code' => $request->code // Get code from the callback
        ]
    ]);

    // echo the access token; normally we would save this in the DB
    return json_decode((string) $response->getBody(), true)['access_token'];
});
*/