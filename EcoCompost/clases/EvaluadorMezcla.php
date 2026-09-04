<?php

require_once __DIR__ . '/MezclaCompost.php';

class EvaluadorMezcla
{
    public function evaluar(MezclaCompost $mezcla): array
    {
        $total = $mezcla->calcularCantidadTotal();

        if ($total <= 0) {
            return [
                'estado' => 'Error',
                'mensaje' => 'La mezcla no contiene materiales.'
            ];
        }

        $carbono = 0;
        $nitrogeno = 0;

        foreach ($mezcla->getComponentes() as $componente) {

            $tipo = $componente
                ->getMaterial()
                ->getTipo();

            if ($tipo === 'Carbono') {

                $carbono += $componente->getCantidad();

            } elseif ($tipo === 'Nitrogeno') {

                $nitrogeno += $componente->getCantidad();
            }
        }

        $porcentajeCarbono = ($carbono / $total) * 100;
        $porcentajeNitrogeno = ($nitrogeno / $total) * 100;

        /*
         * Regla básica de EcoCompost:
         *
         * Carbono: mínimo 40%
         * Nitrógeno: mínimo 20%
         */

        if ($porcentajeCarbono < 40) {

            return [
                'estado' => 'Requiere ajustes',
                'mensaje' => 'La mezcla tiene poco material rico en carbono.',
                'carbono' => $porcentajeCarbono,
                'nitrogeno' => $porcentajeNitrogeno
            ];
        }

        if ($porcentajeNitrogeno < 20) {

            return [
                'estado' => 'Requiere ajustes',
                'mensaje' => 'La mezcla tiene poco material rico en nitrógeno.',
                'carbono' => $porcentajeCarbono,
                'nitrogeno' => $porcentajeNitrogeno
            ];
        }

        return [
            'estado' => 'Equilibrada',
            'mensaje' => 'La mezcla presenta una composición adecuada según las reglas básicas de EcoCompost.',
            'carbono' => $porcentajeCarbono,
            'nitrogeno' => $porcentajeNitrogeno
        ];
    }
}
