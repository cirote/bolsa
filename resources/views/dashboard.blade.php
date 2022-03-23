<x-ui-layout>

    <x-slot name="header">
        Panel de control
    </x-slot>

    <x-ui-box>

        <x-slot name="header">
            Aportes
        </x-slot>

        <x-ui-tarjeta>
            <x-slot name="header">
                Aportes en dólares
            </x-slot>
    
            {{ number_format($aportes = \App\Actions\Calcular\CalcularAportesEnDolaresAction::do(), 2, '.', ',') }}
        </x-ui-tarjeta>

        <x-ui-tarjeta>
            <x-slot name="header">
                Retiros en dólares
            </x-slot>
    
            {{ number_format($retiros = \App\Actions\Calcular\CalcularRetirosEnDolaresAction::do(), 2, '.', ',') }}
        </x-ui-tarjeta>

        <x-ui-tarjeta>
            <x-slot name="header">
                Aportes Netos
            </x-slot>
    
            {{ number_format($aportes - $retiros, 2, '.', ',') }}
        </x-ui-tarjeta>

        <x-ui-tarjeta>
            <x-slot name="header">
                T.I.R.
            </x-slot>
    
            {{ number_format(\App\Actions\Calcular\CalcularTIRAction::do(), 2, '.', ',') }}
        </x-ui-tarjeta>

    </x-ui-box>

    <x-ui-box>
        
        <x-slot name="header">
            Disponibilidades
        </x-slot>

        <x-ui-tarjeta>
            <x-slot name="header">
                Saldo de caja en pesos
            </x-slot>
    
            {{ number_format($aportes = \App\Actions\Calcular\CalcularSaldoDeCajaEnPesosAction::do(), 2, '.', ',') }}
        </x-ui-tarjeta>

        <x-ui-tarjeta>
            <x-slot name="header">
                Saldo de caja en dólares
            </x-slot>
    
            {{ number_format($aportes = \App\Actions\Calcular\CalcularSaldoDeCajaEnDolaresAction::do(), 2, '.', ',') }}
        </x-ui-tarjeta>

    </x-ui-box>

    <x-ui-box>
        
        <x-slot name="header">
            Inversión
        </x-slot>

        <x-ui-tarjeta>
            <x-slot name="header">
                Monto invertido en dólares
            </x-slot>
    
            {{ number_format(\App\Actions\Calcular\CalcularMontoInvertidoEnDolaresAction::do(), 2, '.', ',') }}
        </x-ui-tarjeta>

        <x-ui-tarjeta>
            <x-slot name="header">
                Resultados No Realizados
            </x-slot>
    
            {{ number_format(\App\Actions\Calcular\CalcularResultadoNoRealizadoEnDolaresAction::do(), 2, '.', ',') }}
        </x-ui-tarjeta>

    </x-ui-box>

    @livewire('movimientos.panel')

    {{-- @if($comprar)
    <x-ui-box>
        <x-slot name="header">
            Activos a Comprar
        </x-slot>

        <x-ui-table>
            <x-slot name="header">
                <x-ui-th>Activo</x-ui-th>
                <x-ui-th>Cotizacion</x-ui-th>
                <x-ui-th>Puntaje</x-ui-th>
                <x-ui-th>Accion</x-ui-th>
            </x-slot>

            @foreach($comprar as $seguimiento)
            <x-ui-tr>
                <x-ui-td>
                    {{ $seguimiento->activo->denominacion }}
                </x-ui-td>
                <x-ui-td align='right'>{{ number_format($seguimiento->activo->cotizacion, 2, ',', '.') }}</x-ui-td>
                <x-ui-td align='right'>{{ number_format($seguimiento->puntaje * 100, 2, ',', '.') }}</x-ui-td>
                <x-ui-td>{{ $seguimiento->accion }}</x-ui-td>
            </x-ui-tr>
            @endforeach
        </x-ui-table>
    </x-ui-box>
    @endif

    @if($vender)
    <x-ui-box>
        <x-slot name="header">
            Activos a Vender
        </x-slot>

        <x-ui-table>
            <x-slot name="header">
                <x-ui-th>Activo</x-ui-th>
                <x-ui-th>Cotizacion</x-ui-th>
                <x-ui-th>Puntaje</x-ui-th>
                <x-ui-th>Accion</x-ui-th>
            </x-slot>

            @foreach($vender as $seguimiento)
            <x-ui-tr>
                <x-ui-td>
                    {{ $seguimiento->activo->denominacion }}
                </x-ui-td>
                <x-ui-td align='right'>{{ number_format($seguimiento->activo->cotizacion, 2, ',', '.') }}</x-ui-td>
                <x-ui-td align='right'>{{ number_format($seguimiento->puntaje * 100, 2, ',', '.') }}</x-ui-td>
                <x-ui-td>{{ $seguimiento->accion }}</x-ui-td>
            </x-ui-tr>
            @endforeach
        </x-ui-table>
    </x-ui-box>
    @endif --}}

</x-ui-layout>