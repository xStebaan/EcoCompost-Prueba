<?php

require_once __DIR__ . '/../configuracion/config.php';

?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title><?= NOMBRE_APP ?></title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

</head>

<body class="bg-light">


<!-- NAVBAR -->

<nav class="navbar navbar-dark bg-success">

    <div class="container">

        <!-- LOGO / INICIO -->

        <a
            class="navbar-brand fw-bold"
            href="index.php">

            🌱 EcoCompost

        </a>


        <!-- BOTONES -->

        <div>

            <a
                href="index.php"
                class="btn btn-outline-light me-2">

                Inicio

            </a>


            <a
                href="registrar.php"
                class="btn btn-light">

                + Nueva mezcla

            </a>

        </div>

    </div>

</nav>


<!-- CONTENIDO -->

<main class="container py-4">
