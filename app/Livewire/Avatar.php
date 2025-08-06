<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Contracts\View\View;
use App\Services\Image\ImageService;
use Illuminate\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use App\Services\Storage\MinioService;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class Avatar extends Component {

    use WithFileUploads;

    /**
     * @var TemporaryUploadedFile
     */
    public $photo;

    /**
     * @var string
     */
    public string $uuid;

    /**
     * @var string|null
     */
    public ?string $urlPhoto;

    /**
     * @return Factory|Application|View
     */
    public function render(): Factory|Application|View {
        return view('livewire.pages.profile.avatar');
    }

    /**
     * @return void
     */
    public function mount(): void {
        $this->uuid = auth()->user()->uuid;
        $this->urlPhoto = auth()->user()->urlPhoto;
    }

    /**
     * @return void
     */
    public function updatedPhoto(): void {
        $this->validate([
            'photo' => 'image|max:1024',
        ]);

        try {
            $service = app(MinioService::class);
            $serviceImage = app(ImageService::class);

            $serviceImage->embedDigitalWatermark($this->photo->path(), $this->uuid, request()->ip());

            if ($service->upload('/avatars', $this->photo)) {
                $filename = $this->photo->store();

                $user = auth()->user();
                $user->photo = $filename;
                $user->save();

                $this->urlPhoto = $user->urlPhoto;

                $this->photo->delete();
                $this->reset('photo');

                $this->dispatch('profilePhotoUpdated', urlPhoto: $user->urlPhoto, uuid: $user->uuid);
                $this->dispatch('triggerNotification', message: 'Foto atualizada com sucesso', type: 'success');
            }
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }
}
