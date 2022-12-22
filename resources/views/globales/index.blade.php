<x-ui-layout>

    <x-slot name="header">
        Posiciones Globales
    </x-slot>

    <x-ui-card title="Inversiones activas" footer="" color="blue">
        <x-ui-row>
            @livewire('globales.index')
        </x-ui-row>
    </x-ui-card>

</x-ui-layout>
