<?php

namespace Admin\MvcAdminLte;

use Config\AppConfig;
use Exception;
use PDO;

class ProcessData
{
    protected Database $database;
    protected PDO $pdo;
    protected array $file = [], $data = [];
    protected string $table, $query;
    protected bool $isPrepared = false;
    protected array $prepareData = [];
    protected string $filePath = "@TABLE/@ID";
    protected array $pendingFiles = [];
    public function __construct()
    {
        $this->database = new Database;
        $this->pdo = $this->database->connect();
    }

    public function prepare(
        string $table,
        array $data
    ): self {
        $this->isPrepared = true;
        $this->prepareData = [];

        $this->table = $table;
        $this->data = $data["data"] ?? [];
        $this->file = $data["file"] ?? [];

        return $this;
    }

    public function insert()
    {
        try {
            if (!$this->isPrepared)
                throw new Exception("...");

            $this->database->executeQuery("");

        } catch (Exception $th) {
            throw new Exception("...");
        }
    }

    public function update(
        int $id
    ) {
        try {
            if (!$this->isPrepared)
                throw new Exception("...");

            $this->database->executeQuery("");

        } catch (Exception $th) {
            throw new Exception("...");
        }
    }

    private function formatQuery(string $type, string $condition): string
    {
        try {
            $pData = self::processData();
            $pFile = self::processFile();

            $names = [...$pData["names"], ...$pFile["names"]];
            $values = [...$pData["values"], ...$pFile["values"]];

            $split = fn(array $array): string => implode(",", $array);
            $updateValues = array_map(function ($k, $v) {
                return "{$k} = {$v}";
            }, $names, $values);

            $this->query = [
                "INSERT" => "INSERT INTO {$this->table} ({$split($names)}) VALUES ({$split($values)})",
                "UPDATE" => "UPDATE {$this->table} SET {$split($updateValues)} WHERE {$condition}"
            ][$type];

            return $this->query;
        } catch (Exception $th) {
            throw new Exception("...");
        }
    }

    private function processData(): array
    {
        try {
            $data = [];

            foreach ($this->data as $name => $value) {
                $data["names"][] = $name;
                $data["values"][] = ":{$name}";

                $this->prepareData[":{$name}"] = is_array($value) ? json_encode($value, JSON_UNESCAPED_UNICODE) : $value;
            }
            return $data;
        } catch (Exception $th) {
            throw new Exception("...");
        }
    }

    private function processFile(): array
    {
        try {
            $data = [];

            foreach ($this->file["name"] ?? [] as $name => $value) {
                $uid = uniqid();
                if (is_array($value)) {
                    for ($i = 0; $i < count($value); $i++) {
                        $value[$i] = "/{$this->filePath}/{$uid}_{$value[$i]}";

                        $this->pendingFiles[] = [
                            "from" => $this->file["tmp_name"][$name][$i],
                            "to" => $value[$i]
                        ];
                    }
                } else {
                    $value = "/{$this->filePath}/{$uid}_{$value}";

                    $this->pendingFiles[] = [
                        "from" => $this->file["tmp_name"][$name],
                        "to" => $value
                    ];
                }

                $data["names"][] = $name;
                $data["values"][] = ":{$name}";

                $this->prepareData[":{$name}"] = is_array($value) ? json_encode($value, JSON_UNESCAPED_UNICODE) : $value;
            }
            return $data;
        } catch (Exception $th) {
            throw new Exception("...");
        }
    }

    private function movePendingFiles($id = null): void
    {
        if ($this->pendingFiles) {
            foreach ($this->pendingFiles as $data) {
                $from = $data["from"];
                $to = $data["to"];

                $to = str_replace([
                    "\\",
                    "@ID",
                    "@TABLE",
                    "@DATE",
                    "@HOUR",
                    "@FULLDATE"
                ], [
                    "/",
                    $id,
                    $this->table,
                    date("Y-m-d"),
                    date("H:i:s"),
                    date("Y-m-d H:i:s")
                ], $to);

                $to = AppConfig::BASE_FOLDER_FILE . "/" . trim($to, "/");

                $path = dirname($to);

                # Create a folder if it does not exist
                if (!file_exists($path))
                    @mkdir($path, 0777, true);

                # Move pending files
                if ($from !== null && $to !== null)
                    @move_uploaded_file($from, $to);
            }
        }
    }
}
