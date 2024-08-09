<x-ui-layout>

    <x-slot name="header">
        Panel de control
    </x-slot>

    <x-ui-box>

        <x-slot name="header">
            Aportes
        </x-slot>

        <x-ui-row>
            <x-ui-column number='2'>
                <x-ui-tarjeta footer="Aportes en dólares">
                    $ {{ number_format($aportes = \App\Actions\Calcular\CalcularAportesEnDolaresAction::do(), 2, ',', '.') }}
                </x-ui-tarjeta> 
            </x-ui-column>    

            <x-ui-column number='2'>
                <x-ui-tarjeta footer="Retiros en dólares">
                    $ {{ number_format($retiros = \App\Actions\Calcular\CalcularRetirosEnDolaresAction::do(), 2, ',', '.') }}
                </x-ui-tarjeta>
            </x-ui-column>    

            <x-ui-column number='2'>
                <x-ui-tarjeta footer="Aportes Netos">
                    $ {{ number_format($aportes - $retiros, 2, ',', '.') }}
                </x-ui-tarjeta>
            </x-ui-column>    
        </x-ui-row>

    </x-ui-box>

    <x-ui-box>
        
        <x-slot name="header">
            Disponibilidades
        </x-slot>

        <x-ui-row>
            <x-ui-column number='2'>
                <x-ui-tarjeta footer="Saldo de caja en pesos">
                    $a {{ number_format($aportes = \App\Actions\Calcular\CalcularSaldoDeCajaEnPesosAction::do(), 2, ',', '.') }}
                </x-ui-tarjeta>
            </x-ui-column>    

            <x-ui-column number='2'>
                <x-ui-tarjeta footer="Saldo de caja en dólares">
                    $ {{ number_format($aportes = \App\Actions\Calcular\CalcularSaldoDeCajaEnDolaresAction::do(), 2, ',', '.') }}
                </x-ui-tarjeta>
            </x-ui-column>    
        </x-ui-row>

    </x-ui-box>

    <x-ui-box>
        
        <x-slot name="header">
            Inversión
        </x-slot>

        <x-ui-row>
            <x-ui-column number='2'>
                <x-ui-tarjeta footer="Monto invertido en dólares">
                    $ {{ number_format($a = \App\Actions\Calcular\CalcularMontoInvertidoEnDolaresAction::do(), 2, ',', '.') }}
                </x-ui-tarjeta>
            </x-ui-column>    

            <x-ui-column number='2'>
                <x-ui-tarjeta footer="Resultados No Realizados">
                    $ {{ number_format($b = \App\Actions\Calcular\CalcularResultadoNoRealizadoEnDolaresAction::do(), 2, ',', '.') }}
                </x-ui-tarjeta>
            </x-ui-column>    

            <x-ui-column number='2'>
                <x-ui-tarjeta footer="Valor actual de la inversión">
                    $ {{ number_format($a + $b, 2, ',', '.') }}
                </x-ui-tarjeta>
            </x-ui-column>    

            <x-ui-column number='2'>
                <x-ui-tarjeta footer="T.I.R. Histórica" bgColor="success">
                    {{ number_format(\App\Actions\Calcular\CalcularTIRActualAction::do() * 100, 2, ',', '.') }} %
                </x-ui-tarjeta>
            </x-ui-column>    
        </x-ui-row>

    </x-ui-box>

    {{-- @livewire('movimientos.panel') --}}

</x-ui-layout>