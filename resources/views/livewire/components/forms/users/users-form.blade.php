<div class="bg-gray-50 p-6 rounded-lg shadow-sm border border-gray-200">
    <h2 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
        <i class="fas fa-user-circle mr-2 text-blue-500"></i>
        Dados Pessoais
    </h2>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @foreach($fieldConfig as $field => $config)
            <div class="{{ $config['colspan'] ?? '' }} {{ $config['wrapper_class'] ?? '' }}">
                <label for="{{ $field }}" class="block text-sm font-medium text-gray-700 mb-1">
                    {{ $config['label'] }}
                    @if($config['required'] ?? false) * @endif
                </label>

                {!! $config['before_input'] ?? '' !!}

                @if($config['type'] === 'select')
                    <select class="{{ $config['class'] }}" id="{{ $field }}" wire:model="formData.{{ $field }}" @if($config['required'] ?? false) required @endif >
                        @foreach($config['options'] as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </select>
                @else
                    <input type="{{ $config['type'] }}" class="{{ $config['class'] }}" id="{{ $field }}" wire:model="formData.{{ $field }}" placeholder="{{ $config['placeholder'] ?? '' }}" @if($config['required'] ?? false) required @endif>
                @endif

                {!! $config['after_input'] ?? '' !!}
            </div>
        @endforeach
    </div>
</div>
