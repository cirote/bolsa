<?php

namespace App\Http\Livewire\Cuentas;

use Livewire\Component;
use Cirote\Ui\Traits\Crud;
use App\Config\Constantes as Config;
use App\Models\Cuenta;

class Index extends Component
{
    use Crud;

    public $model_class = Cuenta::class;

    public $sort_by = 'sigla';

    public $sort_order = 'asc';

    protected $rules = [
        'model.sigla'  => 'required|string|min:3|max:50',
        'model.nombre' => 'required|string|min:3|max:500'
    ];

    public function ver_cuenta(Cuenta $cuenta)
    {
        return redirect()->route('movimientos.show', ['cuenta' => $cuenta]);
    }

    public function render()
    {
        $cuentas = Cuenta::conSaldos()
            ->orderBy($this->sort_by, strtoupper($this->sort_order));

        if ($this->filtro)
        {
            $cuentas->where('sigla', 'like', '%' . $this->filtro . '%')
                ->orWhere('nombre', 'like', '%' . $this->filtro . '%');
        }

        return view('livewire.cuentas.index', [
            'cuentas' => $cuentas->paginate($this->paginate)
        ]);
    }
}
