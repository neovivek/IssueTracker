<?php
define("__ROOT__", dirname(__FILE__));
require_once __ROOT__.'/Util/connectdb.php';
require_once __ROOT__.'/Util/Components.php';
if(empty($_POST['name']) or !isset($_POST['name']) or empty($_POST['project']) or !isset($_POST['project']) ){
?>
<!DOCTYPE HTML>
<html>
	<head>
		<title>Amber | Detail | The all new Notepad</title>
		<meta charset="UTF-16">
		<link href="./css/materialize.min.css" rel="stylesheet" >
		<link href="./css/font-awesome.min.css" rel="stylesheet" >
		<link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	</head>
	<body>
		<?php require __ROOT__.'/Public/header.php';?>
		<main>
		<?php require __ROOT__.'/Public/welcome.php';?>
		</main>
		<?php require __ROOT__.'/Public/footer.php';?>
		<script src="./js/util/jquery-2.2.1.min.js"></script>
		<script src="./js/materialize.min.js" type="text/javascript" ></script>
		<script src="./js/util/io.js" type="text/javascript" ></script>
		<script type="text/javascript" src="./js/welcome.js"></script>
	</body>
</html>
<?php
}else {
	$username = $_POST['name'];
	$project = $_POST['project'];
	$comp = new Components($project, $username);
	$query = "SELECT * FROM issues WHERE `project`= ? ORDER BY `id` DESC";
	$arguments = array($comp->getCurrentProject());
	$manager->execute($query, $arguments);
	while($row = $manager->getStateHandle()->fetch(PDO::FETCH_ASSOC)){
		if($row['resolved'] == '0') $comp->printIssueBox($row);
		else $comp->printResolvedBox($row);
	}
}
?>