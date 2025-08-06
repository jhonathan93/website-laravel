<div class="grid grid-cols-1 gap-6 mt-8 md:grid-cols-2">
    @foreach($addresses as $address)
        <div wire:key="address-{{ $address->uuid }}"  class="p-6 bg-white rounded-lg shadow {{ $address->is_primary ? 'border-2 border-green-500' : '' }}">
            <div class="flex justify-between items-start">
                <h3 class="flex items-center text-lg font-bold text-gray-800">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                    </svg>

                    {{ $address->is_primary ? 'Endereço Principal' : 'Endereço #' . $loop->iteration }}
                </h3>

                @if($address->is_primary)
                    <span class="px-2 py-1 text-xs font-semibold text-green-800 bg-green-100 rounded-full">
                        Primário
                    </span>
                @endif
            </div>

            <div class="mt-4 space-y-2 text-gray-600">
                <div class="flex items-start">
                    <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0 w-5 h-5 mr-2 mt-0.5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
                    </svg>

                    <p class="font-medium">
                        {{ $address->street }}, {{ $address->number }}

                        @if($address->complement)
                            - {{ $address->complement }}
                        @endif
                    </p>
                </div>

                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0 w-5 h-5 mr-2 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>

                    <p>{{ $address->district }}</p>
                </div>

                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0 w-5 h-5 mr-2 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                    </svg>

                    <p>{{ $address->city }} - {{ $address->state }}</p>
                </div>

                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0 w-5 h-5 mr-2 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                    </svg>

                    <p>CEP: {{ $address->formatted_zip_code ?? $address->zip_code }}</p>
                </div>

                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0 w-5 h-5 mr-2 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM4.332 8.027a6.012 6.012 0 011.912-2.706C6.512 5.73 6.974 6 7.5 6A1.5 1.5 0 019 7.5V8a2 2 0 004 0 2 2 0 011.523-1.943A5.977 5.977 0 0116 10c0 .34-.028.675-.083 1H15a2 2 0 00-2 2v2.197A5.973 5.973 0 0110 16v-2a2 2 0 00-2-2 2 2 0 01-2-2 2 2 0 00-1.668-1.973z" clip-rule="evenodd"/>
                    </svg>

                    <p>{{ $address->country }}</p>
                </div>

                <div class="pt-2 mt-2 border-t border-gray-100">
                    <p class="text-sm text-gray-500">Endereço completo:</p>
                    <p class="font-medium">{{ $address->full_address }}</p>
                </div>
            </div>
        </div>
    @endforeach
</div>
