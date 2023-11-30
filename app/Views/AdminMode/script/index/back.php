<?php

# Includes your controller

use Controller\Dashboard;
use Model\ImageProcessor;

include_once explode("\\app\\", __DIR__)[0] . "/vendor/autoload.php";

$dashboard = new Dashboard;

$config = [];
$response = [];

$response = $dashboard::ssp_users([
    ["db" => "USER.id"],
    ["db" => "USER.name"],
    ["db" => "ROLE.role"],
    ["db" => "USER.files", "formatter" => function ($d) {
        $verify = ImageProcessor::correctImageURL($d);

        return $verify ? <<<HTML
        <img src="{$verify}" class="img-size-50" alt="User Image">
        HTML : "¯\_(ツ)_/¯";
    }]
], $config);

echo json_encode($response, JSON_UNESCAPED_UNICODE);
