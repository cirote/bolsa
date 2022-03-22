<x-ui-crud-table :isOpen="$isOpen" :isEditable="$isEditable">

    <x-slot name="header">
        <tr>
            <x-ui-th sort="asc">Apertura</x-ui-th>
            <x-ui-th sort="desc">Activo</x-ui-th>
            <x-ui-th sort="desc">Tipo</x-ui-th>
            <x-ui-th>Cantidad</x-ui-th>
            <x-ui-th>Unitario</x-ui-th>
            <x-ui-th>Actual</x-ui-th>
            <x-ui-th>Costo / Ingreso</x-ui-th>
            <x-ui-th>Resultado</x-ui-th>
            <x-ui-th>Utilidad</x-ui-th>
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

    @foreach($posiciones as $posicion)
    <tr>
        <x-ui-td>{{ $posicion->fecha_apertura->format('d-m-Y') }}</x-ui-td>
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
            @if($un = $posicion->unitario)
            {{ number_format($un, 2, ',', '.') }}
            @endif
        </x-ui-td>
        <x-ui-td align='right'>
            @if($p = $posicion->precio)
            {{ number_format($p, 2, ',', '.') }}
            @endif
        </x-ui-td>
        <x-ui-td align='right'>
            @if($i = $posicion->inversion)
            @php($ii += $i)
            {{ number_format($i, 2, ',', '.') }}
            @endif
        </x-ui-td>
        <x-ui-td align='right'>
            @if($r = $posicion->resultado)
            @php($rr += $r)
            {{ number_format($r, 2, ',', '.') }}
            @endif
        </x-ui-td>
        <x-ui-td align='right'>
            @if($un = $posicion->utilidad)
            {{ number_format($un * 100, 2, ',', '.') }} %
            @endif
        </x-ui-td>
    <tr>
        @endforeach

    <tr>
        <x-ui-th rowspan="3" align="center">
            <b>Totales</b>
        </x-ui-th>
        <x-ui-td></x-ui-td>
        <x-ui-td></x-ui-td>
        <x-ui-td></x-ui-td>
        <x-ui-td></x-ui-td>
        <x-ui-td></x-ui-td>
        <x-ui-th align='right'>
            @if($ii)
            {{ number_format($ii, 2, ',', '.') }}
            @endif
        </x-ui-th>
        <x-ui-th align='right'>
            @if($rr)
            {{ number_format($rr, 2, ',', '.') }}
            @endif
        </x-ui-th>
        <x-ui-th align='right'>
            @if($ii)
            {{ number_format($rr / abs($ii) * 100, 2, ',', '.') }} %
            @endif
        </x-ui-th>
    <tr>

</x-ui-crud-table>