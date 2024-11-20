<x-ui-box>

    <x-slot name="header">
        Operaciones de Trading de {{ $activo->denominacion }}
    </x-slot>

    <x-ui-row> 
        <x-ui-column number='2'>
            <x-ui-tarjeta footer="Stock">
                {{ $activo->stock }}
            </x-ui-tarjeta>
        </x-ui-column>

        <x-ui-column number='2'>
            <x-ui-tarjeta footer="Inversión">
                $ {{ number_format($activo->inversion, 2, ',', '.') }}
            </x-ui-tarjeta>
        </x-ui-column>

        <x-ui-column number='2'>
        <x-ui-tarjeta footer="Resultados no realizados" bgColor="warning">
                $ {{ number_format($activo->resultadosNoRealizados, 2, ',', '.') }}
            </x-ui-tarjeta>
        </x-ui-column>

        <x-ui-column number='2'>
            <x-ui-tarjeta footer="Resultado compraventa">
                $ {{ number_format($activo->resultadosCompraVenta, 2, ',', '.') }}
            </x-ui-tarjeta>
        </x-ui-column>

        <x-ui-column number='2'>
            <x-ui-tarjeta footer="Dividendos">
                $ {{ number_format($activo->dividendosCobrados, 2, ',', '.') }}
            </x-ui-tarjeta>
        </x-ui-column>

        <x-ui-column number='2'>
            <x-ui-tarjeta footer="Resultados realizados" bgColor="success">
                $ {{ number_format($activo->resultadosRealizados, 2, ',', '.') }}
            </x-ui-tarjeta>
        </x-ui-column>
    </x-ui-row>

    <x-ui-row>
        <x-ui-column number='10'>

            <x-ui-row>
                <x-ui-column number="12">
                    <x-ui-box>
                    <x-slot name="header">
                        Operaciones finalizadas
                    </x-slot>
    
                    <x-ui-table>
    
                        <x-slot name="header">
                            <x-ui-tr>
                                <x-ui-th>Compra</x-ui-th>
                                <x-ui-th>Cantidad</x-ui-th>
                                <x-ui-th>Precio</x-ui-th>
                                <x-ui-th>Monto</x-ui-th>
                                <x-ui-th>Venta</x-ui-th>
                                <x-ui-th>Precio</x-ui-th>
                                <x-ui-th>Monto</x-ui-th>
                                <x-ui-th>Resultado</x-ui-th>
                                <x-ui-th>Dias</x-ui-th>
                                <x-ui-th>TNA %</x-ui-th>
                            </x-ui-tr>
                        </x-slot>
        
                        @foreach($activo->compraventas as $compraventa)
                            <x-ui-tr>
                                <x-ui-td>{{ $compraventa->compra->fecha->format('d/m/Y') }}</x-ui-td>
                                <x-ui-td :number="$compraventa->cantidad" />
                                <x-ui-td :number="$compraventa->compra->precio" d="2" />
                                <x-ui-td :number="$compraventa->costo" />
                                <x-ui-td>{{ $compraventa->venta->fecha->format('d/m/Y') }}</x-ui-td>
                                <x-ui-td :number="$compraventa->venta->precio" d="2" />
                                <x-ui-td :number="$compraventa->ingreso" d="2" />
                                <x-ui-td :number="$compraventa->resultado" d="2" />
                                <x-ui-td :number="$compraventa->dias" />
                                <x-ui-td :number="$compraventa->tasa * 100" d="1" />
                            </x-ui-tr>
                        @endforeach
        
                    </x-ui-table>
    
                    </x-ui-box>
                </x-ui-column>
            </x-ui-row>

            <x-ui-row>
                <x-ui-column number='6'>
                    <x-ui-box>
                        <x-slot name="header">
                            Compras
                        </x-slot>
        
                        <x-ui-table>
        
                            <x-slot name="header">
                                <x-ui-tr>
                                    <x-ui-th>Fecha</x-ui-th>
                                    <x-ui-th>Cantidad</x-ui-th>
                                    <x-ui-th>Precio</x-ui-th>
                                    <x-ui-th>Monto</x-ui-th>
                                    <x-ui-th>Saldo</x-ui-th>
                                    <x-ui-th>Inversion</x-ui-th>
                                    <x-ui-th></x-ui-th>
                                </x-ui-tr>
                            </x-slot>
            
                            @foreach($activo->compras as $compra)
                                @if($compra->saldo)
                                    <x-ui-tr>
                                        <x-ui-td>{{ $compra->fecha->format('d/m/Y') }}</x-ui-td>
                                        <x-ui-td :number="$compra->cantidad" />
                                        <x-ui-td :number="abs($compra->monto / $compra->cantidad)" decimals="2" />
                                        <x-ui-td :number="$compra->monto" decimals="2" />
                                        <x-ui-td :number="$compra->saldo" />
                                        <x-ui-td :number="$compra->inversion" decimals="2" />
                                        <x-ui-td>
                                            @if($operacion_venta)
                                                <x-ui-button type='warning' wire:click="imputar_compra({{ $compra->id }})">
                                                    <i class="fa-solid fa-bullseye"></i>
                                                </x-ui-button>
                                            @else
                                                @if(! $operacion_compra)
                                                    <x-ui-button wire:click="imputar_compra({{ $compra->id }})">
                                                        <i class="fa-solid fa-arrow-right-to-bracket"></i>
                                                    </x-ui-button>
                                                @endif
                                            @endif
                                        </x-ui-td>
                                    </x-ui-tr>
                                @endif
                            @endforeach
            
                        </x-ui-table>
        
                    </x-ui-box>
        
                </x-ui-column>

                <x-ui-column number='6'>
                    <x-ui-box>
                        <x-slot name="header">
                            Ventas
                        </x-slot>
        
                        <x-ui-table>
        
                            <x-slot name="header">
                                <x-ui-tr>
                                    <x-ui-th>Fecha</x-ui-th>
                                    <x-ui-th>Cantidad</x-ui-th>
                                    <x-ui-th>Precio</x-ui-th>
                                    <x-ui-th>Monto</x-ui-th>
                                    <x-ui-th>Pendiente</x-ui-th>
                                    <x-ui-th>A imputar</x-ui-th>
                                    <x-ui-th></x-ui-th>
                                </x-ui-tr>
                            </x-slot>
            
                            @foreach($activo->ventas as $venta)
                                @if($venta->saldo)
                                    <x-ui-tr>
                                        <x-ui-td>{{ $venta->fecha->format('d/m/Y') }}</x-ui-td>
                                        <x-ui-td number="{{ $venta->cantidad }}" decimals="0"/>
                                        <x-ui-td number="{{ $venta->monto / $venta->cantidad }}"/>
                                        <x-ui-td number="{{ $venta->monto }}"/>
                                        <x-ui-td number="{{ $venta->saldo }}" decimals="0"/>
                                        <x-ui-td number="{{ $venta->inversion }}"/>
                                        <x-ui-td>
                                            @if($operacion_compra)
                                                <x-ui-button type='warning' wire:click="imputar_venta({{ $venta->id }})">
                                                    <i class="fa-solid fa-bullseye"></i>
                                                </x-ui-button>
                                            @else
                                                @if(! $operacion_venta)
                                                    <x-ui-button wire:click="imputar_venta({{ $venta->id }})">
                                                        <i class="fa-solid fa-arrow-right-to-bracket"></i>
                                                    </x-ui-button>
                                                @endif
                                            @endif
                                        </x-ui-td>
                                    </x-ui-tr>
                                @endif
                            @endforeach
            
                        </x-ui-table>
        
                    </x-ui-box>
        
                </x-ui-column>
            </x-ui-row>

        </x-ui-column>

        <x-ui-column number='2'>
            <x-ui-box>
                <x-slot name="header">
                    Dividendos
                </x-slot>

                <x-ui-table>

                    <x-slot name="header">
                        <x-ui-tr>
                            <x-ui-th>Fecha</x-ui-th>
                            <x-ui-th>Monto</x-ui-th>
                        </x-ui-tr>
                    </x-slot>
    
                    @foreach($activo->dividendos()->orderBy('fecha', 'DESC')->get() as $dividendo)
                        <x-ui-tr>
                            <x-ui-td>{{ $dividendo->fecha->format('d/m/Y') }}</x-ui-td>
                            <x-ui-td :number="$dividendo->monto" d=2 />
                        </x-ui-tr>
                    @endforeach

                    <x-slot name="footer">
                        <x-ui-tr>
                            <x-ui-td>Total</x-ui-td>
                            <x-ui-td :number="$activo->dividendos->sum('monto')" d=2 />
                        </x-ui-tr>
                    </x-slot>

                </x-ui-table>

            </x-ui-box>
        </x-ui-column>
    </x-ui-row>
</x-ui-box>
