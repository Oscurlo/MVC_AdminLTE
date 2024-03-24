<?php

namespace Config;

use Dotenv\Dotenv;

final class AppConfig
{
    # Define si la aplicación está en modo de producción o no
    const PRODUCTION = false;

    # Configuración de zona horaria, codificación de caracteres, idioma y moneda
    const TIMEZONE = "America/Bogota";
    const CHARSET = "utf-8";
    const LANGUAGE = "es";
    const CURRENCY = "COP";
    const UPS_CODE = "CO";
    const LOCALE = self::LANGUAGE . "-" . self::UPS_CODE;

    # Definición de rutas base para la aplicación
    const BASE_FOLDER = "C:\\xampp\\htdocs\\MVC_AdminLTE";
    const BASE_SERVER = "http://localhost/MVC_AdminLTE";

    # Rutas para manejo de vistas y archivos
    const MANAGES_BASE_FOLDER_VIEW = self::BASE_FOLDER . "\\app\\views";
    const BASE_FOLDER_VIEW = self::BASE_FOLDER . "\\public";
    const BASE_FOLDER_FILE = self::BASE_FOLDER . "\\files";

    # Modos de vista para la aplicación
    const VIEW_CLIENT_MODE = "CLIENT";
    const VIEW_ADMIN_MODE = "ADMIN";
    const DEFAULT_VIEW_MODE = self::VIEW_CLIENT_MODE;

    # Modos de visualización válidos
    private const VALID_DISPLAY_MODE = [
        "ADMIN",
        "CLIENT"
    ];

    # Iniciar sesión con opciones personalizadas
    static function sessionStart(
        int $cookie_lifetime = 86400,  # Duración predeterminada de la cookie de sesión en segundos (1 día)
        bool $use_strict_mode = true,  # Indica si se debe usar el modo estricto para las cookies de sesión
        bool $cookie_secure = false,   # Indica si las cookies de sesión deben ser seguras
        bool $cookie_httponly = true   # Indica si las cookies de sesión deben ser accesibles solo a través de HTTP
    ): void {
        date_default_timezone_set(self::TIMEZONE);

        session_start([
            "cookie_lifetime" => $cookie_lifetime,
            "use_strict_mode" => $use_strict_mode,
            "cookie_secure" => $cookie_secure,
            "cookie_httponly" => $cookie_httponly
        ]);
    }

    # Convertir días en segundos
    static function dayToSecond(int $day): int
    {
        return $day * 86400;
    }

    # Obtener una variable de sesión
    static function session(string $name): mixed
    {
        return $_SESSION[$name] ?? null;
    }

    # Obtener una variable de entorno
    static function env(string $name): mixed
    {
        return $_ENV[$name] ?? null;
    }

    # Cargar las variables de entorno desde un archivo .env
    static function loadEnvironment(?string $dir = null): void
    {
        $dotenv = Dotenv::createImmutable($dir ?: self::BASE_FOLDER);
        $dotenv->load();
    }
}
