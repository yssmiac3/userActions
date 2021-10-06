<?php

namespace App\Providers;

use App\Auth\CustomUserProvider;
use App\Repositories\UserJsonRepository;
use Illuminate\Support\Facades\Auth;

class CustomAuthProvider extends \Illuminate\Support\ServiceProvider
{
    public function boot()
    {
        Auth::provider('customProvider', fn() => new CustomUserProvider(
            resolve(UserJsonRepository::class)
        ));
    }
}
