<x-ui-crud-table :isOpen="$isOpen" :isEditable="$isEditable">

    <x-slot name="header">
        <tr>
            <x-ui-th sort="asc">Fecha</x-ui-th>
            <x-ui-th>Aportes</x-ui-th>
            <x-ui-th>Retiros</x-ui-th>
            <x-ui-th>Pesos</x-ui-th>
            <x-ui-th>Dolares</x-ui-th>
            <x-ui-th>Inversion</x-ui-th>
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

    @foreach($estados as $estado)
    <tr>
        <x-ui-td>
            {{ $estado->fecha->format('d/m/Y') }}
        </x-ui-td>
        <x-ui-td align="right">
            {{ number_format($estado->aportes, 2, ',', '.') }}
        </x-ui-td>
        <x-ui-td align="right">
            {{ number_format($estado->retiros, 2, ',', '.') }}
        </x-ui-td>
        <x-ui-td align="right">
            {{ number_format($estado->cuentas_saldo_en_pesos, 2, ',', '.') }}
        </x-ui-td>
        <x-ui-td align="right">
            {{ number_format($estado->cuentas_saldo_en_dolares, 2, ',', '.') }}
        </x-ui-td>
        <x-ui-td align="right">
            {{ number_format($estado->inversion, 2, ',', '.') }}
        </x-ui-td>
        <x-ui-td-actions :id="$estado->id">
            {{-- <x-ui-button wire:click="ver_cuenta({{ $estado->id }})">
                Ver
            </x-ui-button> --}}
        </x-ui-td-actions>
    <tr>
        @endforeach

</x-ui-crud-table>