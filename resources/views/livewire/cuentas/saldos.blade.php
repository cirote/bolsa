<x-ui-box>
    <x-slot name="header">
        Cuentas en dólares | Saldo total: $ {{ number_format($enDolares->sum('saldo'), 2, ',', '.') }}
    </x-slot>

    <x-ui-row>
        @foreach ($enDolares as $cuenta)
            <x-ui-column number='2'>
                <x-ui-tarjeta>
                    <x-slot name="header">
                        {{ $cuenta->nombre }}
                    </x-slot>

                    <x-slot name="footer">
                        <a href="{{ route('movimientos.show', $cuenta) }}" class="small-box-footer bg-default">
                            <span class="text-muted">Movimientos <i class="fa fa-arrow-circle-right"></i></span>
                        </a>
                    </x-slot>

                    $ {{ number_format($cuenta->saldo, 2, ',', '.') }}
                </x-ui-tarjeta> 
            </x-ui-column>    
        @endforeach
    </x-ui-row>
</x-ui-box>

<x-ui-box>
    <x-slot name="header">
        Cuentas en euros | Saldo total: &euro; {{ number_format($enEuros->sum('saldo'), 2, ',', '.') }}
    </x-slot>

    <x-ui-row>
            @foreach ($enEuros as $cuenta)
            <x-ui-column number='2'>
                <x-ui-tarjeta>
                    <x-slot name="header">
                        {{ $cuenta->nombre }}
                    </x-slot>

                    <x-slot name="footer">
                        <a href="{{ route('movimientos.show', $cuenta) }}" class="small-box-footer bg-default">
                            <span class="text-muted">Movimientos <i class="fa fa-arrow-circle-right"></i></span>
                        </a>
                    </x-slot>

                    &euro; {{ number_format($cuenta->saldo, 2, ',', '.') }}
                </x-ui-tarjeta> 
            </x-ui-column>    
        @endforeach
    </x-ui-row>
</x-ui-box>

<x-ui-box>
    <x-slot name="header">
        Cuentas en pesos argentinos | Saldo total: $ {{ number_format($enArgentinos->sum('saldo'), 2, ',', '.') }}
    </x-slot>

    <x-ui-row>
            @foreach ($enArgentinos as $cuenta)
            <x-ui-column number='2'>
                <x-ui-tarjeta>
                    <x-slot name="header">
                        {{ $cuenta->nombre }}
                    </x-slot>

                    <x-slot name="footer">
                        <a href="{{ route('movimientos.show', $cuenta) }}" class="small-box-footer bg-default">
                            <span class="text-muted">Movimientos <i class="fa fa-arrow-circle-right"></i></span>
                        </a>
                    </x-slot>
           
                    {{ number_format($cuenta->saldo, 2, ',', '.') }}
                </x-ui-tarjeta> 
            </x-ui-column>    
        @endforeach
    </x-ui-row>
</x-ui-box>
