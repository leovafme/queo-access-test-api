<?php

namespace App\Http\Middleware;

use App\Repositories\CustomUserRepository;
use Auth0\SDK\Exception\CoreException;
use Auth0\SDK\Exception\InvalidTokenException;
use Closure;

class CheckJWT
{
    protected $userRepository;

    /**
     * CheckJWT constructor.
     *
     * @param CustomUserRepository $userRepository
     */
    public function __construct(CustomUserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $auth0 = \App::make('auth0');

        $accessToken = $request->bearerToken();

        try {
            $tokenInfo = $auth0->decodeJWT($accessToken);

            $tokenInfo["accessToken"] = $accessToken;

            $user = $this->userRepository->getUserByDecodedJWT($tokenInfo);

            if (!$user) {
                return response()->json(["message" => "Unauthorized user"], 401);
            }

            return response()->json(["message" => $user, "slss" => $tokenInfo]);
        } catch (InvalidTokenException $e) {
            return response()->json(["message" => $e->getMessage()], 401);
        } catch (CoreException $e) {
            return response()->json(["message" => $e->getMessage()], 401);
        }

        return $next($request);
    }
}
