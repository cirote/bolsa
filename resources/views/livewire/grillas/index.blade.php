<x-ui-crud-table title="Bandas de Precios" :model="$grillas" :mode="$mode" create=true>

    <x-slot name="header">
        <x-ui-tr>
            <x-ui-th>Simbolo</x-ui-th>
            <x-ui-th>Activo</x-ui-th>
            <x-ui-th>Desde</x-ui-th>
            <x-ui-th>Cotización</x-ui-th>
            <x-ui-th>Precio de activación</x-ui-th>
            <x-ui-th>Estado</x-ui-th>
            <x-ui-th >Acciones</x-ui-th>
        </x-ui-tr>
    </x-slot>

    <x-slot name="form">
        <x-ui-input-select item="model.activo_id" options="{{ \App\Models\Activos\Activo::toOptions() }}">Denominacion: </x-ui-input-select>
        <x-ui-input-date   item="model.fecha_inicial">Fecha: </x-ui-input-date>
        <x-ui-input-precio item="model.precio_activacion">Precio de activación: </x-ui-input-precio>
    </x-slot>

    @foreach($grillas as $grilla)
        <x-ui-tr>
            <x-ui-td>{{ $grilla->activo->simbolo }}</x-ui-td>
            <x-ui-td>{{ $grilla->activo->denominacion }}</x-ui-td>
            <x-ui-td>{{ $grilla->fecha_inicial->format('d/m/Y') }}</x-ui-td>
            <x-ui-td number="{{ $grilla->cotizacionDelActivo }}" d=2 />
            @if($grilla->precio_activacion !== null)
                <x-ui-td number="{{ $grilla->precio_activacion }}" d=2 />
            @else
                <x-ui-td />
            @endif
            <x-ui-td>{{ $grilla->estado }}</x-ui-td>
            <x-ui-td-actions :id="$grilla->id">
                <x-botonTrading wid="{{ $grilla->activo->id }}" />
                @if($grilla->precio_activacion !== null)
                    <x-ui-button wire:click="activar({{ $grilla->id }})">
                        <i class="fa fa-play"></i>
                        Activar
                    </x-ui-button>
                @else
                    <x-botonBanda wid="{{ $grilla->id }}" />
                @endif
            </x-ui-td-actions>
        </x-ui-tr>
    @endforeach

</x-ui-crud-table>