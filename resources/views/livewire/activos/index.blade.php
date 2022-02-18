<x-ui-crud-table :isOpen="$isOpen" :isEditable="$isEditable" >

    <x-slot name="header">
        <tr>
            <x-ui-th sort="asc">Simbolo</x-ui-th>
            <x-ui-th sort="desc">Denominacion</x-ui-th>
            <x-ui-th sort="desc">Cotizacion</x-ui-th>
            <x-ui-th sort="desc">Cabmio</x-ui-th>
            <x-ui-th >Acciones</x-ui-th>
        <tr>
    </x-slot>

    <x-slot name="form">
        <x-ui-input-text wire:model="model.simbolo" id="simbolo">Simbolo: </x-ui-input-text>
        <x-ui-input-text wire:model="model.denominacion">Denominacion: </x-ui-input-text>
    </x-slot>

    <x-slot name="buttons">
        <x-ui-button-cancel />
        @if($isEditable)
            <x-ui-button-store />
        @endif
    </x-slot>

    @foreach($activos as $activo)
    <tr>
        @php($cliente = \App\Apis\YahooFinanceApi::get())
        @php($cotizador = $cliente->getQuote('GGAL.BA'))
        @php($rate = $cliente->getExchangeRate('USD', 'ARS'))
        <x-ui-td>{{ $activo->simbolo }}</x-ui-td>
        <x-ui-td>{{ $activo->denominacion }}</x-ui-td>
        <x-ui-td>{{ $cotizador ? $cotizador->getRegularMarketPrice() : 'nada' }}</x-ui-td>
        <x-ui-td>{{ 10 }}</x-ui-td>
        <x-ui-td-actions :id="$activo->id"/>
    <tr>
    @endforeach

</x-ui-crud-table>