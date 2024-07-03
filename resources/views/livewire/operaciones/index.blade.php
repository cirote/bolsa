<x-ui-crud-table title="Detalle de operaciones" :model="$operaciones" :mode="$mode">

    <x-slot name="header">
        <tr>
            <x-ui-th sort="asc">Id</x-ui-th>
            <x-ui-th >Acciones</x-ui-th>
        <tr>
    </x-slot>

    <x-slot name="form">

    </x-slot>

    @foreach($operaciones as $operacion)
    <tr>
        <x-ui-td>{{ $operacion->id }}</x-ui-td>
        <x-ui-td-actions :id="$operacion->id">
            <x-ui-button wire:click="ver_bandas({{ $operacion->id }})">
                <i class="fa fa-bars"></i>
                Bandas
            </x-ui-button>
        </x-ui-td-actions>

    <tr>
    @endforeach

</x-ui-crud-table>