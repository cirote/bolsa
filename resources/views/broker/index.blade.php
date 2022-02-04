<x-ui-layout>

    <x-slot name="header">
        Tabla de brokers
    </x-slot>

    <x-ui-crud-table>
        Hola
        <x-slot name="header">
            <tr>
                <x-ui-th sort="asc" style="width: 90px">Rendering engine</x-ui-th>
                <x-ui-th sort="desc" style="width: 90px">Browser</x-ui-th>
                <x-ui-th rowspan="2" style="width: 90px">Platform(s)</x-ui-th>
                <x-ui-th class="sorting_asc" style="width: 90px">Engine version</x-ui-th>
                <x-ui-th style="width: 90px">CSS grade</x-ui-th>
            </tr>
        </x-slot>

    </x-ui-crud-table>

</x-ui-layout>