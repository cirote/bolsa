<x-ui-crud-table :isOpen="$isOpen" :isEditable="$isEditable">

    <x-slot name="header">
        <tr>
            <x-ui-th sort="asc" style="width: 10%">Sigla</x-ui-th>
            <x-ui-th sort="desc" style="width: 90px">Nombre</x-ui-th>
            <th style="width: 50px"></th>
        <tr>
    </x-slot>

    <x-slot name="form">
        <x-ui-input-text wire:model="model.sigla">Sigla: </x-ui-input-text>
        <x-ui-input-text wire:model="model.nombre">Nombre del Broker: </x-ui-input-text>
    </x-slot>

    <x-slot name="buttons">
        <button wire:click="close" type="button" class="btn btn-warning" data-dismiss="modal">@lang('entradas.b_cerrar')</button>
        @if($isEditable)
            <button wire:click.prevent="store" type="button" class="btn btn-primary">@lang('entradas.b_guardar')</button>
        @endif
    </x-slot>

    @foreach($brokers as $broker)
    <tr>
        <x-ui-td>{{ $broker->sigla }}</x-ui-td>
        <x-ui-td>{{ $broker->nombre }}</x-ui-td>
        <x-ui-td>
            <x-ui-edit-button :id="$broker->id"/>
        </x-ui-td>
    <tr>
    @endforeach

</x-ui-crud-table>