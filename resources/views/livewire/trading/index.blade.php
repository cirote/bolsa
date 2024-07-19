<x-ui-box>

    <x-slot name="header">
        Inversiones
    </x-slot>

    <x-ui-row> 
        <x-ui-column number='2'>
            <x-ui-tarjeta>
                <x-slot name="header">
                    Cantidad de activos con stock
                </x-slot>
                {{ number_format($activos->count(), 0, ',', '.') }}
            </x-ui-tarjeta>
        </x-ui-column>

        <x-ui-column number='2'>
            <x-ui-tarjeta>
                <x-slot name="header">
                    Inversión
                </x-slot>
                $ {{ number_format($activos->sum('inversion'), 2, ',', '.') }}
            </x-ui-tarjeta>
        </x-ui-column>

        <x-ui-column number='2'>
            <x-ui-tarjeta>
                <x-slot name="header">
                    Resultados no realizados
                </x-slot>
                $ {{ number_format($activos->sum('resultadosNoRealizados'), 2, ',', '.') }}
            </x-ui-tarjeta>
        </x-ui-column>

        <x-ui-column number='2'>
            <x-ui-tarjeta>
                <x-slot name="header">
                    Resultados por compraventa
                </x-slot>
                $ {{ number_format($activos->sum('resultadosCompraVenta'), 2, ',', '.') }}
            </x-ui-tarjeta>
        </x-ui-column>

        <x-ui-column number='2'>
            <x-ui-tarjeta>
                <x-slot name="header">
                    Dividendos cobrados
                </x-slot>
                $ {{ number_format($activos->sum('dividendosCobrados'), 2, ',', '.') }}
            </x-ui-tarjeta>
        </x-ui-column>

        <x-ui-column number='2'>
            <x-ui-tarjeta>
                <x-slot name="header">
                    Resultados totales
                </x-slot>
                $ {{ number_format($activos->sum('resultadosTotales'), 2, ',', '.') }}
            </x-ui-tarjeta>
        </x-ui-column>
    </x-ui-row>

    <x-ui-row>
        <x-ui-column number="12">
            <x-ui-box>
                <x-slot name="header">
                    Activos
                </x-slot>

                <x-ui-table>

                    <x-slot name="header">
                        <x-ui-tr>
                            <x-ui-th>Ticker</x-ui-th>
                            <x-ui-th>Activo</x-ui-th>
                            <x-ui-th>Stock</x-ui-th>
                            <x-ui-th>PPC</x-ui-th>
                            <x-ui-th>Cotización</x-ui-th>
                            <x-ui-th>Inversión</x-ui-th>
                            <x-ui-th>R. no Realizados</x-ui-th>
                            <x-ui-th>Por %.</x-ui-th>
                            <x-ui-th>Compra/Venta</x-ui-th>
                            <x-ui-th>Dividendos</x-ui-th>
                            <x-ui-th>R. Totales</x-ui-th>
                            <x-ui-th></x-ui-th>
                        </x-ui-tr>
                    </x-slot>

                    @foreach($activos as $activo)
                        <x-ui-tr>
                            <x-ui-td>{{ $activo->simbolo }}</x-ui-td>
                            <x-ui-td>{{ $activo->denominacion }}</x-ui-td>
                            <x-ui-td number="{{ $activo->stock }}" decimals="0"/>
                            <x-ui-td number="{{ $activo->pPC }}"/>
                            <x-ui-td number="{{ $activo->cotizacion }}"/>
                            <x-ui-td number="{{ $activo->inversion }}"/>
                            <x-ui-td number="{{ $activo->resultadosNoRealizados }}"/>
                            <x-ui-td number="{{ $activo->inversion ? $activo->resultadosNoRealizados / $activo->inversion * 100 : 0 }}"/>
                            <x-ui-td number="{{ $activo->resultadosCompraVenta }}"/>
                            <x-ui-td number="{{ $activo->dividendosCobrados }}"/>
                            <x-ui-td number="{{ $activo->resultadosTotales }}"/>
                            <x-ui-td>
                                <x-ui-button type="info" wire:click="trading({{ $activo->id }})">
                                    <i class="fa-solid fa-cart-shopping"></i>
                                    Trading
                                </x-ui-button>
                            </x-ui-td>
                        </x-ui-tr>
                    @endforeach

                </x-ui-table>

            </x-ui-box>
        </x-ui-column>
    </x-ui-row>

</x-ui-box>
