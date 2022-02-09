<x-ui-crud-table :isOpen="$isOpen" wire:model="model.nombre">

    <x-slot name="header">
        <tr>
            <x-ui-th sort="asc" style="width: 90px">Sigla</x-ui-th>
            <x-ui-th sort="desc" style="width: 90px">Nombre</x-ui-th>
            <th style="width: 50px"></th>
        <tr>
    </x-slot>

    <x-slot name="form">
        <form class="">
            <div class="row">
                <div class="col-lg-6">
                    <x-ui-input-text wire:model="model.nombre">Nombre del Broker</x-ui-input-text>
                </div>
            </div>
        </form>
    </x-slot>

    @foreach($brokers as $broker)
    <tr>
        <x-ui-td>{{ $broker->sigla }}</x-ui-td>
        <x-ui-td>{{ $broker->nombre }}</x-ui-td>
        <td>
            <button wire:click="edit({{ $broker->id }})" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></button> &nbsp;
        </td>
    <tr>
        @endforeach

</x-ui-crud-table>