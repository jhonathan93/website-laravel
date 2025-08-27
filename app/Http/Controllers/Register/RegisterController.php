<?php

namespace App\Http\Controllers\Register;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Application;

class RegisterController extends Controller {

    /**
     * @return Factory|View|Application
     */
    public function showRegistration(): Factory|View|Application {
        return view('blade.pages.register.register');
    }
}
