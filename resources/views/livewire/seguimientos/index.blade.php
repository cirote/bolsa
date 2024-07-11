<x-ui-crud-table title="Seguimientos de precios" :model="$seguimientos" :mode="$mode">

    <x-slot name="header">
        <x-ui-tr>
            <x-ui-th>Simbolo</x-ui-th>
            <x-ui-th>Activo</x-ui-th>
            <x-ui-th>Modelo</x-ui-th>
            <x-ui-th>Cotizacion</x-ui-th>
            <x-ui-th>Base actual</x-ui-th>
            <x-ui-th>Techo actual</x-ui-th>
            <x-ui-th>Puntaje</x-ui-th>
            <x-ui-th>Estado</x-ui-th>
            <x-ui-th>Acciones</x-ui-th>
        </x-ui-tr>
    </x-slot>

    <x-slot name="form">
        <x-ui-row>

            <x-ui-column number='12'>
                <x-ui-input-select item="model.activo_id" options="{{ \App\Models\Activos\Activo::toOptions() }}">Denominacion: </x-ui-input-select>
            </x-ui-column>
        </x-ui-row>

        <x-ui-row>
            <x-ui-column number='12'>
                <x-ui-input-text item="model.comentarios">Comentarios: </x-ui-input-text>
            </x-ui-column>
        </x-ui-row>

        <x-ui-row>
            <x-ui-column number='12'>
                <x-ui-input-text item="model.tipo">Tipo: </x-ui-input-text>
            </x-ui-column>
        </x-ui-row>

        <x-ui-row>
            <x-ui-column number='6'>
                <x-ui-input-fecha item="model.fecha_1">Fecha inicial: </x-ui-input-fecha>
            </x-ui-column>
            <x-ui-column number='6'>
                <x-ui-input-number item="model.base_1">Base inicial: </x-ui-input-number>
            </x-ui-column>
        </x-ui-row>

        <x-ui-row>
            <x-ui-column number='6'>
                <x-ui-input-fecha item="model.fecha_2">Fecha final: </x-ui-input-fecha>
            </x-ui-column>
            <x-ui-column number='6'>
                <x-ui-input-number item="model.base_2">Base final: </x-ui-input-number>
            </x-ui-column>
        </x-ui-row>

        <x-ui-row>
            <x-ui-column number='6'>
                <x-ui-input-number item="model.amplitud">Amplitud: </x-ui-input-number>
            </x-ui-column>
        </x-ui-row>

        <x-ui-row>
            <x-ui-column number='6'>
                <x-ui-input-number item="model.piso">Piso: </x-ui-input-number>
            </x-ui-column>
            <x-ui-column number='6'>
                <x-ui-input-number item="model.techo">Techo: </x-ui-input-number>
            </x-ui-column>
        </x-ui-row>

    </x-slot>

    @if ($mode == 'TABLE')
    @foreach($seguimientos as $seguimiento)
    <x-ui-tr>
        <x-ui-td>{{ $seguimiento->activo->simbolo }}</x-ui-td>
        <x-ui-td>{{ $seguimiento->activo->denominacion }}</x-ui-td>
        <x-ui-td>{{ $seguimiento->tipo }}</x-ui-td>
        <x-ui-td number="{{ $seguimiento->activo->cotizacion }}" />
        <x-ui-td number="{{ $seguimiento->base }}" />
        <x-ui-td number="{{ $seguimiento->techoCalculado }}" />
        <x-ui-td number="{{ $seguimiento->puntaje * 100 }}" />
        <x-ui-td>{{ $seguimiento->accion }}</x-ui-td>
        <x-ui-td-actions :id="$seguimiento->id">
            <x-ui-button type="info" wire:click="trading({{ $seguimiento->activo->id }})">
                <i class="fa-solid fa-cart-shopping"></i>
                Trading
            </x-ui-button>
        </x-ui-td-actions>
    </x-ui-tr>
    @endforeach
    @endif

</x-ui-crud-table>