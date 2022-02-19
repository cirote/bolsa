<x-ui-crud-table :isOpen="$isOpen" :isEditable="$isEditable" >

    <x-slot name="header">
        <tr>
            <x-ui-th sort="asc">Activo</x-ui-th>
            <x-ui-th sort="asc">Cotizacion</x-ui-th>
            <x-ui-th sort="desc">Puntaje</x-ui-th>
            <x-ui-th sort="desc">Accion</x-ui-th>
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

    @foreach($seguimientos as $seguimiento)
    <tr>
        <x-ui-td>{{ $seguimiento->activo->denominacion }}</x-ui-td>
        <x-ui-td align='right'>{{ number_format($seguimiento->activo->cotizacion, 2, ',', '.') }}</x-ui-td>
        <x-ui-td align='right'>{{ number_format($seguimiento->puntaje * 100, 2, ',', '.') }}</x-ui-td>
        <x-ui-td>{{ $seguimiento->accion }}</x-ui-td>
        <x-ui-td-actions :id="$seguimiento->id"/>
    <tr>
    @endforeach

</x-ui-crud-table>