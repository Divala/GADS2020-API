<?php
/**
 * Created by PhpStorm.
 * User: mathewsdivala
 * Date: 2019-03-11
 * Time: 08:26
 */

namespace App\Models\User;


use Laravel\Passport\Client;

class PassportClient extends Client
{
    public static function findClientByName($clientName)
    {
        return self::where('name', $clientName)->get()->first();
    }

    public static function findClientBySecret($clientSecret)
    {
        return self::where('secret', $clientSecret)->get()->first();
    }
}