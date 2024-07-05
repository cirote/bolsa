<x-ui-crud-table title="Detalle de operaciones" :model="$operaciones" :mode="$mode">

    <x-slot name="header">
        <x-ui-tr>
            <x-ui-th sorteable='id' sortby='{{ $sort_by }}' sortorder='{{ $sort_order }}' />
            <x-ui-th sorteable='fecha' sortby='{{ $sort_by }}' sortorder='{{ $sort_order }}' />
            <x-ui-th sorteable='activo' sortby='{{ $sort_by }}' sortorder='{{ $sort_order }}' />
            <x-ui-th sorteable='monto' sortby='{{ $sort_by }}' sortorder='{{ $sort_order }}' />
            <x-ui-th sorteable='cantidad' sortby='{{ $sort_by }}' sortorder='{{ $sort_order }}' />
            <x-ui-th sorteable='elementos' sortby='{{ $sort_by }}' sortorder='{{ $sort_order }}' />
            <x-ui-th >Acciones</x-ui-th>
        </x-ui-tr>
    </x-slot>

    <x-slot name="form">

    </x-slot>

    @foreach($operaciones as $operacion)
    <x-ui-tr>
        <x-ui-td>{{ $operacion->id }}</x-ui-td>
        <x-ui-td>{{ $operacion->fecha->format('d/m/Y') }}</x-ui-td>
        <x-ui-td>{{ '' }}</x-ui-td>
        <x-ui-td number="{{ $operacion->monto }}" />
        <x-ui-td number="{{ $operacion->cantidad }}" decimals="0" />
        <x-ui-td number="{{ $operacion->elementos }}" decimals="0" />
        <x-ui-td-actions :id="$operacion->id">
            <x-ui-button wire:click="ver_bandas({{ $operacion->id }})">
                <i class="fa fa-bars"></i>
                Bandas
            </x-ui-button>
        </x-ui-td-actions>
    </x-ui-tr>
    @endforeach

</x-ui-crud-table>