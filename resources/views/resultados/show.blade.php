<x-ui-layout>

    <x-slot name="header">
        Resultado del periodo {{ $resultado->fecha_inicial->format('d-m-Y') }} al
        {{ $resultado->fecha_final->format('d-m-Y') }}
    </x-slot>

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
