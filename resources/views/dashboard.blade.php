<x-ui-layout>

    <x-slot name="header">
        Panel de control
    </x-slot>

    <x-ui-box>

        <x-slot name="header">
            Aportes
        </x-slot>

        <x-ui-row>
            <x-ui-column number='3'>
                <x-ui-tarjeta>
                    <x-slot name="header">
                        Aportes en dólares
                    </x-slot>
            
                    {{ number_format($aportes = \App\Actions\Calcular\CalcularAportesEnDolaresAction::do(), 2, ',', '.') }}
                </x-ui-tarjeta> 
            </x-ui-column>    

            <x-ui-column number='3'>
                <x-ui-tarjeta>
                    <x-slot name="header">
                        Retiros en dólares
                    </x-slot>
            
                    {{ number_format($retiros = \App\Actions\Calcular\CalcularRetirosEnDolaresAction::do(), 2, ',', '.') }}
                </x-ui-tarjeta>
            </x-ui-column>    

            <x-ui-column number='3'>
                <x-ui-tarjeta>
                    <x-slot name="header">
                        Aportes Netos
                    </x-slot>
            
                    {{ number_format($aportes - $retiros, 2, ',', '.') }}
                </x-ui-tarjeta>
            </x-ui-column>    
        </x-ui-row>

    </x-ui-box>

    <x-ui-box>
        
        <x-slot name="header">
            Disponibilidades
        </x-slot>

        <x-ui-row>
            <x-ui-column number='3'>
                <x-ui-tarjeta>
                    <x-slot name="header">
                        Saldo de caja en pesos
                    </x-slot>
            
                    {{ number_format($aportes = \App\Actions\Calcular\CalcularSaldoDeCajaEnPesosAction::do(), 2, ',', '.') }}
                </x-ui-tarjeta>
            </x-ui-column>    

            <x-ui-column number='3'>
                <x-ui-tarjeta>
                    <x-slot name="header">
                        Saldo de caja en dólares
                    </x-slot>
            
                    {{ number_format($aportes = \App\Actions\Calcular\CalcularSaldoDeCajaEnDolaresAction::do(), 2, ',', '.') }}
                </x-ui-tarjeta>
            </x-ui-column>    
        </x-ui-row>

    </x-ui-box>

    <x-ui-box>
        
        <x-slot name="header">
            Inversión
        </x-slot>

        <x-ui-row>
            <x-ui-column number='3'>
                <x-ui-tarjeta>
                    <x-slot name="header">
                        Monto invertido en dólares
                    </x-slot>
            
                    {{ number_format($a = \App\Actions\Calcular\CalcularMontoInvertidoEnDolaresAction::do(), 2, ',', '.') }}
                </x-ui-tarjeta>
            </x-ui-column>    

            <x-ui-column number='3'>
                <x-ui-tarjeta>
                    <x-slot name="header">
                        Resultados No Realizados
                    </x-slot>
            
                    {{ number_format($b = \App\Actions\Calcular\CalcularResultadoNoRealizadoEnDolaresAction::do(), 2, ',', '.') }}
                </x-ui-tarjeta>
            </x-ui-column>    

            <x-ui-column number='3'>
                <x-ui-tarjeta>
                    <x-slot name="header">
                        Valor actual de la inversión
                    </x-slot>
            
                    {{ number_format($a + $b, 2, ',', '.') }}
                </x-ui-tarjeta>
            </x-ui-column>    

            <x-ui-column number='3'>
                <x-ui-tarjeta>
                    <x-slot name="header">
                        T.I.R. Histórica
                    </x-slot>
            
                    {{ number_format(\App\Actions\Calcular\CalcularTIRActualAction::do() * 100, 2, ',', '.') }} %
                </x-ui-tarjeta>
            </x-ui-column>    
        </x-ui-row>

    </x-ui-box>

    @livewire('movimientos.panel')

</x-ui-layout>