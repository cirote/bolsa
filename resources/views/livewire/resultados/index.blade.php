<x-ui-crud-table :isOpen="$isOpen" :isEditable="$isEditable" >

    <x-slot name="header">
        <tr>
            <x-ui-th sort="asc">Desde</x-ui-th>
            <x-ui-th sort="asc">Hasta</x-ui-th>
            <x-ui-th sort="asc">Capital</x-ui-th>
            <x-ui-th sort="asc">Dividendos</x-ui-th>
            <x-ui-th sort="asc">Total</x-ui-th>
            <x-ui-th >Acciones</x-ui-th>
        <tr>
    </x-slot>

    <x-slot name="form">
        <x-ui-input-text wire:model="model.fecha_operacion" id="fecha_operacion">Fecha de la operacion: </x-ui-input-text>
        <x-ui-input-text wire:model="model.observaciones">Observaciones: </x-ui-input-text>
    </x-slot>

    <x-slot name="buttons">
        <x-ui-button-cancel />
        @if($isEditable)
            <x-ui-button-store />
        @endif
    </x-slot>

    @foreach($resultados as $resultado)
    <tr>
        <x-ui-td>
            {{ $resultado->fecha_inicial->format('d/m/Y') }}
        </x-ui-td>
        <x-ui-td>
            {{ $resultado->fecha_final->format('d/m/Y') }}
        </x-ui-td>
        <x-ui-td>
        </x-ui-td>
        <x-ui-td>
        </x-ui-td>
        <x-ui-td>
        </x-ui-td>
        <x-ui-td-actions :id="$resultado->id"/>
    <tr>
    @endforeach

</x-ui-crud-table>