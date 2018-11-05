<?php

namespace App\Http\Middleware;

use Auth0\Login\Contract\Auth0UserRepository;
use Auth0\SDK\Exception\CoreException;
use Auth0\SDK\Exception\InvalidTokenException;
use Auth, Log;
use Closure;

class CheckJWT
{
    protected $userRepository;

    /**
     * CheckJWT constructor.
     *
     * @param UserRepositoryContract $userRepository
     */
    public function __construct(UserRepositoryContract $userRepository)
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
            $user = $this->userRepository->getUserByDecodedJWT($tokenInfo);
            if (!$user) {
                return response()->json(["message" => "Unauthorized user"], 401);
            }
            Auth::login($user);

        } catch (InvalidTokenException $e) {
            return response()->json(["message" => $e->getMessage()], 401);
        } catch (CoreException $e) {
            return response()->json(["message" => $e->getMessage()], 401);
        } catch (\Exception $e) {
            return response()->json(["message" => $e->getMessage()], 500);
        }

        return $next($request);
    }
}