<?php

namespace App\Repositories;

use App\Models\User;

use Auth0\Login\Auth0User;
use Auth0\Login\Auth0JWTUser;
use Auth0\Login\Repository\Auth0UserRepository;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Http;

class CustomUserRepository extends Auth0UserRepository
{
    protected function upsertUser( $profile ) {
        return User::firstOrCreate(['sub' => $profile['sub']], [
            'email' => $profile['email'] ?? '',
            'name' => $profile['name'] ?? '',
        ]);
    }

    public function getUserByDecodedJWT(array $decodedJwt) : Authenticatable
    {
        // if not allow email get user info by sub
        if (empty($decodedJwt['email'])) {
            $profileInfo = $this->getUserInfo($decodedJwt["accessToken"]);
            $decodedJwt['email'] = $profileInfo["email"];
            $decodedJwt['name'] = $profileInfo["name"];
        }

        $user = $this->upsertUser( $decodedJwt );
        return new Auth0JWTUser( $user->getAttributes() );
    }

    public function getUserByUserInfo(array $userinfo) : Authenticatable
    {
        $user = $this->upsertUser( $userinfo['profile'] );
        return new Auth0User( $user->getAttributes(), $userinfo['accessToken'] );
    }

    public function getUserInfo(string $accessToken)
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer '.$accessToken,
        ])->get(env('AUTH0_AUTHROIZED_ISSUERS','').'userinfo');

        return $response->json();
    }
}
