<x-ui-layout>

    <x-slot name="header">
        Bandas de precios
    </x-slot>

    @livewire('bandas.index', ['activo' => $activo])

</x-ui-layout>