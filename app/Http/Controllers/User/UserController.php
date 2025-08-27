<?php

namespace App\Http\Controllers\User;

use Throwable;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Exceptions\RegistrationException;
use App\Services\User\UserRegistrationService;
use App\Http\Requests\User\UserRegisterRequest;

class UserController extends Controller {

    /**
     * @param UserRegisterRequest $userRegisterRequest
     * @return RedirectResponse
     */
    public function save(UserRegisterRequest $userRegisterRequest): RedirectResponse {
        try {
            UserRegistrationService::register($userRegisterRequest->validated());

            return redirect()->intended()->with(['type' => 'success', 'message' => 'Conta criada com sucesso! Faça login para continuar']);
        } catch (RegistrationException $e) {
            logger()->error('Erro no registro - Controller: ' . $e->getMessage());

            return back()->withInput($userRegisterRequest->except('password', 'password_confirmation'))->with(['type' => 'error', 'message' => $e->getMessage()]);
        } catch (Throwable $e) {
            logger()->emergency('Erro inesperado no registro: ' . $e->getMessage(), ['exception' => $e]);

            return back()->withInput($userRegisterRequest->except('password', 'password_confirmation'))->with(['type' => 'error', 'message' => $e->getMessage()]);
        }
    }
}
