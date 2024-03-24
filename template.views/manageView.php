<?php

use Admin\MvcAdminLte\Route;
use Config\AppConfig;

Route::manageView(
    createFilesAndFolders: !AppConfig::PRODUCTION
);