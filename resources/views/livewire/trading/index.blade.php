<x-ui-box>

    <x-slot name="header">
        Inversiones
    </x-slot>

    <x-ui-row> 
        <x-ui-column number='2'>
            <x-ui-tarjeta footer="Activos con stock">
                {{ number_format($activos->count(), 0, ',', '.') }}
            </x-ui-tarjeta>
        </x-ui-column>

        <x-ui-column number='2'>
            <x-ui-tarjeta footer="Inversión">
                $ {{ number_format($activos->sum('inversion'), 0, ',', '.') }}
            </x-ui-tarjeta>
        </x-ui-column>

        <x-ui-column number='2'>
            <x-ui-tarjeta footer="Resultados no realizados">
                $ {{ number_format($activos->sum('resultadosNoRealizados'), 0, ',', '.') }}
            </x-ui-tarjeta>
        </x-ui-column>

        <x-ui-column number='2'>
            <x-ui-tarjeta footer="Resultados por compraventa">
                $ {{ number_format($activos->sum('resultadosCompraVenta'), 0, ',', '.') }}
            </x-ui-tarjeta>
        </x-ui-column>

        <x-ui-column number='2'>
            <x-ui-tarjeta footer="Dividendos cobrados">
                $ {{ number_format($activos->sum('dividendosCobrados'), 0, ',', '.') }}
            </x-ui-tarjeta>
        </x-ui-column>

        <x-ui-column number='2'>
            <x-ui-tarjeta footer="Resultados totales">
                $ {{ number_format($activos->sum('resultadosTotales'), 0, ',', '.') }}
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
                            <x-ui-th sorteable='simbolo'>Ticker</x-ui-th>
                            <x-ui-th sorteable='denominacion'>Activo</x-ui-th>
                            <x-ui-th>Stock</x-ui-th>
                            <x-ui-th>PPC</x-ui-th>
                            <x-ui-th>Precio</x-ui-th>
                            <x-ui-th>Máximo</x-ui-th>
                            <x-ui-th>Var%</x-ui-th>
                            <x-ui-th sorteable='inversion'>Inversión</x-ui-th>
                            <x-ui-th sorteable='resultadosNoRealizados'>R. no Realizados</x-ui-th>
                            <x-ui-th>Por %.</x-ui-th>
                            <x-ui-th sorteable='resultadosCompraVenta'>Compra/Venta</x-ui-th>
                            <x-ui-th sorteable='dividendosCobrados'>Dividendos</x-ui-th>
                            <x-ui-th sorteable='resultadosTotales'>R. Totales</x-ui-th>
                            <x-ui-th>Estado</x-ui-th>
                            <x-ui-th>c/Grilla</x-ui-th>
                            <x-ui-th>c/Seg</x-ui-th>
                            <x-ui-th></x-ui-th>
                        </x-ui-tr>
                    </x-slot>

                    @foreach($activos as $activo)
                        <x-ui-tr>
                            <x-ui-td>{{ $activo->simbolo ?? $activo->ticker->ticker }}</x-ui-td>
                            <x-ui-td>{{ $activo->denominacion }}</x-ui-td>
                            <x-ui-td number="{{ $activo->stock }}" />
                            <x-ui-td number="{{ $activo->pPC }}" />
                            <x-ui-td number="{{ $activo->cotizacion }}" />
                            <x-ui-td number="{{ $activo->maximo }}" />
                            <x-ui-td number="{{ -100 * ($activo->maximo - $activo->cotizacion) / ($activo->maximo ? $activo->maximo : 1) }}"/>
                            <x-ui-td number="{{ $activo->inversion }}" />
                            <x-ui-td number="{{ $activo->resultadosNoRealizados }}" />
                            <x-ui-td number="{{ $activo->inversion ? $activo->resultadosNoRealizados / $activo->inversion * 100 : 0 }}"/>
                            <x-ui-td number="{{ $activo->resultadosCompraVenta }}" />
                            <x-ui-td number="{{ $activo->dividendosCobrados }}" />
                            <x-ui-td number="{{ $activo->resultadosTotales }}" />
                            <x-ui-td>{{ $activo->estado }}</x-ui-td>
                            <x-ui-td>{{ $activo->grillas->count() ? 'Si' : 'No' }}</x-ui-td>
                            <x-ui-td>{{ $activo->seguimientos->count() ? 'Si' : 'No' }}</x-ui-td>
                            <x-ui-td>
                                <x-botonTrading wid="{{ $activo->id }}" />
                            </x-ui-td>
                        </x-ui-tr>
                    @endforeach

                </x-ui-table>

            </x-ui-box>
        </x-ui-column>
    </x-ui-row>

</x-ui-box>
