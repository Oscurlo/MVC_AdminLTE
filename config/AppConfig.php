<?php

namespace Config;

use Dotenv\Dotenv;

final class AppConfig
{
    const PRODUCTION = false;

    const TIMEZONE = "America/Bogota";
    const CHARSET = "utf-8";
    const LANGUAGE = "es";
    const CURRENCY = "COP";
    const UPS_CODE = "CO";
    const LOCALE = self::LANGUAGE . "-" . self::UPS_CODE;

    const BASE_FOLDER = "C:\\xampp\\htdocs\\MVC_AdminLTE";
    const BASE_SERVER = "http://localhost/MVC_AdminLTE";
    const BASE_FOLDER_FILE = self::BASE_FOLDER . "\\files";
    const DEFAULT_VIEW_MODE = "CLIENT";

    private const VALID_DISPLAY_MODE = [
        "ADMIN",
        "CLIENT"
    ];

    static function sessionStart(
        ?int $cookie_lifetime = 86400,
        bool $use_strict_mode = true,
        bool $cookie_secure = false,
        bool $cookie_httponly = true
    ): void {
        session_start([
            "cookie_lifetime" => $cookie_lifetime,
            "use_strict_mode" => $use_strict_mode,
            "cookie_secure" => $cookie_secure,
            "cookie_httponly" => $cookie_httponly
        ]);
    }

    static function dayToSecond(int $day): int
    {
        return $day * 86400;
    }

    static function session(string $name): mixed
    {
        return $_SESSION[$name] ?? null;
    }

    static function env(string $name): mixed
    {
        return $_ENV[$name] ?? null;
    }

    static function loadEnvironment(?string $dir = null): void
    {
        $dotenv = Dotenv::createImmutable($dir ?: self::BASE_FOLDER);
        $dotenv->load();
    }
}
