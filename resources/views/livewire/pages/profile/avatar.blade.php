<div class="relative -mt-20">
    @if($urlPhoto)
        <img src="{{ $urlPhoto }}" class="bg-gray-200 border-4 border-white rounded-full w-36 h-36 object-cover">
    @else
        <div class="bg-gray-200 border-4 border-white rounded-full w-36 h-36"></div>
    @endif

    <div wire:loading wire:target="photo" class="absolute inset-0 bg-black bg-opacity-50 rounded-full flex items-center justify-center">
        <svg class="animate-spin h-8 w-8 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">...</svg>
    </div>

    <div class="absolute bottom-3 right-3 bg-purple-600 rounded-full p-2 cursor-pointer">
        <input type="file" id="avatarInput" wire:model="photo" class="hidden" accept="image/*">

        <label for="avatarInput" class="cursor-pointer">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M4 5a2 2 0 00-2 2v8a2 2 0 002 2h12a2 2 0 002-2V7a2 2 0 00-2-2h-1.586a1 1 0 01-.707-.293l-1.121-1.121A2 2 0 0011.172 3H8.828a2 2 0 00-1.414.586L6.293 4.707A1 1 0 015.586 5H4zm6 9a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd" />
            </svg>
        </label>
    </div>
</div>
