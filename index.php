<?php

use Config\AppConfig;

include __DIR__ . "/vendor/autoload.php";

# Establecer el manejador de errores y excepciones solo si no estamos en producción
if (!AppConfig::PRODUCTION) {
    set_error_handler(function ($errno, $errstr, $errfile, $errline) {
        error_log("Error: [{$errno}] {$errstr} - {$errfile}:{$errline}");
    });

    set_exception_handler(function ($exception) {
        error_log("Exception: {$exception->getMessage()} - {$exception->getFile()}:{$exception->getLine()}");
    });
}

AppConfig::sessionStart(
    cookie_secure: AppConfig::PRODUCTION
);

header("Content-type: text/html; charset=" . AppConfig::CHARSET);

$VIEW_MODE = AppConfig::session("VIEW_MODE") ?: AppConfig::DEFAULT_VIEW_MODE;
$pathView = AppConfig::BASE_FOLDER . "/template.views/{$VIEW_MODE}.php";

if (file_exists($pathView))
    include $pathView;
else
    // Si el archivo de vista no existe, lanzar una excepción
    throw new Exception("It was not possible to include the template");
