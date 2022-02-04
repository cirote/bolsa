<x-ui-crud-table>
    
    <x-slot name="header">
        <tr>
            <x-ui-th sort="asc" style="width: 90px">Sigla</x-ui-th>
            <x-ui-th sort="desc" style="width: 90px">Nombre</x-ui-th>
        <tr>
    </x-slot>

    @foreach($brokers as $broker)
    <tr>
        <x-ui-td>{{ $broker->sigla }}</x-ui-td>
        <x-ui-td>{{ $broker->nombre }}</x-ui-td>
    <tr>
    @endforeach

</x-ui-crud-table>
