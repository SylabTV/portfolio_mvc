<?php
// TOUJOURS EN PREMIER, AVANT TOUT LE RESTE
session_start();

require 'config/autoload.php';
require 'config/helpers.php';

$router = new Router();
$router->handleRequest();