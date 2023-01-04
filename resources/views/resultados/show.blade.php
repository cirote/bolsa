<x-ui-layout>

    <x-slot name="header">
        Resultado del periodo {{ $resultado->fecha_inicial->format('d-m-Y') }} al
        {{ $resultado->fecha_final->format('d-m-Y') }}
    </x-slot>

    <x-ui-box>

        <x-slot name="header">
            Aportes netos
        </x-slot>

        <p>Aportes al inicio del periodo ({{ $resultado->fecha_inicial->format('d-m-Y') }}): <strong>$ {{ number_format($resultado->estado_inicial->aportesNetos, 2, ',', '.') }}</strong></p>
        <p>Aportes al final del periodo ({{ $resultado->fecha_final->format('d-m-Y') }}): <strong>$ {{ number_format($resultado->estado_final->aportesNetos, 2, ',', '.') }}</strong></p>
        <p>Variacion de los aportes: <strong>$ {{ number_format($resultado->variacionAportes, 2, ',', '.') }}</strong></p>

    </x-ui-box>

    <x-ui-box>

        <x-slot name="header">
            Saldos de cuenta
        </x-slot>

        <p>Saldos al inicio ({{ $resultado->fecha_inicial->format('d-m-Y') }}): <strong>$ {{ number_format($resultado->estado_inicial->cuentasSaldoEnDolares, 2, ',', '.') }}</strong></p>
        @foreach($resultado->estado_inicial->cuentasEnDolares as $cuenta)
        <p> -> ({{ $cuenta->sigla }}) {{ $cuenta->nombre }}: <strong>$ {{ number_format($cuenta->saldo, 2, ',', '.') }}</strong></p>
        @endforeach

        <br>

        <p>Saldos al final ({{ $resultado->fecha_final->format('d-m-Y') }}): <strong>$ {{ number_format($resultado->estado_final->cuentasSaldoEnDolares, 2, ',', '.') }}</strong></p>
        @foreach($resultado->estado_final->cuentasEnDolares as $cuenta)
        <p> -> ({{ $cuenta->sigla }}) {{ $cuenta->nombre }}: <strong>$ {{ number_format($cuenta->saldo, 2, ',', '.') }}</strong></p>
        @endforeach

        <br>

        <p>Variacion del saldo de caja en dólares: <strong>$ {{ number_format($resultado->variacionSaldoEnDolares, 2, ',', '.') }}</strong></p>
    </x-ui-box>

    <x-ui-box>

        <x-slot name="header">
            Inversiones
        </x-slot>

        <p>Inversiones al inicio del periodo ({{ $resultado->fecha_inicial->format('d-m-Y') }}): <strong>$ {{ number_format($resultado->estado_inicial->inversion, 2, ',', '.') }}</strong></p>
        <p>Inversiones al final del periodo ({{ $resultado->fecha_final->format('d-m-Y') }}): <strong>$ {{ number_format($resultado->estado_final->inversion, 2, ',', '.') }}</strong></p>
        <p>Variacion de la inversión: <strong>$ {{ number_format($resultado->variacionInversion, 2, ',', '.') }}</strong></p>

    </x-ui-box>

    <x-ui-box>

        <x-slot name="header">
            Resultado
        </x-slot>

        <p>Resultado del periodo calculado por posiciones cerradas: <strong>$ {{ number_format($resultado->resultado, 2, ',', '.') }}</strong></p>
        <p>Resultado del periodo calculado por variación de saldos: <strong>$ {{ number_format($resultado->resultadoTeorico, 2, ',', '.') }}</strong></p>
        <p>Resultado a consolidar: <strong>$ {{ number_format($resultado->resultadoAConsolidar, 2, ',', '.') }}</strong></p>
    
    </x-ui-box>

    <x-ui-box>

        <x-slot name="header">
            Posiciones cerradas en el periodo
        </x-slot>

        <x-ui-table>

            <x-slot name="header">
                <tr>
                    <x-ui-th>Apertura</x-ui-th>
                    <x-ui-th>Cierre</x-ui-th>
                    <x-ui-th>Activo</x-ui-th>
                    <x-ui-th>Tipo</x-ui-th>
                    <x-ui-th>Estado</x-ui-th>
                    <x-ui-th>Cantidad</x-ui-th>
                    <x-ui-th>Resultado</x-ui-th>
                <tr>
            </x-slot>

            @foreach ($resultado->posiciones()->orderBy('fecha_cierre')->get() as $posicion)
                <tr>
                    <x-ui-td>{{ $posicion->fecha_apertura->format('d-m-Y') }}</x-ui-td>
                    <x-ui-td>
                        @if ($posicion->fecha_cierre)
                            {{ $posicion->fecha_cierre->format('d-m-Y') }}
                        @endif
                    </x-ui-td>
                    <x-ui-td>
                        @if ($posicion->activo)
                            {{ $posicion->activo->denominacion }}
                        @endif
                    </x-ui-td>
                    <x-ui-td>{{ $posicion->clase }}</x-ui-td>
                    <x-ui-td>{{ $posicion->estado }}</x-ui-td>
                    <x-ui-td align='right'>
                        @if ($c = $posicion->cantidad)
                            {{ number_format($c, 0, ',', '.') }}
                        @endif
                    </x-ui-td>
                    <x-ui-td align='right'>
                        {{ number_format($posicion->resultado, 2, ',', '.') }}
                    </x-ui-td>
                <tr>
            @endforeach

        </x-ui-table>

    </x-ui-box>

</x-ui-layout>
