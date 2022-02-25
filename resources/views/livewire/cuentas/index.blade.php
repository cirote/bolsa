<x-ui-crud-table :isOpen="$isOpen" :isEditable="$isEditable">

    <x-slot name="header">
        <tr>
            <x-ui-th sort="asc">Sigla</x-ui-th>
            <x-ui-th sort="desc">Nombre</x-ui-th>
            <x-ui-th>Acciones</x-ui-th>
        <tr>
    </x-slot>

    <x-slot name="form">
        <x-ui-input-text wire:model="model.sigla" id="sigla">Sigla: </x-ui-input-text>
        <x-ui-input-text wire:model="model.nombre">Nombre del Broker: </x-ui-input-text>
    </x-slot>

    <x-slot name="buttons">
        <x-ui-button-cancel />
        @if($isEditable)
        <x-ui-button-store />
        @endif
    </x-slot>

    @foreach($cuentas as $cuenta)
    <tr>
        <x-ui-td>{{ $cuenta->sigla }}</x-ui-td>
        <x-ui-td>{{ $cuenta->nombre }}</x-ui-td>
        <x-ui-td-actions :id="$cuenta->id">
            <x-ui-button wire:click="ver_cuenta({{ $cuenta->id }})">
                Ver
            </x-ui-button>
        </x-ui-td-actions>
    <tr>
        @endforeach

</x-ui-crud-table>