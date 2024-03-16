<?php

namespace Admin\MvcAdminLte;

use Config\AppConfig;
use Exception;
use PDO;
use PDOException;

final class Database
{
    private ?PDO $pdo = null;
    // public bool $CREATE_DATABASE = false;
    public function __construct()
    {
        AppConfig::loadEnvironment();
    }

    public function connect(
        ?string $dsn = null,
        ?string $username = null,
        ?string $password = null,
        ?array $options = null
    ): PDO {
        try {
            $dsn = $dsn ?: AppConfig::env("DB_DNS");
            $username = $username ?: AppConfig::env("DB_USERNAME");
            $password = $password ?: AppConfig::env("DB_PASSWORD");

            $options = $options ?: [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false
            ];

            $this->pdo = new PDO(
                dsn: $dsn,
                username: $username,
                password: $password,
                options: $options
            );

            return $this->pdo;
        } catch (PDOException $th) {
            throw new Exception("Error de conexión a la base de datos: " . $th->getMessage());
        }
    }

    public function executeQuery(
        string $query,
        array $prepare = [],
        array $options = [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]
    ): mixed {
        try {
            $stmt = $this->pdo->prepare($query, $options);
            $stmt->execute($prepare);

            if (stripos($query, "SELECT") === 0)
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            elseif (stripos($query, "INSERT") === 0 || stripos($query, "UPDATE") === 0 || stripos($query, "DELETE") === 0)
                return $stmt->rowCount();
            else
                return true;

        } catch (PDOException $th) {
            throw new Exception("Error al ejecutar la consulta: " . $th->getMessage());
        }
    }

    // protected function createDatabase() {}

    public function close(): void
    {
        $this->pdo = null;
    }
}
