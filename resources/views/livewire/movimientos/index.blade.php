<x-ui-crud-table :isOpen="$isOpen" :isEditable="$isEditable" >

    <x-slot name="header">
        <tr>
            <x-ui-th sort="asc">Fecha</x-ui-th>
            <x-ui-th>Clase</x-ui-th>
            <x-ui-th>Número</x-ui-th>
            <x-ui-th sort="desc">Observaciones</x-ui-th>
            <x-ui-th>Cantidad</x-ui-th>
            <x-ui-th>Monto</x-ui-th>
            <x-ui-th>Saldo</x-ui-th>
            <x-ui-th>Acciones</x-ui-th>
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

    @foreach($movimientos as $movimiento)
    <tr>
        <x-ui-td>{{ $movimiento->fecha_operacion->format('d-m-Y') }}</x-ui-td>
        <x-ui-td>{{ $movimiento->clase }}</x-ui-td>
        <x-ui-td>{{ $movimiento->numero_operacion }}</x-ui-td>
        <x-ui-td>{{ $movimiento->observaciones }}</x-ui-td>
        <x-ui-td align='right'>{{ number_format($movimiento->cantidad, 0, ',', '.') }}</x-ui-td>
        <x-ui-td align='right'>{{ number_format($movimiento->monto, 2, ',', '.') }}</x-ui-td>
        <x-ui-td align='right'>{{ number_format($movimiento->saldo, 2, ',', '.') }}</x-ui-td>
        <x-ui-td-actions :id="$movimiento->id"/>
    <tr>
    @endforeach

</x-ui-crud-table>