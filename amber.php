<?php
require_once '/Util/ConnectionManager.php';

$testVar = new ConnectionManager('root', 'root');
$testVar->createConnection();
echo "Working<br>";

$testVar->createDatabase("notepad");
echo $testVar->getDatabase();

?>