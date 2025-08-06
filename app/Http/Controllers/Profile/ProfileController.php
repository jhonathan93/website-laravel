<?php

namespace App\Http\Controllers\Profile;

use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Application;
use Illuminate\Contracts\View\Factory;

class ProfileController extends Controller {

    /**
     * @return Factory|View|Application
     */
    public function showProfile(): Factory|View|Application {
        return view('blade.pages.profile.profile');
    }
}
