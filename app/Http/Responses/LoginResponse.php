<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract
{
    public function toResponse($request)
    {
        $user = $request->user();

        if ($user && $user->usertype === 'admin') {
            return redirect()->intended(route('dashboard'));
        }

        return redirect()->intended(route('home'));
    }
}