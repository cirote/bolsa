<x-ui-crud-table :isOpen="$isOpen" :isEditable="$isEditable" >

    <x-slot name="header">
        <tr>
            <x-ui-th>Activo</x-ui-th>
            <x-ui-th>Tipo</x-ui-th>
            <x-ui-th>Cantidad</x-ui-th>
            <x-ui-th>Inversión</x-ui-th>
            <x-ui-th>Costo Unitario</x-ui-th>
            <x-ui-th>Precio Actual</x-ui-th>
            <x-ui-th>Valor Actual</x-ui-th>
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

    @php($ii = 0)
    @php($rr = 0)
    @php($vv = 0)
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
            @php($ii += $i)
                {{ number_format($i, 2, ',', '.') }}
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
            @php($vv += $posicion->valor)
                {{ number_format($posicion->valor, 2, ',', '.') }}
            @endif
        </x-ui-td>
        <x-ui-td align='right'>
            @if($c)
            @php($rr += $posicion->resultado)
                {{ number_format($posicion->resultado, 2, ',', '.') }}
            @endif
        </x-ui-td>
    <tr>
    @endforeach

    <tr>
        <x-ui-td rowspan="3" align="center">
            <b>Totales</b>
        </x-ui-td>
        <x-ui-td></x-ui-td>
        <x-ui-td align='right'>
        </x-ui-td>
        <x-ui-td align='right'>
            @if($ii)
                {{ number_format($ii, 2, ',', '.') }}
            @endif
        </x-ui-td>
        <x-ui-td align='right'>
        </x-ui-td>
        <x-ui-td align='right'>
        </x-ui-td>
        <x-ui-td align='right'>
            @if($vv)
                {{ number_format($vv, 2, ',', '.') }}
            @endif
        </x-ui-td>
        <x-ui-td align='right'>
            @if($rr)
                {{ number_format($rr, 2, ',', '.') }}
            @endif
        </x-ui-td>
    <tr>

</x-ui-crud-table>