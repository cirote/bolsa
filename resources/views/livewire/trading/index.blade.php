<x-ui-box>

    <x-slot name="header">
        Operaciones de Trading de {{ $activo->denominacion }}
    </x-slot>

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
                                <x-ui-td number="{{ $compraventa->cantidad }}" decimals="0"/>
                                <x-ui-td number="{{ $compraventa->compra->precio }}"/>
                                <x-ui-td number="{{ $compraventa->costo }}"/>
                                <x-ui-td>{{ $compraventa->venta->fecha->format('d/m/Y') }}</x-ui-td>
                                <x-ui-td number="{{ $compraventa->venta->precio }}"/>
                                <x-ui-td number="{{ $compraventa->ingreso }}"/>
                                <x-ui-td number="{{ $compraventa->resultado }}"/>
                                <x-ui-td number="{{ $compraventa->dias }}" decimals="0"/>
                                <x-ui-td number="{{ $compraventa->tasa * 100 }}"/>
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
                                <x-ui-tr>
                                    <x-ui-td>{{ $compra->fecha->format('d/m/Y') }}</x-ui-td>
                                    <x-ui-td number="{{ $compra->cantidad }}" decimals="0"/>
                                    <x-ui-td number="{{ abs($compra->monto / $compra->cantidad) }}"/>
                                    <x-ui-td number="{{ $compra->monto }}"/>
                                    <x-ui-td number="{{ $compra->saldo }}" decimals="0"/>
                                    <x-ui-td number="{{ $compra->inversion }}"/>
                                    <x-ui-td>
                                        <x-ui-button wire:click="imputar_venta({{ $compra->id }})">
                                            <i class="fa-solid fa-bullseye"></i>
                                        </x-ui-button>
                                    </x-ui-td>
        
                                </x-ui-tr>
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
                                <x-ui-tr>
                                    <x-ui-td>{{ $venta->fecha->format('d/m/Y') }}</x-ui-td>
                                    <x-ui-td number="{{ $venta->cantidad }}" decimals="0"/>
                                    <x-ui-td number="{{ $venta->monto / $venta->cantidad }}"/>
                                    <x-ui-td number="{{ $venta->monto }}"/>
                                    <x-ui-td number="{{ $venta->saldo }}" decimals="0"/>
                                    <x-ui-td number="{{ $venta->inversion }}"/>
                                    <x-ui-td>
                                        <x-ui-button wire:click="imputar_compra({{ $compra->id }})">
                                            <i class="fa-solid fa-bullseye"></i>
                                        </x-ui-button>
                                    </x-ui-td>
            
                                </x-ui-tr>
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
    
                    @foreach($activo->dividendos as $dividendo)
                        <x-ui-tr>
                            <x-ui-td>{{ $dividendo->fecha->format('d/m/Y') }}</x-ui-td>
                            <x-ui-td number="{{ $dividendo->monto }}"/>
                        </x-ui-tr>
                    @endforeach

                    <x-slot name="footer">
                        <x-ui-tr>
                            <x-ui-td>Total</x-ui-td>
                            <x-ui-td number="{{ $activo->dividendos->sum('monto') }}"/>
                        </x-ui-tr>
                    </x-slot>

                </x-ui-table>

            </x-ui-box>
        </x-ui-column>
    </x-ui-row>
</x-ui-box>
