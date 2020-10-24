<?php

namespace App\Models\User;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;
    protected $guarded = [];

    protected $hidden = ['password', 'remember_token'];

    public static function createWithAttributes(array $attributes, $role)
    {
        if (self::checkUserByEmail($attributes['email'])) throw new UsernameConflictException();

        return self::create(
            array_merge(
                $attributes, [
                "role_id" => $role,
                "password" => bcrypt(isset($attributes['password']) ? $attributes['password'] : $attributes['username'])
            ])
        );
    }

    public static function createNew($request)
    {
        $user = self::create([
            "email" => $request->get("email"),
            "name" => $request->get("name"),
            "password" => bcrypt($request->get("password")),
        ]);

        return $user;
    }


    public static function checkUserByEmail(string $email)
    {
        return self::getByEmail($email) != null;
    }

    public static function getByEmail(string $email)
    {
        return self::where("email", $email)->first();
    }

    public static function fetchByEmail($email)
    {
        return self::where("email", $email)->first();

    }


    public function updateWithArray(array $fields)
    {
        return $this->update($fields);
    }

    public static function fetchUserWithPassword($email, $password)
    {
        $user = self::where("email", $email)->first();

        if ($user !== null) return \Hash::check($password, $user->password) ? $user : null;

        return null;
    }
}
