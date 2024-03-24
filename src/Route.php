<?php

namespace Admin\MvcAdminLte;

use Config\AppConfig;

final class Route
{
    # Obtiene la vista basada en la ruta proporcionada en la URL
    static function getView()
    {
        $route = $_GET["route"] ?? "index"; # Obtiene la ruta de la URL, si no existe, usa "index" como ruta por defecto
        return self::prepareStringView(str: $route); # Retorna la vista preparada como una cadena
    }

    # Obtiene el nombre del archivo de la vista
    static function view(?string $view = null): string
    {
        [$filename] = explode(".", !is_null($view) ? self::prepareStringView(str: $view) : self::getView()); # Divide la vista en un arreglo y obtiene el nombre del archivo
        return $filename; # Retorna el nombre del archivo de la vista
    }

    # Administra la vista y crea archivos y carpetas si es necesario
    static function manageView(bool $createFilesAndFolders = true): void
    {
        $view = self::getView(); # Obtiene la vista
        $VIEW_MODE = strtolower(AppConfig::session("VIEW_MODE") ?: AppConfig::DEFAULT_VIEW_MODE); # Obtiene el modo de vista de la sesión o usa el modo predeterminado

        # Crea archivos y carpetas si no está en modo de producción y se especifica
        if (!AppConfig::PRODUCTION && $createFilesAndFolders)
            self::createFilesAndFolders(view: "{$VIEW_MODE}\\{$view}");

        # Incluye el archivo de administración de la vista
        include AppConfig::MANAGES_BASE_FOLDER_VIEW . "\\{$VIEW_MODE}\\{$view}.manages.php";
    }

    # Crea archivos y carpetas necesarios para la vista
    private static function createFilesAndFolders(string $view)
    {
        [$view] = explode(".", $view); # Divide la vista en un arreglo

        # Función para dividir la ruta del archivo en directorio y nombre de archivo
        $splitView = fn(string $path) => [dirname($path), basename($path)];

        # Obtiene la carpeta base de la vista y la carpeta base de administración de la vista
        $baseFolderView = AppConfig::BASE_FOLDER_VIEW;
        $managesBaseFolderView = AppConfig::MANAGES_BASE_FOLDER_VIEW;

        # Archivos y carpetas a crear
        $filesToCreate = [
            "view" => "{$baseFolderView}\\{$view}.view.php",
            "managesView" => "{$managesBaseFolderView}\\{$view}.manages.php",
            "back" => "{$managesBaseFolderView}\\script\\{$view}\\back.php",
            "front" => "{$managesBaseFolderView}\\script\\{$view}\\front.js",
            "generalBack" => "{$managesBaseFolderView}\\backend.php",
            "generalFront" => "{$managesBaseFolderView}\\frontend.js",
            "generalStyle" => "{$managesBaseFolderView}\\style.css",
        ];

        # Itera sobre los archivos a crear
        foreach ($filesToCreate as $type => $file) {
            $file = str_replace("\\.\\", "\\", $file); # Reemplaza "\\.\\" con "\\" en la ruta del archivo

            # Si el archivo no existe, lo crea
            if (!file_exists($file)) {
                mkdir(dirname($file), 0777, true); # Crea el directorio si no existe
                $openString = fopen($file, "w"); # Abre el archivo
                $data = date("Y-m-d h:i:s A"); # Obtiene la fecha y hora actual
                fwrite($openString, $data); # Escribe la fecha y hora en el archivo
                fclose($openString); # Cierra el archivo
            }
        }
    }

    # Genera una URL completa a partir de la ruta y los parámetros GET proporcionados
    static function href(?string $url = null, array $gets = [])
    {
        # Si la URL no está vacía, elimina la parte de la URL base y agrega una barra al principio
        $url = !empty ($url) ? "/" . str_replace(AppConfig::BASE_SERVER, "", $url ?: "") : "";
        # Si hay parámetros GET, los convierte en una cadena de consulta y los agrega a la URL
        $gets = !empty ($gets) ? "?" . http_build_query($gets) : "";

        # Retorna la URL completa
        return AppConfig::BASE_SERVER . $url . $gets;
    }

    # Prepara la cadena de la vista eliminando la carpeta base y la carpeta del servidor base, y ajusta la vista a "index" si es necesario
    private static function prepareStringView(string $str): string
    {
        # Si la última letra de la cadena de vista es una barra, agrega "index" al final
        if ($str[strlen($str) - 1] === "/")
            $newStr = "{$str}index";
        else
            $newStr = $str ?: "index"; # Si la cadena está vacía, usa "index" como vista predeterminada

        # Elimina la carpeta base y la carpeta del servidor base de la cadena de vista
        $newStr = str_replace([
            AppConfig::BASE_FOLDER,
            AppConfig::BASE_SERVER
        ], "", $newStr);

        # Elimina cualquier barra inicial o final en la cadena de vista y la retorna
        return trim($newStr, "/");
    }
}
