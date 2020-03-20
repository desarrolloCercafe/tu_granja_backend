<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class RegisterController extends BaseController
{
    public function register(Request $request)
    {
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
}
