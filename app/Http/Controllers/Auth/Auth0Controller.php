<?php

namespace App\Http\Controllers\Auth;

use Auth0\Login\Auth0Controller as BaseController;

class Auth0Controller extends BaseController
{
    /**
     * Redirect to the Auth0 hosted login page
     *
     * @return mixed
     */
    public function login()
    {
        return \App::make('auth0')->login(null, null, ['scope' => 'openid email email_verified'], 'code');
    }

    /**
     * Log out of Auth0
     *
     * @return mixed
     */
    public function logout()
    {
        \Auth::logout();
        return  redirect()->intended('/');
    }

    /**
     * Callback action that should be called by auth0, logs the user in.
     */
    public function callback()
    {
        // Get a handle of the Auth0 service (we don't know if it has an alias)
        $service = \App::make('auth0');

        // Try to get the user information
        $profile = $service->getUser();

        // Get the user related to the profile
        $auth0User = $this->userRepository->getUserByUserInfo($profile);

        if ($auth0User) {
            // If we have a user, we are going to log them in, but if
            // there is an onLogin defined we need to allow the Laravel developer
            // to implement the user as they want an also let them store it.
            if ($service->hasOnLogin()) {
                $user = $service->callOnLogin($auth0User);
            } else {
                // If not, the user will be fine
                $user = $auth0User;
            }
            \Auth::login($user, $service->rememberUser());
        }

        return \Redirect::intended('/dashboard');
    }
}