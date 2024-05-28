<x-ui-crud-table title="Bandas de Precios de ({{ $activo->simbolo }}) {{ $activo->denominacion }}" :model="$bandas" :mode="$mode">

    <x-slot name="header">
        <tr>
            <x-ui-th sort="desc">Precio</x-ui-th>
            <x-ui-th>Monto</x-ui-th>
            <x-ui-th>Cantidad</x-ui-th>
            <x-ui-th>Limite inferior</x-ui-th>
            <x-ui-th>Limite superior</x-ui-th>
            <x-ui-th>Precio activo</x-ui-th>
            <x-ui-th>Estado</x-ui-th>
            <x-ui-th>Entorno</x-ui-th>
            <x-ui-th>Id Actual</x-ui-th>
            <x-ui-th >Acciones</x-ui-th>
        <tr>
    </x-slot>

    <x-slot name="form">
        <x-ui-input-number item="model.precio">Precio: </x-ui-input-number>
        <x-ui-input-number item="model.monto">Monto: </x-ui-input-number>
        <x-ui-input-number item="model.cantidad">Cantidad: </x-ui-input-number>
    </x-slot>

    <x-slot name="buttons">
        <x-ui-button-cancel />
        @if ($mode == 'EDIT')
            <x-ui-button-store />
        @elseif ($mode == 'CREATE')
            <x-ui-button-store />
        @endif
    </x-slot>

    @foreach($bandas as $banda)
    <tr>
        <x-ui-td>{{ $banda->precio }}</x-ui-td>
        <x-ui-td>{{ $banda->monto }}</x-ui-td>
        <x-ui-td>{{ $banda->cantidad }}</x-ui-td>
        <x-ui-td>{{ $banda->limite_inferior }}</x-ui-td>
        <x-ui-td>{{ $banda->limite_superior }}</x-ui-td>
        <x-ui-td>{{ $banda->precio_activo }}</x-ui-td>
        <x-ui-td>{{ $banda->estado ? 'Activa' : '' }}</x-ui-td>
        <x-ui-td>{{ $banda->precioEnEntorno ? 'Si' : 'No' }}</x-ui-td>
        <x-ui-td>{{ $banda->grilla->idBandaActual }}</x-ui-td>
        <x-ui-td-actions :id="$banda->id">
            @if (! $banda->estado)
            <x-ui-button wire:click="activar({{ $banda->id }})">
                <i class="fa fa-bars"></i>
                Activar
            </x-ui-button>
            @endif
        </x-ui-td-actions>
    <tr>
    @endforeach

</x-ui-crud-table>