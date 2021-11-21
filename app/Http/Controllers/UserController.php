<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\User;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{
    public function registrasi(Request $request){
        $requestValidator = Validator::make($request->all(), [
            'name'=>'required',
            'email'=>'required|email',
            'password'=>'required',
            'c_password'=>'required|same:password'
        ]);

        if($requestValidator->fails()) {
            $error = [];
            $errors = $requestValidator->errors();
            foreach($errors->all() as $message) {
                array_push($error, $message);
            }
            return response()->json([
                'statusCode'=>400,
                'message'=>'Bad Request',
                'data'=>null,
                'error'=>$error
            ], 400);
        }

        $input = $request->all();
        $input['password'] = bcrypt ($input['password']);
        $user = User::create($input);

        return response()->json([
            'statusCode' => 200,
            'message' => 'succcess',
            'data' => $user,
            'error' => null
        ],200);
    }

    public function login(Request $request){
        $validatorRequest = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if($validatorRequest->fails()){
            $error = [];
            $errors = $validatorRequest->errors();
            foreach($errors->all() as $message){
                array_push($error,$message);
            }
            return response()->json([
                'statusCode'=>400,
                'message'=>'Bad Request',
                'data'=>null,
                'error'=>$error
            ], 400);
        }
        if(Auth::attempt([
            'email'=> $request->input('email'),
            'password' => $request->input('password')
            ]) ) {
                $user = Auth::user();
                return response()->json([
                    'statusCode'=>200,
                    'message' => 'success',
                    'data' => $user,
                    'token' => $user->createToken('app')->accessToken,
                    'error' => null
                ]);
            }else {
                return response()->json([
                    'statusCode'=>401,
                    'message'=>'Unauthorized',
                    'data'=>null,
                    'error'=>null
                ], 401);
            }
    }
}
