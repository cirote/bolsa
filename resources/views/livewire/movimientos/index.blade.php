<x-ui-crud-table title="Movimientos" :model="$movimientos" :mode="$mode">

    <x-slot name="header">
        <tr>
            <x-ui-th sorteable="fecha_operacion" sortby="{{ $sort_by }}" sortorder="{{ $sort_order }}">Fecha</x-ui-th>
            <x-ui-th>Clase</x-ui-th>
            <x-ui-th sorteable="numero_operacion" sortby="{{ $sort_by }}" sortorder="{{ $sort_order }}">Número</x-ui-th>
            <x-ui-th sorteable="observaciones" sortby="{{ $sort_by }}" sortorder="{{ $sort_order }}">Observaciones</x-ui-th>
            <x-ui-th>Cantidad</x-ui-th>
            <x-ui-th>Monto</x-ui-th>
            <x-ui-th>Saldo</x-ui-th>
            <x-ui-th width="250px">Acciones</x-ui-th>
        <tr>
    </x-slot>

    <x-slot name="form">
        <x-ui-row>
            <x-ui-column number='6'>
                <x-ui-input-fecha item="model.fecha_operacion">Fecha de operación: </x-ui-input-fecha>
            </x-ui-column>
            <x-ui-column number='6'>
                <x-ui-input-fecha item="model.fecha_liquidacion">Fecha de liquidación: </x-ui-input-fecha>
            </x-ui-column>
        </x-ui-row>

        <x-ui-row>
            <x-ui-column number='6'>
                <x-ui-input-number item="model.numero_operacion">Número de operación: </x-ui-input-number>
            </x-ui-column>
            <x-ui-column number='6'>
                <x-ui-input-number item="model.numero_boleto">Boleto: </x-ui-input-number>
            </x-ui-column>
        </x-ui-row>

        <x-ui-row>
            <x-ui-column number='12'>
                <x-ui-input-select item="model.type" options="App\Models\Movimientos\Comision:Comisión|App\Models\Movimientos\Compra:Compra|App\Models\Movimientos\Deposito:Deposito|App\Models\Movimientos\Dividendo:Dividendo|App\Models\Movimientos\Ejercicio:Ejercicio|App\Models\Movimientos\Envio:Envio|App\Models\Movimientos\Extraccion:Extracción|App\Models\Movimientos\Lanzamiento:Lanzamiento|App\Models\Movimientos\Movimiento:Movimiento|App\Models\Movimientos\Recepcion:Recepción|App\Models\Movimientos\Venta:Venta">
                    Tipo de operación: 
                </x-ui-input-select>
            </x-ui-column>
        </x-ui-row>

        <x-ui-row>
            <x-ui-column number='12'>
                <x-ui-input-text item="model.observaciones">Observaciones: </x-ui-input-text>
            </x-ui-column>
        </x-ui-row>

        <x-ui-row>
            <x-ui-column number='6'>
                <x-ui-input-number item="model.cantidad">Cantidad operada: </x-ui-input-number>
            </x-ui-column>
            <x-ui-column number='6'>
                <x-ui-input-precio item="model.monto_en_dolares">Monto en dólares de operación: </x-ui-input-precio>
            </x-ui-column>
        </x-ui-row>

    </x-slot>

    @foreach($movimientos as $movimiento)
    <tr>
        <x-ui-td>{{ $movimiento->fecha_operacion->format('d-m-Y') }}</x-ui-td>
        <x-ui-td>{{ $movimiento->clase }}</x-ui-td>
        <x-ui-td>{{ $movimiento->numero_operacion }}</x-ui-td>
        <x-ui-td>{{ $movimiento->observaciones }}</x-ui-td>
        <x-ui-td align='right'>{{ number_format($movimiento->cantidad, 0, ',', '.') }}</x-ui-td>
        <x-ui-td align='right'>{{ number_format($movimiento->monto_en_dolares, 2, ',', '.') }}</x-ui-td>
        <x-ui-td align='right'>{{ number_format($movimiento->saldo, 2, ',', '.') }}</x-ui-td>
        <x-ui-td-actions :id="$movimiento->id"/>
    <tr>
    @endforeach

</x-ui-crud-table>