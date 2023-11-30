<?php

use Model\ImageProcessor;
?>
<!-- Preloader -->
<div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="<?= ImageProcessor::correctImageURL($COMPANY["LOGO"]) ?>" alt="<?= $COMPANY["NAME"] ?> Logo" height="60" width="60">
</div>