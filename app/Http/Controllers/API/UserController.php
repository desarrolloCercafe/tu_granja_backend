<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use DB;
class UserController extends BaseController
{

    public $successStatus = 200;


    public function login() {

        if(Auth::attempt(['name' => request('name'), 'password' => request('password')])){
            $user = Auth::user();
            //return "paso auth";
            //return response()->json($user, 200);
            $success['token'] =  $user->createToken('MyApp')->accessToken;
            $success['rol'] = $user->rol_id;
            $success['user'] = $user->id;

            //return "paso token";
            //return $this->sendResponse($success, 'Success');
            return response()->json(['success' => $success], $this->successStatus);
        }
        else{
            return response()->json(['error'=>'Unauthorized'], 401);
        }

    }

    public function register(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'nombre_completo' => 'required',
            'numero_documento' => 'required',
            'id_tipo_documento' => 'required',
            'id_genero' => 'required',
            'sede_id' => 'required',
            'area_id' => 'required',
            'cargo_id' => 'required',
            'rol_id' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Error de validacion', $validator->errors());
        }
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] =  $user->createToken('apiToken')->accessToken;
        $success['name'] =  $user->name;
        $success['area_id'] = $user->area_id;
        $success['cargo_id'] = $user->cargo_id;
        $success['nombre_commpleto'] = $user->nombre_completo;
        $success['email'] = $user->email;
        $success['rol_id'] = $user->rol_id;
        $success['telefono'] = $user->telefono;
        return $this->sendResponse($success, 'Usuario registrado correctamente');
    }

    public function details() {
        $user = Auth::user();
        return $this->sendResponse($user,  'user details');
    }

    public function logout(Request $request) {
        $request->user()->token()->revoke();
        return response()->json(['message' =>
            'Successfully logged out']);
    }

    public function getByArea($area){
        //return response()->json($area, 200);
        $users = User::where('area_id', '=', $area)->get();
        return response()->json($users, 200);
    }

    public function getAllUsers(){
        $users = User::all();
        return response()->json($users, 200);
    }

    public function update(Request $request, $id){
        $user = User::find($id);
        $user->password = bcrypt($request->pass1);
        $user->save();
        return response()->json("OK", 200);
    }

    public function showInfoUser($id){
        $user = User::find($id);
        return response()->json($user, 200);
    }

    public function UpdateUser(Request $request, $id){
        $user = User::find($id);
        $user->nombre_completo = $request->nombre;

        $user->name = $request->username;
        $user->email = $request->email;
        $user->documento = $request->documento;
        $user->telefono = $request->telefono;
        $user->fecha_nacimiento = $request->f_nacimiento;
        $user->sede_id = $request->sede;
        $user->area_id = $request->area;
        $user->cargo_id = $request->cargo;
        $user->rol_id = $request->rol;
        $user->save();

        return response()->json("OK", 200);
    }

}
