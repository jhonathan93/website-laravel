<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Contracts\View\Factory;

class Menu extends Component {

    /**
     * @return Factory|View|Application
     */
    public function render(): Factory|Application|View {
        return view('livewire.menu');
    }
}
