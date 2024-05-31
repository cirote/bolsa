<x-ui-crud-table title="Bandas de Precios de ({{ $activo->simbolo }}) {{ $activo->denominacion }}" :model="$bandas" :mode="$mode">

    <x-slot name="header">
        <tr>
            <x-ui-th sorteable='precio' sortby='{{ $sort_by }}' sortorder='{{ $sort_order }}'>Precio</x-ui-th>
            <x-ui-th sorteable='monto' sortby='{{ $sort_by }}' sortorder='{{ $sort_order }}'>Monto</x-ui-th>
            <x-ui-th sorteable='cantidad' sortby='{{ $sort_by }}' sortorder='{{ $sort_order }}'>Cantidad</x-ui-th>
            <x-ui-th>Limite inferior</x-ui-th>
            <x-ui-th>Limite superior</x-ui-th>
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
    <x-ui-tr bgcolor=''>
        <x-ui-td number="{{ $banda->precio }}" />
        <x-ui-td number="{{ $banda->monto }}" decimals='0'/>
        <x-ui-td number="{{ $banda->cantidad }}" decimals='0'/>
        <x-ui-td number="{{ $banda->limite_inferior }}" />
        <x-ui-td number="{{ $banda->limite_superior }}" />
        <x-ui-td>{{ $banda->estado ? 'Activa' : '' }}</x-ui-td>
        <x-ui-td>{{ $banda->precioEnEntorno ? 'Si' : 'No' }}</x-ui-td>
        <x-ui-td>{{ $banda->grilla->idBandaActual == $banda->id ? "Actual" : '' }}</x-ui-td>
        <x-ui-td-actions :id="$banda->id">
            @if (! $banda->estado)
            <x-ui-button wire:click="activar({{ $banda->id }})">
                <i class="fa fa-bars"></i>
                Activar
            </x-ui-button>
            @endif
        </x-ui-td-actions>
    </x-ui-tr>
    @endforeach

</x-ui-crud-table>