<?php

namespace App\Http\Controllers\Home;

use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Application;
use Illuminate\Contracts\View\Factory;

class HomeController extends Controller {

    /**
     * @return Factory|View|Application
     */
    public function showHome(): Factory|Application|View {
        return view('blade.pages.home.home');
    }
}
