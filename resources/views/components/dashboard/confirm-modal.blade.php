@props([
    'name',
    'title' => 'Confirm',
    'message' => 'Are you sure you want to continue?',
    'confirmText' => 'Confirm',
    'cancelText' => 'Cancel',
    'confirmEvent' => 'dashboard-confirm',
    'confirmPayload' => [],
])

<x-modal :name="$name">
    <div x-data="{ confirm() { $dispatch(@js($confirmEvent), Object.assign({ modal: @js($name) }, @js($confirmPayload))); $dispatch('close-modal', @js($name)); } }" class="p-6">
        <h2 class="text-lg font-semibold text-neutral-900 dark:text-neutral-50">{{ $title }}</h2>

        <div class="mt-3 text-sm text-neutral-600 dark:text-neutral-300">
            @if(trim($slot) !== '')
                {{ $slot }}
            @else
                {{ $message }}
            @endif
        </div>

        <div class="mt-6 flex justify-end gap-3">
            <x-secondary-button type="button" @click="$dispatch('close-modal', @js($name))">
                {{ $cancelText }}
            </x-secondary-button>
            <x-primary-button type="button" @click="confirm()">
                {{ $confirmText }}
            </x-primary-button>
        </div>
    </div>
</x-modal>
