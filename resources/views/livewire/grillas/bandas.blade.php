<x-ui-crud-table title="Bandas de Precios de ({{ $activo->simbolo }}) {{ $activo->denominacion }} {{ $activo->stock ? ' - Stock actual de ' . $activo->stock . ' acciones' : '' }}" :model="$bandas" :mode="$mode" create=true>

    <x-slot name="header">
        <tr>
            <x-ui-th sorteable='precio' sortby='{{ $sort_by }}' sortorder='{{ $sort_order }}'>Precio</x-ui-th>
            <x-ui-th sorteable='monto' sortby='{{ $sort_by }}' sortorder='{{ $sort_order }}'>Monto</x-ui-th>
            <x-ui-th sorteable='cantidad' sortby='{{ $sort_by }}' sortorder='{{ $sort_order }}'>Cantidad</x-ui-th>
            <x-ui-th>Stock teórico</x-ui-th>
            <x-ui-th>Limite inferior</x-ui-th>
            <x-ui-th>Limite superior</x-ui-th>
            <x-ui-th>Estado</x-ui-th>
            <x-ui-th>Entorno</x-ui-th>
            <x-ui-th>Id Actual</x-ui-th>
            <x-ui-th >Acciones</x-ui-th>
        <tr>
    </x-slot>

    <x-slot name="form">
        <x-ui-input-precio item="model.precio">Precio: </x-ui-input-precio>
        <x-ui-input-precio item="model.monto">Monto: </x-ui-input-precio>
        <x-ui-input-number item="model.cantidad">Cantidad: </x-ui-input-number>
    </x-slot>

    @php($stock = 0)

    @foreach($bandas as $banda)
        @php($stock += $banda->cantidad)
        <x-ui-tr>
            <x-ui-td align="right">
                {{ number_format($banda->precio, 2, ',', '.') }} 
                @if(($banda->grilla->idBandaActual == $banda->id))
                (
                    <span class="text-success">Actual {{ number_format($activo->cotizacion, 2, ',', '.') }}</span>
                )
                @endif
            </x-ui-td>
            <x-ui-td number="{{ $banda->monto }}" d='2'/>
            <x-ui-td number="{{ $banda->cantidad }}" d='0'/>
            <x-ui-td align="right">
                {{ number_format($stock, 0, ',', '.') }} 
                @if(($banda->grilla->idBandaActual == $banda->id) && ($activo->stock != $stock))
                (
                    @if($activo->stock < $stock)
                        <span class="text-danger">Faltan {{ number_format($activo->stock - $stock, 0, ',', '.') }} acciones</span>
                    @else
                        <span class="text-success">Sobran {{ number_format(abs($stock - $activo->stock), 0, ',', '.') }} acciones</span>
                    @endif
                )
                @endif
            </x-ui-td>
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