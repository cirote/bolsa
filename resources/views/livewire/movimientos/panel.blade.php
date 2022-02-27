<x-ui-box>
    <x-slot name="header">
        Acciones
    </x-slot>

    <x-ui-row>
        <x-ui-button wire:click="importar_stone">
            Importar Stone X
        </x-ui-button>

        <x-ui-button wire:click="importar_ppi">
            Importar PPI
        </x-ui-button>

        <x-ui-button wire:click="">
            Importar IOL
        </x-ui-button>

        <x-ui-button wire:click="">
            Importar BELL
        </x-ui-button>

        <x-ui-button wire:click="">
            Importar Afluenta
        </x-ui-button>

        <x-ui-button wire:click="">
            Importar Okex
        </x-ui-button>

        <x-ui-button wire:click="">
            Importar Binance
        </x-ui-button>
    </x-ui-row>

    <br>

    <x-ui-row>
        <x-ui-button wire:click="calcular_saldos">
            Calculas saldos
        </x-ui-button>

        <x-ui-button wire:click="imputar_movimientos">
            Imputar movimientos
        </x-ui-button>
    </x-ui-row>

</x-ui-box>