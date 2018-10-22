// /app/Http/Middleware/CheckJWT.php

<?php

namespace App\Http\Middleware;

use Auth0\Login\Contract\Auth0UserRepository;
use Auth0\SDK\JWTVerifier;
use Auth0\SDK\Helpers\Cache\FileSystemCacheHandler;
use Auth0\SDK\Exception\CoreException;
use Auth0\SDK\Exception\InvalidTokenException;
use Auth;
use Closure;

class CheckJWT
{
    protected $userRepository;

    /**
     * CheckJWT constructor.
     *
     * @param Auth0UserRepository $userRepository
     */
    public function __construct(Auth0UserRepository $userRepository)
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
        $accessToken = $request->bearerToken();
        try {
            $verifier = new JWTVerifier([
                'valid_audiences' => config('laravel-auth0.valid_audiences'),
                'authorized_iss' => config('laravel-auth0.authorized_iss'),
                'cache' => new FileSystemCacheHandler() // This parameter is optional. By default no cache is used to fetch the JSON Web Keys.
            ]);
            $decodedToken = $verifier->verifyAndDecode($accessToken);

            $user = $this->userRepository->getUserByDecodedJWT($decodedToken);
            if (!$user) {
                return response()->json(["message" => "Unauthorized user"], 401);
            }

            Auth::login($user);

        } catch (InvalidTokenException $e) {
            return response()->json(["message" => $e->getMessage()], 401);
        } catch (CoreException $e) {
            return response()->json(["message" => $e->getMessage()], 401);
        }

        return $next($request);
    }
}