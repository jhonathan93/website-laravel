<div class="pt-4 border-t border-gray-600">
    <div class="flex flex-col items-center">
        <div class="w-12 h-12 rounded-full bg-gray-500 mb-2 flex items-center justify-center">
            @if($urlPhoto)
                <img src="{{ $urlPhoto }}" class="bg-gray-200 border-4 border-green-500 rounded-full w-12 h-12 object-cover">
            @else
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
            @endif
        </div>

        <span class="text-sm font-medium">
            <a href="{{ route('profile', ['uuid' => $uuid]) }}">
                {{ $name }}
            </a>
        </span>

        <button wire:click="logout" class="mt-2 text-xs text-gray-300 hover:text-white flex items-center transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
            </svg>

            Sair
        </button>
    </div>
</div>
