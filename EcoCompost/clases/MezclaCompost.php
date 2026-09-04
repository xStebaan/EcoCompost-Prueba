<?php

require_once __DIR__ . '/Componente.php';

class MezclaCompost
{
    private int $id;
    private string $nombre;
    private string $fecha;
    private array $componentes;

    public function __construct(
        int $id,
        string $nombre
    ) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->fecha = date('Y-m-d H:i:s');
        $this->componentes = [];
    }

    public function agregarComponente(
        Componente $componente
    ): void {
        $this->componentes[] = $componente;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getNombre(): string
    {
        return $this->nombre;
    }

    public function getFecha(): string
    {
        return $this->fecha;
    }

    public function getComponentes(): array
    {
        return $this->componentes;
    }

    public function calcularCantidadTotal(): float
    {
        $total = 0;

        foreach ($this->componentes as $componente) {
            $total += $componente->getCantidad();
        }

        return $total;
    }

    public function obtenerResumen(): array
    {
        $total = $this->calcularCantidadTotal();

        $resumen = [];

        foreach ($this->componentes as $componente) {

            $resumen[] = [
                'material' => $componente
                    ->getMaterial()
                    ->getNombre(),

                'categoria' => $componente
                    ->getMaterial()
                    ->getCategoria(),

                'tipo' => $componente
                    ->getMaterial()
                    ->getTipo(),

                'cantidad' => $componente->getCantidad(),

                'porcentaje' => $componente
                    ->calcularPorcentaje($total)
            ];
        }

        return $resumen;
    }
}
         