<?php

namespace App\Livewire\Components\Notification;

use Livewire\Component;
use Illuminate\View\View;
use Livewire\Attributes\On;
use Illuminate\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Support\Facades\Session;

class Notification extends Component {

    /**
     * @var ?string
     */
    public ?string $message = null;

    /**
     * @var string
     */
    public string $type = 'success';

    /**
     * @var bool
     */
    public bool $show = false;

    /**
     * @return void
     */
    public function mount(): void {
        if (Session::has('message') && Session::has('type')) {
            $this->dispatch('triggerNotification', message: Session::get('message'), type: Session::get('type'));

            Session::forget(['message', 'type']);
        }
    }


    /**
     * @param string $message
     * @param string $type
     * @return void
     */
    #[On('triggerNotification')]
    public function notify(string $message, string $type): void {
        $this->message = $message;
        $this->type = $type;
        $this->show = true;
    }

    /**
     * @return View|Application|Factory
     */
    public function render(): View|Application|Factory {
        return view('livewire.components.notification.notification');
    }
}
