<?php

class MaterialOrganico
{
    private string $nombre;
    private string $categoria;
    private string $tipo;

    public function __construct(
        string $nombre,
        string $categoria,
        string $tipo
    ) {
        $this->nombre = $nombre;
        $this->categoria = $categoria;
        $this->tipo = $tipo;
    }

    public function getNombre(): string
    {
        return $this->nombre;
    }

    public function getCategoria(): string
    {
        return $this->categoria;
    }

    public function getTipo(): string
    {
        return $this->tipo;
    }

    public function getDescripcion(): string
    {
        return $this->nombre . ' - ' . $this->tipo;
    }
}
