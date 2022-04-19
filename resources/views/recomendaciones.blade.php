<x-ui-layout>

    <x-slot name="header">
        Panel de control
    </x-slot>

    @if($comprar)
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
                <x-ui-td align='right'>
                    @if(is_numeric($seguimiento->activo->cotizacion))
                    {{ number_format($seguimiento->activo->cotizacion, 2, ',', '.') }}
                    @endif
                </x-ui-td>
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
                <x-ui-td align='right'>
                    @if(is_numeric($seguimiento->activo->cotizacion))
                    {{ number_format($seguimiento->activo->cotizacion, 2, ',', '.') }}
                    @endif
                </x-ui-td>
                <x-ui-td align='right'>{{ number_format($seguimiento->puntaje * 100, 2, ',', '.') }}</x-ui-td>
                <x-ui-td>{{ $seguimiento->accion }}</x-ui-td>
            </x-ui-tr>
            @endforeach
        </x-ui-table>
    </x-ui-box>
    @endif

</x-ui-layout>