<?php
// TOUJOURS EN PREMIER, AVANT TOUT LE RESTE
session_start();

// 1. Charge l'autoloader de Composer (indispensable pour phpdotenv)
require_once __DIR__ . '/vendor/autoload.php';

// 2. Charge les variables du .env
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// 3. Tes anciens require
require 'config/autoload.php';
require 'config/helpers.php';

$router = new Router();
$router->handleRequest();