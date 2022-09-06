<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Http\Traits\ResponseApi;


class UserController extends Controller
{
    use ResponseApi;

    //
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['access', 'authenticate', 'login', 'forgot', 'loginverify', 'getAll', 'update', 'destroy']]);
    }

    public function destroy($id)
    {
        User::find($id)->delete();
    }

    public function update($id, Request $request)
    {
        $user = User::find($id);
        $user->firstName = $request->firstName;
        $user->lastName = $request->lastName;
        $user->email = $request->email;
        if ($request->password) {
            $user->password = Hash::make($request->password);
        }
        $user->update();
        return $this->successResponseWithData($user);
    }

    public function getAll()
    {
        return $this->successResponseWithData(User::all());
    }

    public function loginverify(Request $request)
    {
        return response()->json([
            'valid' =>  auth()->guard('api')->check(),
            'user'  =>  auth()->guard('api')->user()
        ]);
    }

    public function login(Request $request)
    {
        $credentials = ['email' => $request->email, 'password' => $request->password];

        // if ( !$token = Auth::guard('examenceid')->setTTL(1)->attempt($credentials) ){
        if (!$token = Auth::guard('api')->attempt($credentials)) {
            return response()->json(['error' => 'Verifica tu usuario y contraseña'], 401);
        }

        return $this->respondWithToken($token);
    }

    public function register(Request $request)
    {
        $us = DB::select('SELECT * FROM users WHERE email=?', [$request->email]);
        if (count($us) > 0) {
            return response()->json([
                "success" => "false",
                "msg" => "El usuario ya cuenta con usuario"
            ]);
        }
        $messages = [
            'required' => 'Se requiere el campo :attribute.',
        ];
        // $table = DB::connection('sqlsrv');
        //return $table;
        $validator = Validator::make($request->all(), [
            'firstName' => 'required',
            'lastName' => 'required',
            'email' => 'required',
            'password' => 'required'
        ], $messages);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $user = User::create([
            'firstName'  => $request->firstName,
            'lastName' => $request->lastName,
            'email' => $request->email,
            'password' => Hash::make($request->password), //Hash::make  bcrypt
        ]);
        return response()->json([
            "msg1" => "Se añadio balotario para examen",
            "msg2" => "Se creo el acceso para el examen",
            "user" => $user
        ]);
    }


    protected function respondWithToken($token, $samePass = null, $modulo = null)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'passSameToUser' => $samePass,
            'user' => auth()->guard('api')->user()
        ]);
    }
}
