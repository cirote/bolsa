<x-ui-crud-table title="Lista de activos" :model="$activos" :mode="$mode">

    <x-slot name="header">
        <tr>
            <x-ui-th sort="asc">Simbolo</x-ui-th>
            <x-ui-th sort="desc">Denominacion</x-ui-th>
            <x-ui-th sort="desc">Cotizacion</x-ui-th>
            <x-ui-th sort="desc">Cabmio</x-ui-th>
            <x-ui-th >Acciones</x-ui-th>
        <tr>
    </x-slot>

    <x-slot name="form">
        <x-ui-input-text wire:model="model.simbolo" id="simbolo">Simbolo: </x-ui-input-text>
        <x-ui-input-text wire:model="model.denominacion">Denominacion: </x-ui-input-text>
    </x-slot>

    <x-slot name="buttons">
        <x-ui-button-cancel />
        @if ($mode == 'EDIT')
            <x-ui-button-store />
        @endif
    </x-slot>

    @foreach($activos as $activo)
    <tr>
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
            <x-ui-button wire:click="ver_bandas({{ $activo->id }})">
                <i class="fa fa-bars"></i>
                Bandas
            </x-ui-button>
        </x-ui-td-actions>

    <tr>
    @endforeach

</x-ui-crud-table>