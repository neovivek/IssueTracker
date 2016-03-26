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
			$getProjectCredential = "SELECT p.active, u.name AS pro_man, u1.name AS creator 
					FROM project p WHERE id=?
					JOIN user u ON u.id=p.project_manager
					JOIN user u1 ON u1.id=p.created_by";
			
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
					$arguments = array(
						$_POST['id']
					);
					$manager->executeQuery($query, $arguments);
					if($manager->getStateHandle()->errorCode() == '00000'){
						$projectDetail = $manager->getStateHandle()->fetch(PDO::FETCH_ASSOC);
						if($projectDetail['active'] == 1) $status = "Active";
						else $status = "Inactive";
						echo "<data>
								<status>
									Current status ".$status.". Project started by ".$projectDetail['creator'].". Project managed by ".$projectDetail['pro_man'].".
								</status>
							</data>";
						
					}else{
						echo "<data><status>Can not fetch details right now.</status></data>";
					}
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