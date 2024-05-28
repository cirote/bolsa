<x-ui-layout>

    <x-slot name="header">
        Bandas de precios detalladas
    </x-slot>

    @livewire('grillas.bandas', ['grilla' => $grilla])

</x-ui-layout>