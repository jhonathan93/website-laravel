<?php

namespace App\Livewire\Components\Forms\Users;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Livewire\Component;

class UsersForm extends Component {

    /**
     * @return View|Application|Factory
     */
    public function render(): View|Application|Factory {
        return view('livewire.components.forms.users.users-form');
    }
}
