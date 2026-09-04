<?php

require_once 'config/config.php';

require_once 'clases/MaterialOrganico.php';
require_once 'clases/Componente.php';
require_once 'clases/MezclaCompost.php';
require_once 'clases/EvaluadorMezcla.php';

$busqueda = trim($_GET['buscar'] ?? '');

$resultados = [];

foreach ($_SESSION['mezclas'] as $mezcla) {

    if (
        stripos(
            $mezcla->getNombre(),
            $busqueda
        ) !== false
    ) {

        $resultados[] = $mezcla;
    }
}

require_once 'includes/header.php';

?>

<h1>
    Resultados de búsqueda
</h1>

<p class="text-muted">

    Búsqueda:

    <strong>
        <?= htmlspecialchars($busqueda) ?>
    </strong>

</p>


<?php if (empty($resultados)): ?>

    <div class="alert alert-warning">

        No se encontraron mezclas.

    </div>

<?php else: ?>

    <div class="list-group">

        <?php foreach ($resultados as $mezcla): ?>

            <a
                href="detalle.php?id=<?= $mezcla->getId() ?>"
                class="list-group-item list-group-item-action">

                <strong>

                    <?= htmlspecialchars(
                        $mezcla->getNombre()
                    ) ?>

                </strong>

                <br>

                <small class="text-muted">

                    <?= $mezcla->calcularCantidadTotal() ?>
                    kg

                </small>

            </a>

        <?php endforeach; ?>

    </div>

<?php endif; ?>


<a
    href="index.php"
    class="btn btn-secondary mt-4">

    ← Volver

</a>


<?php

require_once 'includes/footer.php';

?>
