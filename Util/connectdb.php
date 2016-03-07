<?php
if(!defined('__ROOT__')) define('__ROOT__', dirname(dirname(__FILE__)));
require_once __ROOT__.'/Util/ConnectionManager.php';
$user = "root";
$password = "root";
$database = "notepad";
$manager = new ConnectionManager($user, $password, $database);
$manager->createConnection();
?>