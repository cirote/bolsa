<x-ui-crud-table title="Lista de cuentas corrientes" :model="$cuentas" :mode="$mode">

    <x-slot name="header">
        <x-ui-tr>
            <x-ui-th sorteable='sigla' sortby='{{ $sort_by }}' sortorder='{{ $sort_order }}'>Sigla</x-ui-th>
            <x-ui-th sorteable='nombre' sortby='{{ $sort_by }}' sortorder='{{ $sort_order }}'>Nombre</x-ui-th>
            <x-ui-th>Moneda</x-ui-th>
            <x-ui-th>Saldo</x-ui-th>
            <x-ui-th>Acciones</x-ui-th>
        </x-ui-tr>
    </x-slot>

    <x-slot name="form">
        <x-ui-input-text item="model.nombre">Nombre de la cuenta: </x-ui-input-text>
        <x-ui-input-text item="model.sigla">Sigla: </x-ui-input-text>
    </x-slot>

    @foreach ($cuentas as $cuenta)
        <x-ui-tr>
            <x-ui-td>{{ $cuenta->sigla }}</x-ui-td>
            <x-ui-td>{{ $cuenta->nombre }}</x-ui-td>
            <x-ui-td>{{ $cuenta->moneda ? $cuenta->moneda->denominacion : 'Sin datos' }}</x-ui-td>
            <x-ui-td align='right'>{{ number_format($cuenta->saldo, 2, ',', '.') }}</x-ui-td>
            <x-ui-td-actions :id="$cuenta->id">
                <x-ui-button wire:click="ver_cuenta({{ $cuenta->id }})">
                    <i class="fa fa-eye"></i>
                    Ver
                </x-ui-button>
            </x-ui-td-actions>
        </x-ui-tr>
    @endforeach

</x-ui-crud-table>
