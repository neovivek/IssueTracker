<?php
if(!defined('__ROOT__')) define('__ROOT__', dirname(__FILE__));
require_once '/Util/connectdb.php';
require_once '/Util/ConnectionManager.php';

$testVar = new ConnectionManager($user, $password);
$testVar->createConnection();
$testVar->selectDatabase($database);
$query = "CREATE TABLE IF NOT EXISTS project (
		id BIGINT(11) PRIMARY KEY AUTO_INCREMENT,
		project VARCHAR(50) NOT NULL,
		active INT(2) 
		)";
$query1 = "ALTER TABLE project AUTO_INCREMENT=1000000000";
$query2 = "INSERT INTO project (`project`, `active`) VALUES('pos simulator', '1')";
// $testVar->execute($query);
// $testVar->execute($query1);
// $testVar->execute($query2);

include "./Public/header.php";
echo "<main>";
include './Public/welcome.php';
echo "</main>";
include './Public/footer.php';
?>