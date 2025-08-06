<div>
    @if ($show)
        <div class="fixed z-50 w-full text-center p-4 {{ $type === 'success' ? 'bg-green-500' : 'bg-red-500' }}" id="alert-message">
            {{ $message }}
        </div>
    @endif
</div>
