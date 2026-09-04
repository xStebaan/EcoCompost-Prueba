<?php

session_start();

define('NOMBRE_APP', 'EcoCompost');
define('VERSION_APP', '1.0');

if (!isset($_SESSION['mezclas'])) {
    $_SESSION['mezclas'] = [];
}

if (!isset($_SESSION['contador_mezclas'])) {
    $_SESSION['contador_mezclas'] = 1;
}
