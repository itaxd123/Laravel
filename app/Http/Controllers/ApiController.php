<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ApiController extends Controller
{
    public function users(Request $request){
        
        // $user = User::all();
        if($request->has('active')){
            $user = User::where('active',$request->input('active'))->get();
        }
        // Sacar las Keys ->keys();
        // Sacar keys y value ->all();
        // Sacar el valor de una key ->input('nombre de key')
        // Si existe la key ->has('key')
        return response()->json($user);
    }

    public function login(Request $request)
    {

        $data = json_decode($request->getContent());
        $user = User::where('email', $data->email)->first();
        $status = false;
        $token  = $value = $message = '';
        $message = "Email no encontrado";

        if ($user) {
            $message = 'Password Incorrecta';
            if (Hash::check($data->password, $user->password)) {
                $status = true;
                $message = "Login Sucess";
                $token = $user->createToken('example')->plainTextToken;
            }
        }
        return response()->json(
            [
            'status' => $status,
            'message' => $message,
            'value' => $value,
            'token' => $token
            ]);
    }

}
