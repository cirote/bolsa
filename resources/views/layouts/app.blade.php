<x-ui-layout>

    <x-slot name="header">
        {{ $header ?? '' }}
    </x-slot>

    {{ $slot }}

</x-ui-layout>