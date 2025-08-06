<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Application;

class Addresses extends Component {

    public $addresses;

    /**
     * @return void
     */
    public function mount(): void {
        $this->addresses = auth()->user()->addresses;
    }

    /**
     * @return View|Application|Factory
     */
    public function render(): View|Application|Factory {
        return view('livewire.addresses');
    }
}
