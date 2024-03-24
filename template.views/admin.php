<?php

use Config\AppConfig;

?>

<!DOCTYPE html>
<html lang="<?= AppConfig::LANGUAGE ?>">

<head>
    <meta charset="<?= AppConfig::CHARSET ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= AppConfig::COMPANY['NAME'] ?>
    </title>
</head>

<body>
    <?= self::include($content, $vars) ?>
</body>

</html>