<x-ui-layout>

    <x-slot name="header">
        Tabla de movimientos
    </x-slot>

    @livewire('movimientos.index', ['cuenta' => $cuenta])

</x-ui-layout>