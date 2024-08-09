<x-ui-box>
    <x-slot name="header">
        Cuentas en dólares | Saldo total: $ {{ number_format($enDolares->sum('saldo'), 2, ',', '.') }}
    </x-slot>

    <x-ui-row>
        @foreach ($enDolares as $cuenta)
            <x-ui-column number='2'>
                <x-ui-tarjeta title="{{ $cuenta->nombre }}" 
                              footer="Movimientos" 
                              href="{{ route('movimientos.show', $cuenta) }}"
                              icon="fa fa-arrow-circle-right">
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
                <x-ui-tarjeta title="{{ $cuenta->nombre }}" 
                              footer="Movimientos" 
                              href="{{ route('movimientos.show', $cuenta) }}"
                              icon="fa fa-arrow-circle-right">
                    &euro; {{ number_format($cuenta->saldo, 2, ',', '.') }}
                </x-ui-tarjeta> 
            </x-ui-column>    
        @endforeach
    </x-ui-row>
</x-ui-box>

<x-ui-box>
    <x-slot name="header">
        Cuentas en pesos argentinos | Saldo total: $a {{ number_format($enArgentinos->sum('saldo'), 2, ',', '.') }}
    </x-slot>

    <x-ui-row>
            @foreach ($enArgentinos as $cuenta)
            <x-ui-column number='2'>
                <x-ui-tarjeta title="{{ $cuenta->nombre }}" 
                              footer="Movimientos" 
                              href="{{ route('movimientos.show', $cuenta) }}"
                              icon="fa fa-arrow-circle-right">
                    $a {{ number_format($cuenta->saldo, 2, ',', '.') }}
                </x-ui-tarjeta> 
            </x-ui-column>    
        @endforeach
    </x-ui-row>
</x-ui-box>
