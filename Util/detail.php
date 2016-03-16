<?php
if(!(empty($_SERVER['HTTP_X_REQUESTED_WITH'])) and strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
	if(!(empty($_POST['id'])) and isset($_POST['id'])){
		header("Content-type: text/xml");
		if(!isset($_SESSION)) session_start();
		if(!defined('__ROOT__')) define('__ROOT__', dirname(dirname(__FILE__)));
		require_once __ROOT__.'/Util/connectdb.php';
		
		$query = "SELECT * FROM issues WHERE id = ? AND project_id = (SELECT id FROM project WHERE project= ?) ";
		
		$getUsrName = "SELECT name FROM user WHERE id= ? ";
		
		$arguments = array(
				$_POST['id'],
				$_SESSION['project']
		);
		$manager->execute($query, $arguments);
		echo "<data>";
		while($row = $manager->getStateHandle()->fetch(PDO::FETCH_ASSOC)){
			$arguments2 = array(
					$row['creator']
			);
			$manager->execute($getUsrName, $arguments2);
			$userNameFromDB = $manager->getStateHandle()->fetch(PDO::FETCH_ASSOC);
			echo "<block>".
				"<id>".$row['id']."</id>".
				"<title>".$row['title']."</title>".
				"<tags>".$row['tags']."</tags>".
				"<desc>".$row['description']."</desc>".
				"<C>".$userNameFromDB['name']."</C>".
				"<c>".$row['created_on']."</c>".
				"<S>".$row['severity']."</S>".
			"</block>";
		}
		echo "</data>";
	}
}else{
	echo "You don't have access.";
}
?>