<div>
    <x-slot name="header">
        Panel recomendaciones
    </x-slot>

    @if($activos->count())
        <x-ui-box>
            <x-slot name="header">
                Recomendaciones del panel de inversiones
            </x-slot>

            <x-ui-table>
                <x-slot name="header">
                    <x-ui-tr>
                        <x-ui-th>Ticker</x-ui-th>
                        <x-ui-th>Activo</x-ui-th>
                        <x-ui-th>Stock</x-ui-th>
                        <x-ui-th>PPC</x-ui-th>
                        <x-ui-th>Cotización</x-ui-th>
                        <x-ui-th>Máximo</x-ui-th>
                        <x-ui-th>Var%</x-ui-th>
                        <x-ui-th>Inversión</x-ui-th>
                        <x-ui-th>R. no Realizados</x-ui-th>
                        <x-ui-th>Por %.</x-ui-th>
                        <x-ui-th>Compra/Venta</x-ui-th>
                        <x-ui-th>Dividendos</x-ui-th>
                        <x-ui-th>R. Totales</x-ui-th>
                        <x-ui-th>Estado</x-ui-th>
                        <x-ui-th>Acciones</x-ui-th>
                    </x-ui-tr>
                </x-slot>

                @foreach($activos as $activo)
                    <x-ui-tr>
                        <x-ui-td>{{ $activo->simbolo }}</x-ui-td>
                        <x-ui-td>{{ $activo->denominacion }}</x-ui-td>
                        <x-ui-td number="{{ $activo->stock }}" />
                        <x-ui-td number="{{ $activo->pPC }}" d=2 />
                        <x-ui-td number="{{ $activo->cotizacion }}" d=2 />
                        <x-ui-td number="{{ $activo->maximo }}" d=2 />
                        <x-ui-td number="{{ -100 * ($activo->maximo - $activo->cotizacion) / ($activo->maximo ? $activo->maximo : 1) }}" d=2 />
                        <x-ui-td number="{{ $activo->inversion }}" d=2 />
                        <x-ui-td number="{{ $activo->resultadosNoRealizados }}" d=2 />
                        <x-ui-td number="{{ $activo->inversion ? $activo->resultadosNoRealizados / $activo->inversion * 100 : 0 }}" d=2 />
                        <x-ui-td number="{{ $activo->resultadosCompraVenta }}" d=2 />
                        <x-ui-td number="{{ $activo->dividendosCobrados }}" d=2 />
                        <x-ui-td number="{{ $activo->resultadosTotales }}" d=2 />
                        <x-ui-td>{{ $activo->estado }}</x-ui-td>
                        <x-ui-td>
                            <x-botonTrading wid="{{ $activo->id }}" />
                        </x-ui-td>
                    </x-ui-tr>
                @endforeach
            </x-ui-table>
        </x-ui-box>
    @endif

    @if($seguimientos->count())
        <x-ui-box>
            <x-slot name="header">
                Recomendaciones del panel de seguimientos
            </x-slot>

            <x-ui-table>
                <x-slot name="header">
                    <x-ui-tr>
                        <x-ui-th>Simbolo</x-ui-th>
                        <x-ui-th>Activo</x-ui-th>
                        <x-ui-th>Modelo</x-ui-th>
                        <x-ui-th>Cotizacion</x-ui-th>
                        <x-ui-th>Base actual</x-ui-th>
                        <x-ui-th>Techo actual</x-ui-th>
                        <x-ui-th>Puntaje</x-ui-th>
                        <x-ui-th>Estado</x-ui-th>
                        <x-ui-th>Acciones</x-ui-th>
                    </x-ui-tr>
                </x-slot>

                @foreach($seguimientos as $seguimiento)
                    <x-ui-tr>
                        <x-ui-td>{{ $seguimiento->activo->simbolo }}</x-ui-td>
                        <x-ui-td>{{ $seguimiento->activo->denominacion }}</x-ui-td>
                        <x-ui-td>{{ $seguimiento->tipo }}</x-ui-td>
                        <x-ui-td number="{{ $seguimiento->activo->cotizacion }}" d=2 />
                        <x-ui-td number="{{ $seguimiento->base }}" d=2 />
                        <x-ui-td number="{{ $seguimiento->techoCalculado }}" d=2 />
                        <x-ui-td number="{{ $seguimiento->puntaje * 100 }}" />
                        <x-ui-td>{{ $seguimiento->estado }}</x-ui-td>
                        <x-ui-td>
                            <x-botonTrading wid="{{ $seguimiento->activo->id }}" />
                        </x-ui-td>
                    </x-ui-tr>
                @endforeach
            </x-ui-table>
        </x-ui-box>
    @endif

    @if($grillas->count())
        <x-ui-box>
            <x-slot name="header">
                Recomendaciones del panel de grillas
            </x-slot>

            <x-ui-table>
                <x-slot name="header">
                    <x-ui-tr>
                        <x-ui-th>Simbolo</x-ui-th>
                        <x-ui-th>Activo</x-ui-th>
                        <x-ui-th>Desde</x-ui-th>
                        <x-ui-th>Cotización</x-ui-th>
                        <x-ui-th>Precio de activación</x-ui-th>
                        <x-ui-th>Estado</x-ui-th>
                        <x-ui-th>Acciones</x-ui-th>
                    </x-ui-tr>
                </x-slot>

                @foreach($grillas as $grilla)
                    <x-ui-tr>
                        <x-ui-td>{{ $grilla->activo->simbolo }}</x-ui-td>
                        <x-ui-td>{{ $grilla->activo->denominacion }}</x-ui-td>
                        <x-ui-td>{{ $grilla->fecha_inicial->format('d/m/Y') }}</x-ui-td>
                        <x-ui-td number="{{ $grilla->cotizacionDelActivo }}" d=2 />
                        @if($grilla->precio_activacion !== null)
                            <x-ui-td number="{{ $grilla->precio_activacion }}" d=2 />
                        @else
                            <x-ui-td />
                        @endif
                        <x-ui-td>{{ $grilla->estado }}</x-ui-td>
                        <x-ui-td>
                            <x-botonTrading wid="{{ $grilla->activo->id }}" />
                            <x-botonBanda wid="{{ $grilla->id }}" />
                            @if($grilla->precio_activacion !== null)
                                <x-ui-button wire:click="activar({{ $grilla->id }})">
                                    <i class="fa fa-play"></i>
                                    Activar
                                </x-ui-button>
                            @endif
                        </x-ui-td-actions>
                    </x-ui-tr>
                @endforeach
            </x-ui-table>
        </x-ui-box>
    @endif
</div>