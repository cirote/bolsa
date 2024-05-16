<x-ui-crud-table title="Lista de cuentas corrientes" :mode="$mode">

    <x-slot name="header">
        <tr>
            <x-ui-th sort="asc">Sigla</x-ui-th>
            <x-ui-th sort="desc">Nombre</x-ui-th>
            <x-ui-th>Moneda</x-ui-th>
            <x-ui-th>Saldo</x-ui-th>
            <x-ui-th>Acciones</x-ui-th>
        <tr>
    </x-slot>

    <x-slot name="footer">
        <tr>
            <x-ui-th sort="asc">Sigla</x-ui-th>
            <x-ui-th sort="desc">Nombre</x-ui-th>
            <x-ui-th>Moneda</x-ui-th>
            <x-ui-th>Saldo</x-ui-th>
            <x-ui-th width="250px">Acciones</x-ui-th>
        <tr>
    </x-slot>

    <x-slot name="nav">
        {{ $cuentas->links() }}
    </x-slot>

    <x-slot name="form">
        <x-ui-input-text wire:model="model.sigla" id="sigla">Sigla: </x-ui-input-text>
        <x-ui-input-text wire:model="model.nombre">Nombre del Broker: </x-ui-input-text>
    </x-slot>

    <x-slot name="buttons">
        {{-- <x-ui-button-cancel /> --}}
        @if ($mode == 'EDIT')
            {{-- <x-ui-button-store /> --}}
        @endif
    </x-slot>

    @foreach ($cuentas as $cuenta)
        <tr>
            <x-ui-td>{{ $cuenta->sigla }}</x-ui-td>
            <x-ui-td>{{ $cuenta->nombre }}</x-ui-td>
            <x-ui-td>{{ $cuenta->moneda->denominacion }}</x-ui-td>
            <x-ui-td align='right'>{{ number_format($cuenta->saldo, 2, ',', '.') }}</x-ui-td>
            <x-ui-td-actions :id="$cuenta->id">
                <x-ui-button wire:click="ver_cuenta({{ $cuenta->id }})">
                    <i class="fa fa-eye"></i>
                    Ver
                </x-ui-button>
            </x-ui-td-actions>
        <tr>
    @endforeach

</x-ui-crud-table>
