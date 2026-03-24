<?php
// Charge automatiquement toutes les classes du projet
// sans avoir besoin de faire des require manuellement
spl_autoload_register(function (string $className) {
    $folders = ['models', 'managers', 'controllers', 'services'];
    foreach ($folders as $folder) {
        $file = __DIR__ . '/../' . $folder . '/' . $className . '.php';
        if (file_exists($file)) {
            require_once $file;
        }
    }
});