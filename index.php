<?php

# Se importa la configuración de la aplicación
use Config\AppConfig;

# Se incluye el archivo autoload.php para cargar las clases automáticamente
include __DIR__ . "/vendor/autoload.php";

# Manejo de errores y excepciones en modo no producción
if (!AppConfig::PRODUCTION) {
    # Definición del manejador de errores personalizado
    set_error_handler(function ($errno, $errstr, $errfile, $errline) {
        # Se registra el error en el log de errores
        error_log("Error: [{$errno}] {$errstr} - {$errfile}:{$errline}");
    });

    # Definición del manejador de excepciones personalizado
    set_exception_handler(function ($ex) {
        # Se registra la excepción en el log de errores
        error_log("Exception: [{$ex->getMessage()}] - {$ex->getFile()}:{$ex->getLine()}");
    });
}

# Inicio de la sesión con opciones específicas
AppConfig::sessionStart(
    cookie_secure: AppConfig::PRODUCTION # Se asegura que las cookies de sesión sean seguras en modo producción
);

# Configuración de la cabecera HTTP para el tipo de contenido y la codificación de caracteres
header("Content-type: text/html; charset=" . AppConfig::CHARSET);

# Ruta de la vista principal
$pathView = AppConfig::BASE_FOLDER . "/template.views/manageView.php";

# Inclusión de la vista principal si existe, de lo contrario, se lanza una excepción
if (file_exists($pathView))
    include $pathView;
else
    throw new Exception("No fue posible incluir la plantilla");
