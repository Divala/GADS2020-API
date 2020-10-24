<?php

namespace App\Http\Controllers;

use App\Models\User\PassportAuth;
use App\Models\User\PassportClient;
use App\Models\User\User;
use Illuminate\Support\Facades\Hash;
use Psr\Http\Message\ServerRequestInterface;

class AuthController extends ApiController
{
    public function register(ServerRequestInterface $request)
    {
        $email = request("email");

        if (User::fetchByEmail($email)) return $this->conflictResponse();

        $user = User::createNew(\request());

        try {

            $authenticator = new PassportAuth($request);
            $response = $authenticator->issueToken(PassportClient::findClientBySecret(request()->header("key")), request("email"), request("password"));
            return $this->objectCreatedResponse(["auth" => $response, "user" => $user]);
        } catch (\Exception $e) {
            return $this->expectationFailedResponse();
        }
    }

    public function postLogin(ServerRequestInterface $request)
    {
        $email = request('email');
        $password = request('password');

        $user = User::fetchUserWithPassword($email, $password);
        $client = PassportClient::findClientBySecret(request()->header("key"));

        if ($user == null || $client == null) return $this->unauthorizedResponse("invalid credentials or wrong app key");

        $authenticator = new PassportAuth($request);

        return $this->generalSuccessResponse(
            collect((array)$authenticator->issueToken($client, $email, $password))->merge([

                "user" => $user->getAttributes()
            ])->toArray()
        );
    }

    public function resetPassword($id)
    {
        $user = User::find($id);

        if ($user == null) return $this->objectNotFoundResponse("user with id $id not found");

        $user->update(["password" => bcrypt($user->username), "change_password" => 1]);

        return $this->generalSuccessResponse();
    }

    public function changePassword()
    {
        if (!Hash::check(request("old"), auth()->user()->password))
            return $this->unauthorizedResponse("the current password provided is incorrect");

        auth()->user()->update(["password" => bcrypt(request("new"))]);

        return $this->generalSuccessResponse([], "password changed successfully");
    }
}
