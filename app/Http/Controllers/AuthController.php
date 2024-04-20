<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function funLogin(Request $request){
        $credenciales = $request->validate([
            "email" => "required|email",
            "password" => "required"       
        ]);

        if (!Auth::attempt(($credenciales))) {
            return response()->json(["message" => "Credenciales Incorrectas"], 401);
        }

        $usuario = $request->user();

        $token = $usuario->createToken("Token Auth")->plainTextToken;

        return response()->json([
            "access_token" => $token,
            "usuario" => $usuario,
        ], 201);
    }

    public function funRegister(Request $request){
        $validator = Validator::make($request->all(), [
            "name" => "required",
            "email" => "required|email|unique:users",
            "password" => "required",
            "c_password" => "required|same:password"         
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();

        return response()->json(["message" => "Usuario registrado con exito"], 201);

    }
    public function funPerfil(){

        $user = Auth::user();
        return response()->json($user, 200);

    }
    public function funLogout(Request $request){
        $request->user()->tokens()->delete();

        return response()->json(["message" => "Logout"], 200);
    }    
    
}
