<x-ui-crud-table title="Detalle de operaciones" :model="$operaciones" :mode="$mode">

    <x-slot name="header">
        <x-ui-tr>
            <x-ui-th sorteable='id' sortby='{{ $sort_by }}' sortorder='{{ $sort_order }}' />
            <x-ui-th sorteable='fecha' sortby='{{ $sort_by }}' sortorder='{{ $sort_order }}' />
            <x-ui-th>Activo</x-ui-th>
            <x-ui-th>Clase</x-ui-th>
            <x-ui-th sorteable='observaciones' sortby='{{ $sort_by }}' sortorder='{{ $sort_order }}' />
            <x-ui-th sorteable='monto' sortby='{{ $sort_by }}' sortorder='{{ $sort_order }}' />
            <x-ui-th sorteable='cantidad' sortby='{{ $sort_by }}' sortorder='{{ $sort_order }}' />
            <x-ui-th sorteable='elementos' sortby='{{ $sort_by }}' sortorder='{{ $sort_order }}' />
            <x-ui-th >Acciones</x-ui-th>
        </x-ui-tr>
    </x-slot>

    <x-slot name="form">
        <x-ui-input-select item="model.activo_id" options="{{ \App\Models\Activos\Activo::toOptions() }}">Activo: </x-ui-input-select>
        <x-ui-input-select item="model.type" options="App\Models\Operaciones\Comision:Comisión|App\Models\Operaciones\Compra:Compra|App\Models\Operaciones\Deposito:Deposito|App\Models\Operaciones\Dividendo:Dividendo|App\Models\Operaciones\Ejercicio:Ejercicio|App\Models\Operaciones\Envio:Envio|App\Models\Operaciones\Extraccion:Extracción|App\Models\Operaciones\Impuesto:Impuesto|App\Models\Operaciones\Lanzamiento:Lanzamiento|App\Models\Operaciones\Movimiento:Movimiento|App\Models\Operaciones\Recepcion:Recepción|App\Models\Operaciones\Venta:Venta">
            Tipo de operación: 
        </x-ui-input-select>
        <x-ui-input-text item="model.observaciones">Observaciones: </x-ui-input-text>
    </x-slot>

    @foreach($operaciones as $operacion)
        <x-ui-tr>
            <x-ui-td>{{ $operacion->id }}</x-ui-td>
            <x-ui-td>{{ $operacion->fecha ? $operacion->fecha->format('d/m/Y') : '' }}</x-ui-td>
            <x-ui-td>{{ $operacion->activo ? $operacion->activo->denominacion : ''  }}</x-ui-td>
            <x-ui-td>{{ $operacion->clase ?? '' }}</x-ui-td>
            <x-ui-td>{{ $operacion->observaciones }}</x-ui-td>
            <x-ui-td number="{{ $operacion->monto }}" />
            <x-ui-td number="{{ $operacion->cantidad }}" decimals="0" />
            <x-ui-td number="{{ $operacion->elementos }}" decimals="0" />
            <x-ui-td-actions :id="$operacion->id">
                @if($operacion->activo)       
                    <x-botonTrading wid="{{ $operacion->activo->id }}" />
                @endif
            </x-ui-td-actions>
        </x-ui-tr>
    @endforeach

</x-ui-crud-table>