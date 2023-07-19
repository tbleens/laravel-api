<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{

    public function listUser() {

        $listUsers = User::all();

        return response()->json([
            'status' => true,
            'message' => 'user list successful show',
            'users' => $listUsers,
        ], 200);
    }

    public function infoUser(Request $request){

        return response()->json([
            'status' => true,
            'message' => 'user info successful show',
            'user' => $request->user(),
        ], 200);
    }

    public function updateUser(Request $request){

        try{
            $validatorUser = Validator::make($request->all(), [
                'name' => 'required',
                'email' => ['required', 'email','max:100', Rule::unique('App\Models\User', 'email')->where(function ($query) {
                    return $query->where('id', '!=', Auth::id());
                })],
            ]);
    
            if($validatorUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'message error validator',
                    'errors' => $validatorUser->errors()
                ], 401);
            }


            $user = User::where('id', Auth::id())->update([
                'name' => $request->name,
                'email' => $request->email
            ]);

            return response()->json([
                'status' => true,
                'message' => 'user successful update',
                'user' => User::where('id', Auth::id())->first()
            ], 200);
            

        } catch(\Throwable $th){
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
        
    }

    public function createUser(Request $request){

        try{
            $validatorUser = Validator::make($request->all(), [
                'name' => 'required',
                'email' => 'required|email|unique:users,email',
                'password' => 'required',
            ]);
    
            if($validatorUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'message error validator',
                    'errors' => $validatorUser->errors()
                ], 401);
            }

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            return response()->json([
                'status' => true,
                'message' => 'user successful created',
                'user' => $user,
                'token' => $user->createToken('API TOKEN')->plainTextToken
            ], 200);

            

        } catch(\Throwable $th){
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
        
    }

    public function loginUser(Request $request){

        try{
            $validatorUser = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required',
            ]);
    
            if($validatorUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'message error validator',
                    'errors' => $validatorUser->errors()
                ], 401);
            }

            if(!Auth::attempt($request->only(['email', 'password']))){
                return response()->json([
                    'status' => false,
                    'message' => 'Email and Password does not match',
                ], 401);
            }

            $user = User::where('email', $request->email)->first();

            return response()->json([
                'status' => true,
                'message' => 'user successful login',
                'user' => $user,
                'token' => $user->createToken('API TOKEN')->plainTextToken
            ], 200);

        } catch(\Throwable $th){
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function updatePassword(Request $request){
        try{
            $validatorUser = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required',
            ]);
    
            if($validatorUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'message error validator',
                    'errors' => $validatorUser->errors()
                ], 401);
            }

            $user = User::where('email', $request->email)->update([
                'password' => Hash::make($request->password)
            ]);

            return response()->json([
                'status' => true,
                'message' => 'user successful created',
                'user' => $user,
            ], 200);

        } catch(\Throwable $th){
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function deleteUser(User $user){

        $user->delete();

        return response()->json([
            'status' => true,
            'message' => 'user successful deleted'
        ], 200);
    }
}
