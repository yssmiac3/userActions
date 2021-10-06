<?php

namespace App\Http\Controllers\API;

use App\Events\User\SignedIn;
use App\Events\User\SignedUp;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\SignIn;
use App\Http\Requests\User\SignUp;
use App\Models\Custom\DTO\CreateUserActionDTO;
use App\Models\Custom\DTO\UserActionEventDTO;
use App\Models\Custom\UserAction;
use App\Services\User\UserAuthenticateService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    private UserAuthenticateService $service;

    public function __construct(UserAuthenticateService $service)
    {
        $this->service = $service;
    }

    public function signIn(SignIn $request)
    {
        try {
            $user = $this->service->signIn($request->all());

            SignedIn::dispatch(new UserActionEventDTO(
                $user->getId(),
                'sign_in'
            ));
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ]);
        }

        return response()->json([
            'message' => 'Successfully signed in',
        ]);
    }

    public function signUp(SignUp $request)
    {
        try {
            $user = $this->service->signUp($request->all());
            SignedUp::dispatch(new UserActionEventDTO(
                $user->getId(),
                'sign_in'
            ));
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ]);
        }

        return response()->json([
            'user' => $user->__serialize()
        ]);
    }
}
