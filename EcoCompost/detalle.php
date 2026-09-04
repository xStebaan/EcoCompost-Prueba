<?php

require_once 'config/config.php';

require_once 'clases/MaterialOrganico.php';
require_once 'clases/Componente.php';
require_once 'clases/MezclaCompost.php';
require_once 'clases/EvaluadorMezcla.php';


$id = filter_input(
    INPUT_GET,
    'id',
    FILTER_VALIDATE_INT
);


$mezclaEncontrada = null;


if ($id !== false && $id !== null) {

    foreach ($_SESSION['mezclas'] as $mezcla) {

        if ($mezcla->getId() === $id) {

            $mezclaEncontrada = $mezcla;

            break;
        }
    }
}


require_once 'includes/header.php';

?>


<?php if ($mezclaEncontrada === null): ?>


    <div class="alert alert-danger">

        <h5>
            Mezcla no encontrada
        </h5>

        <p class="mb-0">

            La mezcla que intentas consultar
            no existe.

        </p>

    </div>

    <a
        href="index.php"
        class="btn btn-secondary">

        ← Volver

    </a>


<?php else: ?>


<?php

$evaluador = new EvaluadorMezcla();

$resultado = $evaluador->evaluar(
    $mezclaEncontrada
);

$resumen = $mezclaEncontrada->obtenerResumen();

?>


<div class="d-flex justify-content-between align-items-center mb-4">

    <div>

        <h1>

            <?= htmlspecialchars(
                $mezclaEncontrada->getNombre()
            ) ?>

        </h1>

        <p class="text-muted">

            Mezcla #<?= $mezclaEncontrada->getId() ?>

            <br>

            Registrada:

            <?= htmlspecialchars(
                $mezclaEncontrada->getFecha()
            ) ?>

        </p>

    </div>

    <a
        href="index.php"
        class="btn btn-secondary">

        ← Volver

    </a>

</div>


<!-- Resultado -->

<div class="card shadow-sm mb-4">

    <div class="card-header">

        <h5 class="mb-0">
            Resultado de la evaluación
        </h5>

    </div>

    <div class="card-body">


        <?php if (
            $resultado['estado'] === 'Equilibrada'
        ): ?>


            <div class="alert alert-success">

                <h4>
                    ✅ <?= $resultado['estado'] ?>
                </h4>

                <p class="mb-0">

                    <?= htmlspecialchars(
                        $resultado['mensaje']
                    ) ?>

                </p>

            </div>


        <?php else: ?>


            <div class="alert alert-warning">

                <h4>
                    ⚠️ <?= $resultado['estado'] ?>
                </h4>

                <p class="mb-0">

                    <?= htmlspecialchars(
                        $resultado['mensaje']
                    ) ?>

                </p>

            </div>


        <?php endif; ?>


        <div class="row text-center mt-4">


            <div class="col-md-4">

                <div class="card border-warning">

                    <div class="card-body">

                        <h2 class="text-warning">

                            <?= number_format(
                                $resultado['carbono'],
                                2
                            ) ?>%

                        </h2>

                        <p class="mb-0">
                            Carbono
                        </p>

                    </div>

                </div>

            </div>


            <div class="col-md-4">

                <div class="card border-success">

                    <div class="card-body">

                        <h2 class="text-success">

                            <?= number_format(
                                $resultado['nitrogeno'],
                                2
                            ) ?>%

                        </h2>

                        <p class="mb-0">
                            Nitrógeno
                        </p>

                    </div>

                </div>

            </div>


            <div class="col-md-4">

                <div class="card border-primary">

                    <div class="card-body">

                        <h2 class="text-primary">

                            <?= number_format(
                                $mezclaEncontrada
                                    ->calcularCantidadTotal(),
                                2
                            ) ?>

                            kg

                        </h2>

                        <p class="mb-0">
                            Cantidad total
                        </p>

                    </div>

                </div>

            </div>


        </div>

    </div>

</div>


<!-- Componentes -->

<div class="card shadow-sm">

    <div class="card-header bg-success text-white">

        <h5 class="mb-0">
            Composición de la mezcla
        </h5>

    </div>

    <div class="card-body">

        <div class="table-responsive">

            <table class="table table-hover">

                <thead>

                    <tr>

                        <th>
                            Material
                        </th>

                        <th>
                            Categoría
                        </th>

                        <th>
                            Tipo
                        </th>

                        <th>
                            Cantidad
                        </th>

                        <th>
                            Porcentaje
                        </th>

                    </tr>

                </thead>

                <tbody>


                <?php foreach ($resumen as $componente): ?>


                    <tr>

                        <td>

                            <strong>

                                <?= htmlspecialchars(
                                    $componente['material']
                                ) ?>

                            </strong>

                        </td>

                        <td>

                            <?= htmlspecialchars(
                                $componente['categoria']
                            ) ?>

                        </td>

                        <td>


                            <?php if (
                                $componente['tipo']
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


                        </td>

                        <td>

                            <?= number_format(
                                $componente['cantidad'],
                                2
                            ) ?>

                            kg

                        </td>

                        <td>

                            <?= number_format(
                                $componente['porcentaje'],
                                2
                            ) ?>%

                        </td>

                    </tr>


                <?php endforeach; ?>


                </tbody>

            </table>

        </div>

    </div>

</div>


<div class="mt-4">

    <a
        href="index.php"
        class="btn btn-secondary">

        ← Volver al listado

    </a>

    <a
        href="registrar.php"
        class="btn btn-success">

        + Nueva mezcla

    </a>

</div>


<?php endif; ?>


<?php

require_once 'includes/footer.php';

?>
