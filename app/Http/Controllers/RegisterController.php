<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fName'=> 'required|string',
            'lName'=> 'required|string',
            'email'=> 'required|unique:users|string|email',
            'phone'=> 'required|unique:users|numeric|min:13',
            'password'=> 'required|alpha_num|confirmed',
            'role'=> 'nullable|string'
        ]);

        if($validator->fails()){
           
            return $this->sendBadRequestResponse($validator->errors());
        }

        $user = User::create([
            'name'=> $request->fName." ". $request->lName,
            'email'=> $request->email,
            'phone'=> $request->phone,
            'password'=> bcrypt($request->password),
            'role'=> $request->role ?? "user"
        ]);

        return $this->sendSuccessResponse($user, 'User created successfully');
    }
}
