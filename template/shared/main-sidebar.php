<?php

use Model\ImageProcessor;

$data = $_SESSION ?>

<aside class="main-sidebar main-sidebar-custom sidebar-light-primary elevation-4">
    <a href="index3.html" class="brand-link">
        <img src="<?= ImageProcessor::correctImageURL($COMPANY["LOGO"]) ?>" alt="<?= $COMPANY["NAME"] ?> Logo" class="brand-image img-circle" style="opacity: .8">
        <span class="brand-text font-weight-light"><?= $COMPANY["NAME"] ?></span>
    </a>
    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="<?= ImageProcessor::correctImageURL($data["files"]) ?>" class="img-circle" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block"><?= $data["name"] ?></a>
            </div>
        </div>
        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column nav-legacy" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="<?= $SERVER, "/To-Do-List" ?>" class="nav-link">
                        <i class="nav-icon fas fa-list"></i>
                        <p>
                            To-Do List
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= $SERVER, "/Calendar" ?>" class="nav-link">
                        <i class="nav-icon fas fa-calendar"></i>
                        <p>
                            Calendar
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
    <div class="sidebar-custom">
        <!-- <a href="#" class="btn btn-link"><i class="fas fa-cogs"></i></a> -->
        <button class="btn btn-danger hide-on-collapse pos-right" id="btnDisconnect"><i class="fas fa-sign-out-alt"></i> Salir</button>
    </div>
</aside>