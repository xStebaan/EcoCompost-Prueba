<?php

require_once __DIR__ . '/MaterialOrganico.php';

class Componente
{
    private MaterialOrganico $material;
    private float $cantidad;

    public function __construct(
        MaterialOrganico $material,
        float $cantidad
    ) {
        $this->material = $material;
        $this->cantidad = $cantidad;
    }

    public function getMaterial(): MaterialOrganico
    {
        return $this->material;
    }

    public function getCantidad(): float
    {
        return $this->cantidad;
    }

    public function calcularPorcentaje(float $total): float
    {
        if ($total <= 0) {
            return 0;
        }

        return ($this->cantidad / $total) * 100;
    }
}
