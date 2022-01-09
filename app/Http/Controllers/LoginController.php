<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{

    public function loginPage()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username'=> 'required',
            'password'=> 'required'
        ]);

        if($validator->fails()){
            return $this->sendBadRequestResponse($validator->errors());
        }

       
       
        if(is_numeric($request->get('username'))){
            $user = User::where('phone', $request->get('username'))->first();
        }elseif(filter_var($request->get('username'), FILTER_VALIDATE_EMAIL)){
            $user = User::where('email', $request->get('username'))->first();
        }else{
            return $this->sendBadRequestResponse('Invalid username or password');
        }

        if(is_null($user)){
            return $this->sendBadRequestResponse('Invalid username or password');
        }

        if(!Hash::check($request->get('password'), $user->password)){
            return $this->sendBadRequestResponse('Invalid username or password');
        }

        if($user->role === "admin"){
            $token = $user->createToken('admin users', ['admin-users'])->accessToken;
        }else{
            $token = $user->createToken('user', ['api'])->accessToken;
        }

        $data = (object)[
            'user'=> $user,
            'token'=>$token,
            'token_type'=> 'Bearer',
            'expires_at'=> Carbon::now()->addHours(2)
        ];


        return $this->sendSuccessResponse($data, 'login successfully');

       
    }

    
    
}
