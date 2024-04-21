<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    use SoftDeletes; // Importa el trait SoftDeletes

    protected $dates = ['deleted_at'];
    protected $fillable = [
        'name',
        "lastname",
        'email',
        "phone",
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function rules($editPassword)
    {
        $rules = [
            'name' => 'required',
            'lastname' => 'required',
            'email' => 'required|regex:/(.+)@(.+)\.(.+)/i',
            'phone' => 'required|min:9|max:9',
        ];

        // Si no se proporciona una contraseña, se excluye la validación de la misma
        if (!$editPassword) {
            $rules['password'] = 'required|min:8';
        }

        return $rules;
    }

    public function customMessages()
    {
        return [
            'name.required' => 'El campo nombre es obligatorio.',
            'lastname.required' => 'El campo apellido es obligatorio.',
            'email.required' => 'El campo correo electrónico es obligatorio.',
            'email.email' => 'El correo electrónico debe ser una dirección de correo válida.',
            'email.regex' => 'Tiene que tener un formato correcto de correo',
            'phone.required' => 'El campo teléfono es obligatorio.',
            'phone.min' => 'El campo teléfono debe tener al menos :min dígitos.',
            'phone.max' => 'El campo teléfono debe tener como máximo :max dígitos.',
            'password.required' => 'El campo contraseña es obligatorio.',
            'password.min' => 'La contraseña debe tener al menos :min caracteres.',
        ];
    }
}
