<?php

require_once __DIR__ . '/configuracion/config.php';

require_once 'clases/MaterialOrganico.php';
require_once 'clases/Componente.php';
require_once 'clases/MezclaCompost.php';
require_once 'clases/EvaluadorMezcla.php';

require_once 'includes/header.php';

?>

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>

        <h1 class="fw-bold">
            🌱 EcoCompost
        </h1>

        <p class="text-muted">
            Evaluador de mezclas para compostaje
        </p>

    </div>

    <a
        href="registrar.php"
        class="btn btn-success">

        + Registrar mezcla

    </a>

</div>


<?php

// Mostrar mensaje almacenado en sesión
if (isset($_SESSION['mensaje'])):

?>

<div class="alert alert-success alert-dismissible fade show">

    <?= htmlspecialchars($_SESSION['mensaje']) ?>

    <button
        type="button"
        class="btn-close"
        data-bs-dismiss="alert">
    </button>

</div>

<?php

unset($_SESSION['mensaje']);

endif;

?>


<!-- Buscador -->

<div class="card shadow-sm mb-4">

    <div class="card-body">

        <h5 class="card-title">
            Buscar mezcla
        </h5>

        <form
            method="GET"
            action="index.php">

            <div class="input-group">

                <input
                    type="text"
                    name="buscar"
                    class="form-control"
                    placeholder="Ejemplo: compost finca..."
                    value="<?= htmlspecialchars($_GET['buscar'] ?? '') ?>">

                <button
                    type="submit"
                    class="btn btn-primary">

                    Buscar

                </button>

                <a
                    href="index.php"
                    class="btn btn-secondary">

                    Limpiar

                </a>

            </div>

        </form>

    </div>

</div>


<?php

$busqueda = trim($_GET['buscar'] ?? '');

$mezclasFiltradas = [];

foreach ($_SESSION['mezclas'] as $mezcla) {

    if (
        $busqueda === '' ||
        stripos(
            $mezcla->getNombre(),
            $busqueda
        ) !== false
    ) {

        $mezclasFiltradas[] = $mezcla;
    }
}

?>


<?php if (empty($_SESSION['mezclas'])): ?>

<div class="alert alert-info text-center">

    <h5>
        No existen mezclas registradas.
    </h5>

    <p>
        Registra tu primera mezcla para comenzar a evaluar
        la composición del compost.
    </p>

    <a
        href="registrar.php "
        class="btn btn-success">

        Registrar primera mezcla

    </a>

</div>


<?php elseif (empty($mezclasFiltradas)): ?>

<div class="alert alert-warning">

    No se encontraron mezclas con el término:

    <strong>
        <?= htmlspecialchars($busqueda) ?>
    </strong>

</div>


<?php else: ?>


<div class="card shadow-sm">

    <div class="card-header bg-success text-white">

        <h5 class="mb-0">
            Mezclas registradas
        </h5>

    </div>

    <div class="card-body">

        <div class="table-responsive">

            <table class="table table-hover align-middle">

                <thead class="table-light">

                    <tr>

                        <th>
                            ID
                        </th>

                        <th>
                            Nombre
                        </th>

                        <th>
                            Fecha
                        </th>

                        <th>
                            Componentes
                        </th>

                        <th>
                            Total
                        </th>

                        <th>
                            Acción
                        </th>

                    </tr>

                </thead>

                <tbody>

                <?php foreach ($mezclasFiltradas as $mezcla): ?>

                    <tr>

                        <td>
                            #<?= $mezcla->getId() ?>
                        </td>

                        <td>

                            <strong>
                                <?= htmlspecialchars(
                                    $mezcla->getNombre()
                                ) ?>
                            </strong>

                        </td>

                        <td>
                            <?= htmlspecialchars(
                                $mezcla->getFecha()
                            ) ?>
                        </td>

                        <td>

                            <span class="badge bg-secondary">

                                <?= count(
                                    $mezcla->getComponentes()
                                ) ?>

                                materiales

                            </span>

                        </td>

                        <td>

                            <?= number_format(
                                $mezcla->calcularCantidadTotal(),
                                2
                            ) ?>

                            kg

                        </td>

                        <td>

                            <a
                                href="detalle.php?id=<?= $mezcla->getId() ?>"
                                class="btn btn-sm btn-primary">

                                Ver detalle

                            </a>

                        </td>

                    </tr>

                <?php endforeach; ?>

                </tbody>

            </table>

        </div>

    </div>

</div>


<?php endif; ?>


<div class="row mt-4">

    <div class="col-md-4">

        <div class="card border-success shadow-sm">

            <div class="card-body text-center">

                <h2 class="text-success">

                    <?= count($_SESSION['mezclas']) ?>

                </h2>

                <p class="mb-0">
                    Mezclas registradas
                </p>

            </div>

        </div>

    </div>

    <div class="col-md-4">

        <div class="card border-primary shadow-sm">

            <div class="card-body text-center">

                <h2 class="text-primary">
                    ♻️
                </h2>

                <p class="mb-0">
                    Gestión de residuos orgánicos
                </p>

            </div>

        </div>

    </div>

    <div class="col-md-4">

        <div class="card border-warning shadow-sm">

            <div class="card-body text-center">

                <h2 class="text-warning">
                    ⚖️
                </h2>

                <p class="mb-0">
                    Evaluación de composición
                </p>

            </div>

        </div>

    </div>

</div>


<?php

require_once 'includes/footer.php';

?>
