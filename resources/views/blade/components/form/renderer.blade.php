<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    @foreach($schema as $field => $config)
        <div class="{{ $config['colspan'] ?? '' }} {{ $config['wrapper_class'] ?? '' }}">
            <label for="{{ $field }}" class="block text-sm font-medium text-gray-700 mb-1">
                {{ $config['label'] }}
                @if($config['required'] ?? false) * @endif
            </label>

            {!! $config['before_input'] ?? '' !!}

            @switch($config['type'])
                @case('select')
                    <select
                        id="{{ $field }}"
                        wire:model="formData.{{ $field }}"
                        class="{{ $config['class'] ?? 'input-default' }}"
                        @if($config['required'] ?? false) required @endif
                    >
                        <option value="">Selecione...</option>
                        @foreach($config['options'] ?? [] as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </select>
                @break

                @case('textarea')
                    <textarea
                        id="{{ $field }}"
                        wire:model="formData.{{ $field }}"
                        class="{{ $config['class'] ?? 'input-default' }}"
                        placeholder="{{ $config['placeholder'] ?? '' }}"
                        @if($config['required'] ?? false) required @endif
                    ></textarea>
                @break

                @default
                    <input
                        type="{{ $config['type'] ?? 'text' }}"
                        id="{{ $field }}"
                        name="{{ $field }}"
                        wire:model="formData.{{ $field }}"
                        class="{{ $config['class'] ?? 'input-default' }}"
                        placeholder="{{ $config['placeholder'] ?? '' }}"
                        @if(isset($config['data-mask'])) data-mask="{{ $config['data-mask'] }}" @endif
                        @if(isset($config['wire:blur'])) wire:blur="{{ $config['wire:blur'] }}" @endif
                        @if($config['required'] ?? false) required @endif
                    />
                @break
            @endswitch

            @error($field)
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror

            {!! $config['after_input'] ?? '' !!}
        </div>
    @endforeach
</div>
