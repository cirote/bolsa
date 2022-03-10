<x-ui-crud-table :isOpen="$isOpen" :isEditable="$isEditable" >

    <x-slot name="header">
        <tr>
            <x-ui-th>Activo</x-ui-th>
            <x-ui-th>Tipo</x-ui-th>
            <x-ui-th>Cantidad</x-ui-th>
            <x-ui-th>Inversión</x-ui-th>
            <x-ui-th>Costo Unitario</x-ui-th>
            <x-ui-th>Precio Actual</x-ui-th>
            <x-ui-th>Resultado Esperado</x-ui-th>
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
        <x-ui-td>
            @if($posicion->activo)
                {{ $posicion->activo->denominacion }}
            @endif
        </x-ui-td>
        <x-ui-td>{{ $posicion->clase }}</x-ui-td>
        <x-ui-td align='right'>
            @if($c = $posicion->cantidad)
                {{ number_format($c, 0, ',', '.') }}
            @endif
        </x-ui-td>
        <x-ui-td align='right'>
            @if($i = $posicion->inversion)
                {{ number_format($i, 0, ',', '.') }}
            @endif
        </x-ui-td>
        <x-ui-td align='right'>
            @if($c)
                {{ number_format($posicion->unitario, 2, ',', '.') }}
            @endif
        </x-ui-td>
        <x-ui-td align='right'>
            @if($p = $posicion->precio)
                {{ number_format($p, 2, ',', '.') }}
            @endif
        </x-ui-td>
        <x-ui-td align='right'>
            @if($c)
                {{ number_format($posicion->resultado, 2, ',', '.') }}
            @endif
        </x-ui-td>
    <tr>
    @endforeach

</x-ui-crud-table>