<x-ui-crud-table title="Lista de brokers" :model="$brokers" :mode="$mode">

    <x-slot name="header">
        <tr>
            <x-ui-th sorteable='sigla' sortby='{{ $sort_by }}' sortorder='{{ $sort_order }}'>Sigla</x-ui-th>
            <x-ui-th sorteable='nombre' sortby='{{ $sort_by }}' sortorder='{{ $sort_order }}'>Nombre</x-ui-th>
            <x-ui-th >Acciones</x-ui-th>
        <tr>
    </x-slot>

    <x-slot name="form">
        <x-ui-input-text item="model.sigla">Sigla: </x-ui-input-text>
        <x-ui-input-text item="model.nombre">Nombre del Broker: </x-ui-input-text>
    </x-slot>

    @foreach($brokers as $broker)
        <x-ui-tr>
            <x-ui-td>{{ $broker->sigla }}</x-ui-td>
            <x-ui-td>{{ $broker->nombre }}</x-ui-td>
            <x-ui-td-actions :id="$broker->id"/>
        </x-ui-tr>
    @endforeach

</x-ui-crud-table>