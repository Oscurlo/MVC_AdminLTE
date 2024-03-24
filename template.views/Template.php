<?php

namespace Content;

use Config\AppConfig;

final class Template
{
    #------------------------------------------------#
    # Por defecto
    #------------------------------------------------#

    # Renderiza la plantilla para la interfaz de administrador
    static function admin(string $content = "", array $vars = []): void
    {
        include __DIR__ . "/admin.php";
    }

    # Renderiza la plantilla para la interfaz de cliente
    static function client(string $content = "", array $vars = []): void
    {
        include __DIR__ . "/client.php";
    }

    #------------------------------------------------#
    # Extras
    #------------------------------------------------#

    # Renderiza una plantilla para impresión directa
    static function print(string $content = ""): void
    {
        include __DIR__ . "/print.php";
    }

    # Incluye una plantilla con variables opcionales
    private static function include(string $content, array $vars = [])
    {
        # Si $content contiene etiquetas HTML, imprímelo directamente
        if (strpos($content, "<") !== false && strpos($content, ">") !== false)
            print $content;
        else {
            # Obtener el modo de vista de la sesión o usar el modo predeterminado
            $VIEW_MODE = strtolower(AppConfig::session("VIEW_MODE") ?: AppConfig::DEFAULT_VIEW_MODE);

            # Ruta de la vista basada en el modo de vista y el nombre de la plantilla
            $pathView = AppConfig::BASE_FOLDER_VIEW . "\\{$VIEW_MODE}\\{$content}.view.php";

            # Función para analizar y codificar valores en JSON
            $parseValue = fn($str) => json_encode($str, JSON_UNESCAPED_UNICODE);

            # Asignación de variables a partir del arreglo $vars
            foreach ($vars as $key => $value)
                if (!is_numeric($key))
                    eval ("\${$key} = {$parseValue($value)};");

            # Incluir la plantilla si existe, de lo contrario, mostrar un error 404
            if (file_exists($pathView))
                include $pathView;
            else
                echo "404";
        }
    }
}
