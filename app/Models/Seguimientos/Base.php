<?php

namespace App\Models\Seguimientos;

class Base
{
    protected $seguimiento;

    public function __construct(Seguimiento $seguimiento)
    {
        $this->seguimiento = $seguimiento;
    }

    public function base()
    {
        return null;
    }

    public function techo()
    {
        return null;
    }

    public function techoCalculado()
    {
        return null;
    }

    public function puntaje()
    {
        return null;
    }

    public function estado()
    {
        return 'No definido';
    }
}
