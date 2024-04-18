<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Services\User\AuthService;

class AuthController extends Controller
{
    private $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * @param RegisterRequest $request
//     * @return RedirectResponse
     */
    public function register(RegisterRequest $request)
    {
        $response = $this->authService->register($request->except('re-password'));

        return $this->redirect($response, 'login');
    }
}
