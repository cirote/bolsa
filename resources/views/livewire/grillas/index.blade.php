<x-ui-crud-table title="Bandas de Precios" :model="$grillas" :mode="$mode">

    <x-slot name="header">
        <tr>
            <x-ui-th sort="asc">Simbolo</x-ui-th>
            <x-ui-th>Denominacion</x-ui-th>
            <x-ui-th>Desde</x-ui-th>
            <x-ui-th>Estado</x-ui-th>
            <x-ui-th >Acciones</x-ui-th>
        <tr>
    </x-slot>

    <x-slot name="form">
        {{-- <x-ui-input-text wire:model="simbolo" id="simbolo">Simbolo: </x-ui-input-text> --}}
        <x-ui-input-select item="model.activo_id">Denominacion: </x-ui-input-select>
        <x-ui-input-fecha item="model.fecha_inicial">Fecha: </x-ui-input-fecha>
    </x-slot>

    <x-slot name="buttons">
        <x-ui-button-cancel />
        @if ($mode == 'EDIT')
            <x-ui-button-store />
        @elseif ($mode == 'CREATE')
            <x-ui-button-store />
        @endif
    </x-slot>

    @foreach($grillas as $grilla)
    <tr>
        <x-ui-td>{{ $grilla->activo->simbolo }}</x-ui-td>
        <x-ui-td>{{ $grilla->activo->denominacion }}</x-ui-td>
        <x-ui-td>{{ $grilla->fecha_inicial->format('d/m/Y') }}</x-ui-td>
        <x-ui-td>{{ $grilla->hayCambioDeBanda ? 'Cambio de banda' : '' }}</x-ui-td>
        <x-ui-td-actions :id="$grilla->id">
            <x-ui-button wire:click="ver_bandas({{ $grilla->id }})">
                <i class="fa fa-bars"></i>
                Bandas
            </x-ui-button>
        </x-ui-td-actions>
    <tr>
    @endforeach

</x-ui-crud-table>