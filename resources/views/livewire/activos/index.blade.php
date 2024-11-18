<x-ui-crud-table title="Lista de activos" :model="$activos" :mode="$mode" create=true>

    <x-slot name="header">
        <x-ui-tr>
            <x-ui-th sort="asc">Simbolo</x-ui-th>
            <x-ui-th sort="desc">Denominacion</x-ui-th>
            <x-ui-th sort="desc">Cotizacion</x-ui-th>
            <x-ui-th sort="desc">Cabmio</x-ui-th>
            <x-ui-th >Acciones</x-ui-th>
        </x-ui-tr>
    </x-slot>

    <x-slot name="form">
        <x-ui-input-text item="model.simbolo">Simbolo: </x-ui-input-text>
        <x-ui-input-text item="model.denominacion">Denominacion: </x-ui-input-text>
    </x-slot>

    @foreach($activos as $activo)
    <x-ui-tr>
        <x-ui-td>{{ $activo->simbolo }}</x-ui-td>
        <x-ui-td>{{ $activo->denominacion }}</x-ui-td>
        <x-ui-td align='right'>
            @if(is_numeric($activo->cotizacion))
                {{ number_format($activo->cotizacion, 2, ',', '.') }}
            @else
                {{ $activo->cotizacion }}
            @endif
        </x-ui-td>
        <x-ui-td></x-ui-td>
        {{-- <x-ui-td>{{ \App\Models\Ccl::byDate('2013-12-12')->ccl }}</x-ui-td> --}}
        <x-ui-td-actions :id="$activo->id">
            <x-botonTrading wid="{{ $activo->id }}" />
        </x-ui-td-actions>
    </x-ui-tr>
    @endforeach

</x-ui-crud-table>