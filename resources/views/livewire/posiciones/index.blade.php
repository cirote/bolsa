<x-ui-crud-table :isOpen="$isOpen" :isEditable="$isEditable" >

    <x-slot name="header">
        <tr>
            <x-ui-th sort="asc">Apertura</x-ui-th>
            <x-ui-th>Cierre</x-ui-th>
            <x-ui-th sort="desc">Activo</x-ui-th>
            <x-ui-th sort="desc">Tipo</x-ui-th>
            <x-ui-th>Cantidad</x-ui-th>
            <x-ui-th sort="desc">Estado</x-ui-th>
            <x-ui-th>Resultado</x-ui-th>
            <x-ui-th >Acciones</x-ui-th>
        <tr>
    </x-slot>

    <x-slot name="form">
        <x-ui-input-text wire:model="model.fecha_apertura" id="fecha_apertura">Fecha de apertura: </x-ui-input-text>
        <x-ui-input-text wire:model="model.tipo">Tipo: </x-ui-input-text>
        <x-ui-input-text wire:model="model.estado">Estado: </x-ui-input-text>
    </x-slot>

    <x-slot name="buttons">
        <x-ui-button-cancel />
        @if($isEditable)
            <x-ui-button-store />
        @endif
    </x-slot>

    @foreach($posiciones as $posicion)
    <tr>
        <x-ui-td>{{ $posicion->fecha_apertura->format('d-m-Y') }}</x-ui-td>
        <x-ui-td>@if ($posicion->fecha_cierre) {{ $posicion->fecha_cierre->format('d-m-Y') }} @endif</x-ui-td>
        <x-ui-td>{{ $posicion->activo->denominacion }}</x-ui-td>
        <x-ui-td>{{ $posicion->tipo }}</x-ui-td>
        <x-ui-td align='right'>{{ $posicion->cantidad }}</x-ui-td>
        <x-ui-td>{{ $posicion->estado }}</x-ui-td>
        <x-ui-td align='right'>@if ($posicion->fecha_cierre) {{ number_format($posicion->resultado, 2, ',', '.') }} @endif</x-ui-td>
        <x-ui-td-actions :id="$posicion->id"/>
    <tr>
    @endforeach

</x-ui-crud-table>