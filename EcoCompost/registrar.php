<?php
require_once __DIR__ . '/configuracion/config.php';

require_once 'clases/MaterialOrganico.php';
require_once 'clases/Componente.php';
require_once 'clases/MezclaCompost.php';
require_once 'clases/EvaluadorMezcla.php';

$materiales = [

    'hojas' => new MaterialOrganico(
        'Hojas secas',
        'Residuo vegetal',
        'Carbono'
    ),

    'aserrin' => new MaterialOrganico(
        'Aserrín',
        'Residuo forestal',
        'Carbono'
    ),

    'paja' => new MaterialOrganico(
        'Paja',
        'Residuo agrícola',
        'Carbono'
    ),

    'estiercol' => new MaterialOrganico(
        'Estiércol bovino',
        'Residuo animal',
        'Nitrogeno'
    ),

    'frutas' => new MaterialOrganico(
        'Restos de frutas y verduras',
        'Residuo orgánico',
        'Nitrogeno'
    )
];

$errores = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nombre = trim($_POST['nombre'] ?? '');

    $cantidades = $_POST['cantidad'] ?? [];


    // Validar nombre

    if ($nombre === '') {

        $errores[] =
            'El nombre de la mezcla es obligatorio.';

    } elseif (strlen($nombre) < 3) {

        $errores[] =
            'El nombre debe tener al menos 3 caracteres.';
    }


    $componentes = [];


    // Procesar cantidades

    foreach ($cantidades as $clave => $cantidad) {

        if ($cantidad === '') {
            continue;
        }


        if (!isset($materiales[$clave])) {

            $errores[] =
                'Se recibió un material no válido.';

            continue;
        }


        if (
            !is_numeric($cantidad) ||
            $cantidad <= 0
        ) {

            $errores[] =
                'La cantidad de ' .
                $materiales[$clave]->getNombre() .
                ' debe ser mayor que 0.';

            continue;
        }


        $cantidad = (float) $cantidad;


        if ($cantidad > 10000) {

            $errores[] =
                'La cantidad de ' .
                $materiales[$clave]->getNombre() .
                ' no puede superar 10.000 kg.';

            continue;
        }


        $componentes[] = new Componente(
            $materiales[$clave],
            $cantidad
        );
    }


    // Verificar que exista al menos un componente

    if (count($componentes) === 0) {

        $errores[] =
            'Debes ingresar al menos un material.';
    }


    // Si no hay errores, crear la mezcla

    if (empty($errores)) {

        $id = $_SESSION['contador_mezclas'];

        $mezcla = new MezclaCompost(
            $id,
            $nombre
        );


        foreach ($componentes as $componente) {

            $mezcla->agregarComponente(
                $componente
            );
        }


        // Guardar en sesión

        $_SESSION['mezclas'][] = $mezcla;

        $_SESSION['contador_mezclas']++;


        $_SESSION['mensaje'] =
            'La mezcla "' .
            $nombre .
            '" fue registrada correctamente.';


        header('Location: index.php');

        exit;
    }
}


require_once 'includes/header.php';

?>


<div class="row justify-content-center">

    <div class="col-lg-9">

        <div class="card shadow-sm">

            <div class="card-header bg-success text-white">

                <h4 class="mb-0">
                    🌱 Registrar nueva mezcla
                </h4>

            </div>

            <div class="card-body p-4">


                <?php if (!empty($errores)): ?>

                    <div class="alert alert-danger">

                        <h6>
                            ⚠️ Corrige los siguientes errores:
                        </h6>

                        <ul class="mb-0">

                            <?php foreach ($errores as $error): ?>

                                <li>
                                    <?= htmlspecialchars($error) ?>
                                </li>

                            <?php endforeach; ?>

                        </ul>

                    </div>

                <?php endif; ?>


                <form
                    method="POST"
                    action="registrar.php">


                    <div class="mb-4">

                        <label class="form-label fw-bold">

                            Nombre de la mezcla

                        </label>

                        <input
                            type="text"
                            name="nombre"
                            class="form-control"
                            placeholder="Ej: Compost finca La Esperanza"
                            value="<?= htmlspecialchars(
                                $_POST['nombre'] ?? ''
                            ) ?>"
                            required>

                    </div>


                    <hr>


                    <h5 class="mb-3">

                        Materiales orgánicos

                    </h5>

                    <p class="text-muted">

                        Ingresa la cantidad de cada material
                        utilizada en la mezcla.

                    </p>


                    <?php foreach ($materiales as $clave => $material): ?>

                        <div class="card mb-3 border-0 bg-light">

                            <div class="card-body">

                                <div class="row align-items-center">

                                    <div class="col-md-8">

                                        <h6 class="mb-1">

                                            <?= htmlspecialchars(
                                                $material->getNombre()
                                            ) ?>

                                        </h6>

                                        <small class="text-muted">

                                            Categoría:

                                            <?= htmlspecialchars(
                                                $material->getCategoria()
                                            ) ?>

                                            <br>

                                            Tipo:

                                            <?php if (
                                                $material->getTipo()
                                                === 'Carbono'
                                            ): ?>

                                                <span class="badge bg-warning text-dark">
                                                    Carbono
                                                </span>

                                            <?php else: ?>

                                                <span class="badge bg-success">
                                                    Nitrógeno
                                                </span>

                                            <?php endif; ?>

                                        </small>

                                    </div>


                                    <div class="col-md-4">

                                        <label class="form-label">

                                            Cantidad (kg)

                                        </label>

                                        <input
                                            type="number"
                                            name="cantidad[<?= $clave ?>]"
                                            class="form-control"
                                            min="0"
                                            step="0.1"
                                            placeholder="Ej: 10">

                                    </div>

                                </div>

                            </div>

                        </div>

                    <?php endforeach; ?>


                    <div class="alert alert-info mt-4">

                        <strong>
                            💡 Consejo:
                        </strong>

                        Una buena mezcla debe combinar materiales
                        ricos en carbono y nitrógeno.

                    </div>


                    <div class="d-flex justify-content-between mt-4">

                        <a
                            href="index.php"
                            class="btn btn-secondary">

                            Cancelar

                        </a>

                        <button
                            type="submit"
                            class="btn btn-success">

                            ⚖️ Evaluar y registrar

                        </button>

                    </div>


                </form>

            </div>

        </div>

    </div>

</div>


<?php

require_once 'includes/footer.php';

?>
