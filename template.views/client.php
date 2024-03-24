<?php

use Admin\MvcAdminLte\Route;
use Config\AppConfig;

?>

<!DOCTYPE html>
<html lang="<?= AppConfig::LANGUAGE ?>">

<head>
    <html lang="<?= strtoupper(AppConfig::LANGUAGE) ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= AppConfig::COMPANY['NAME'] ?>
    </title>
    <link rel="stylesheet" href="adminlte/css/adminlte.min.css">
    <base href="<?= AppConfig::BASE_SERVER ?>">
</head>

<body class="hold-transition layout-top-nav">
    <div class="wrapper">
        <nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
            <div class="container">
                <a href="#" class="navbar-brand">
                    <span class="brand-text font-weight-light">Tu Ecommerce</span>
                </a>
                <button class="navbar-toggler order-1" type="button" data-toggle="collapse"
                    data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse order-3" id="navbarCollapse">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a href="<?= Route::href("products") ?>" class="nav-link">Productos</a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= Route::href("cart") ?>" class="nav-link">Carrito</a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= Route::href("login") ?>" class="nav-link">Iniciar Sesión</a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= Route::href("register") ?>" class="nav-link">Registrarse</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="content-wrapper">
            <?= self::include($content, $vars) ?>
        </div>
    </div>

    <script src="<?= AppConfig::BASE_SERVER . "/plugins/jquery/jquery" ?>.min.js"></script>
    <script src="<?= AppConfig::BASE_SERVER . "/plugins/bootstrap/js/bootstrap.bundle" ?>.min.js"></script>
    <script src="<?= AppConfig::BASE_SERVER . "/adminlte/js/adminlte" ?>.min.js"></script>
</body>

</html>