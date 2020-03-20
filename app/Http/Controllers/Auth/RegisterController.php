<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'nombre_completo' => ['required', 'string'],
            'numero_documento' => ['required', 'number'],
            'id_tipo_documento' => ['required', 'number'],
            'id_genero' => ['required', 'number'],
            'sede_id' => ['required', 'number'],
            'area_id' => ['required', 'number'],
            'cargo_id' => ['required', 'number'],
            'rol_id' => ['required', 'number'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'nombre_completo' => $data['nombre_completo'],
            'numero_documento' => $data['numero_documento'],
            'id_tipo_documento' => $data['id_tipo_documento'],
            'id_genero' => $data['id_genero'],
            'sede_id' => $data['sede_id'],
            'area_id' => $data['area_id'],
            'cargo_id' => $data['cargo_id'],
            'rol_id' => $data['rol_id'],
            'password' => Hash::make($data['password']),
        ]);
    }
}
