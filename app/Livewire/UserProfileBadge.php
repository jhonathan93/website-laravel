<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

class UserProfileBadge extends Component {

    /**
     * @var string
     */
    public string $uuid;

    /**
     * @var string
     */
    public string $name;

    /**
     * @var string|null
     */
    public ?string $urlPhoto;

    public function render(): View {
        return view('livewire.user-profile-badge');
    }

    public function mount(): void {
        $user = Auth::user();

        $this->uuid = $user->uuid;
        $this->name = $user->name;
        $this->urlPhoto = $user->urlPhoto ?? null;
    }

    /**
     * @param string $urlPhoto
     * @param string $uuid
     * @return void
     */
    #[On('profilePhotoUpdated')]
    public function checkPhotoUpdate(string $urlPhoto, string $uuid): void {
        $this->urlPhoto = $urlPhoto;
        $this->uuid = $uuid;
    }

    /**
     * @return void
     */
    public function logout(): void {
        $this->redirectRoute('logout');
    }
}
