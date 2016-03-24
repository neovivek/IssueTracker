<?php

if(!(empty($_SERVER['HTTP_X_REQUESTED_WITH'])) and strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
	
	header("Content-type: text/xml");
	if(!(empty($_POST['key'])) and isset($_POST['key'])){

		if(!defined("__ROOT__")) define("__ROOT__", dirname(dirname(__FILE__)));
		require_once __ROOT__.'/Util/connectdb.php';
		if(isset($_POST['type'])){
			
			$queryOpenIssue = "UPDATE issues SET is_resolved='0' WHERE id=?";
			$queryCloseIssue = "UPDATE issues SET is_resolved='1' WHERE id=?";
			$argument = array($_POST['key']);
			
			switch($_POST['type']){
				case 1:
					$manager->executeQuery($queryCloseIssue, $argument);
					break;
				case 2:
					$manager->executeQuery($queryOpenIssue, $argument);
					break;
				default:
					break;
			}
			echo "<data>";
			if($manager->getStateHandle()->errorCode() == '00000')
				echo "<status content='success'></status>";
			else
				echo "<status content='failure' reason='query fail'></status>";
			echo "</data>";
		}
		
	}else{
		echo "<data><status content='failed' reason='no post'></status></data>";
	}
	
}else{
	echo "You don't have permission.";
}

?>