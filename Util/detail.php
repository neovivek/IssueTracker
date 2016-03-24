<?php
if(!(empty($_SERVER['HTTP_X_REQUESTED_WITH'])) and strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){

	header("Content-type: text/xml");
	if(!(empty($_POST['id'])) and isset($_POST['id'])){
	
		if(!isset($_SESSION)) session_start();
		if(!defined('__ROOT__')) define('__ROOT__', dirname(dirname(__FILE__)));
		require_once __ROOT__.'/Util/connectdb.php';
		if(isset($_POST['a'])){
			$query = "SELECT * FROM issues WHERE id = ? ";
			$getUsrName = "SELECT name FROM user WHERE id= ? ";
			$getProjectCredential = "SELECT ";
			
			switch ($_POST['a']){
				case 1:
					$arguments = array(
							$_POST['id']
					);
					$sth = $manager->executeQuery($query, $arguments);
					echo "<data>";
					while($row = $sth->fetch(PDO::FETCH_ASSOC)){
						$arguments2 = array(
								$row['creator']
						);
						$manager->executeQuery($getUsrName, $arguments2);
						$userNameFromDB = $manager->getStateHandle()->fetch(PDO::FETCH_ASSOC);
						echo "<block>".
								"<id>".$row['id']."</id>".
								"<title>".$row['title']."</title>".
								"<tags>".$row['tags']."</tags>".
								"<desc>".$row['description']."</desc>".
								"<C>".$userNameFromDB['name']."</C>".
								"<c>".$row['created_on']."</c>".
								"<S>".$row['severity']."</S>".
								"<R>".$row['is_resolved']."</R>".
								"</block>";
					}
					echo "</data>";
					return;
				case 2:
					return;
				default:
					return;
			}
		}
		
	}else{
		echo "<data><block><status content='failure' /></block></data>";
	}
	
}else{
	echo "You don't have access.";
}
?>