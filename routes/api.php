<?php

use Illuminate\Http\Request;
use \App\Message;
use \App\User;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:api')->get('/messages', function() {
    return Message::all();
});

Route::post('/register', function(Request $request) {
    $request->validate([
        'email' => 'required|unique:users',
        'name' => 'required',
        'password' => 'required',
    ]);
   $name = $request->get('name');
   $password = $request->get('password');
   $email = $request->get('email');
   //return $request;
   //if (!(empty($name) || empty($password) || empty($email))) {
     //return "ok";
       /*$user = User::where('email', $email)->first();
       //return $user;
       if (!empty($user)) {
           return response("User with email=\"$email\" is already registered", 404)
               ->header('Content-Type', 'text/plain');
       }*/
       $user = new User();
       $user->name = $name;
       $user->email = $email;
       $user->password = Hash::make($password);
       $user->api_token = md5(Str::random(60));
       $user->save();
       return response($user->api_token, 200)
           ->header('Content-Type', 'text/plain');
   /*} else {
       return response('Name, email and password are required', 404)
           ->header('Content-Type', 'text/plain');
   }*/
});

Route::post('/resetpassword', function(Request $request) {
    $email = $request->get('email');
    return "send instruction to '$email' for reset password";
});

Route::post('/resettoken', function(Request $request) {
    $email = $request->get('email');
    $pass = $request->get('password');

    $user = User::query()->where('email', $email)->first();

    if (Hash::check($pass, $user->password)) {
        $user->api_token = md5(Str::random(60));
        $user->save();
        return response($user->api_token, 200)
            ->header('Content-Type', 'text/plain');
    } else {
        return response("Password or email incorrect!", 404)
            ->header('Content-Type', 'text/plain');
    }

});

Route::post('/token', function(Request $request) {
    $email = $request->get('email');
    $pass = $request->get('password');

    $user = User::query()->where('email', $email)->first();

    if (Hash::check($pass, $user->password)) {
        return response($user->api_token, 200)
            ->header('Content-Type', 'text/plain');
    } else {
        return response("Password or email incorrect!", 404)
            ->header('Content-Type', 'text/plain');
    }
});

Route::post('/messages', function(Request $request) {

    $request->validate([
        'api_token' => 'required',
        'message' => 'required',
    ]);
    $api_token = $request->get('api_token');
    $message = $request->get('message');
    $user = User::where('api_token', $api_token)->first();
    //return $request;
    //return "\n $api_token \n {$request->get('api_token')}";
    //return $user;
    if (empty($user)) {
        return response("Token incorrect!", 404)
                ->header('Content-Type', 'text/plain');
    }
    $message = new Message();

    // $message->fill($request->all());
    $message->user_id = $user->id;
    $message->message = $request->get('message');

    // При ошибках сохранения возникнет исключение
    $message->save();

    return "ok\n";
});

/*
 сделать создание/редактирование/удаление юзера через формы
 разобраться с работой почты

 */
