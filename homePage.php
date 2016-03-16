<?php
if(!defined('__ROOT__')) define("__ROOT__", dirname(__FILE__));
require_once __ROOT__.'/Util/Components.php';
require_once __ROOT__.'/Util/connectdb.php';
if(!isset($_SESSION)) session_start();
$query = "SELECT COUNT(*) AS total FROM issues WHERE ".
"project_id = (SELECT id FROM project WHERE project = '".$_SESSION['project']."')";
$manager->execute($query);
$row1 = $manager->getStateHandle()->fetch(PDO::FETCH_ASSOC);
$total_bugs = $row1['total'];

$query = "SELECT COUNT(*) AS open FROM issues WHERE is_resolved = 1 AND ".
"project_id = (SELECT id FROM project WHERE project = '".$_SESSION['project'] ."')";
$manager->execute($query);
$row2 = $manager->getStateHandle()->fetch(PDO::FETCH_ASSOC);
$open_bugs = $row2['open'];

$HeaderType = 1;   // This value is used in case of header type selection in header.php
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Amber | The all new Notepad</title>
		<meta charset="UTF-16">
		<link href="./css/bootstrap.min.css" rel="stylesheet" >
		<link href="./css/font-awesome.min.css" rel="stylesheet" >
		<link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
		<style type="text/css">
		.row .col.data-block {
		    padding: 8px;
		}div#issue-list {
		    position: relative;
		    padding-top: 5px;
		    border-top: 1px solid #ccc;
		    margin-top: 15px;
		}.row .col.browser-default {
		    padding: 3px;
		    height: 2em;
		}
		</style>
	</head>
	<body>
		<?php require_once __ROOT__.'/Public/header.php';?>
		<div class="row">
			<div class="col-sm-3 data-block">
				<div class="col-sm-12"><?php echo $_SESSION['username']; ?></div>
				<div class="col-sm-12"><?php echo $_SESSION['project']; ?></div>
				<div class="col-sm-12">
					<i class="fa fa-bug"></i>
					<span><?php echo $total_bugs; ?></span>
				</div>
				<div class="col-sm-12">
					<i class="fa fa-check"></i>
					<span><?php echo $open_bugs; ?></span>
				</div>
			</div>
			<div class='col-sm-9'>
				<div class="container data-block">
					<div class='col-sm-12'>
						<select class='browser-default col-sm-5' id='sorting-bay'>
							<option value='0' selected disabled>Sort By</option>
							<option value='1'>Severity</option>
							<option value='2'>Date</option>
						</select>
						<select class='browser-default col-sm-5 right' id='display-bay'>
							<option value='0' selected disabled>Show From</option>
							<option value='1'>All</option>
							<option value='2'>Resolved</option>
							<option value='3'>Open</option>
						</select>
					</div>
					<div class="col-sm-12" id="issue-list">
						<?php 
						$query = "SELECT id, title FROM issues WHERE is_resolved = 0 AND ".
						"project_id = (SELECT id FROM project WHERE project = '".$_SESSION['project']."') ".
						"ORDER BY ID DESC";
						$manager->execute($query);
						while ($row = $manager->getStateHandle()->fetch(PDO::FETCH_ASSOC)){
							echo "<div class='col-sm-12'>".
								"<span><a href='javascript: findDetails(".$row['id'].")'>ISSUE ".$row['id']."</a></span>".
								"<div class='col-sm-12 truncate'>".$row['title']."</div>".
							"</div>";
						}
						?>
					</div>
				</div>
			</div>
		</div>
		<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			<div class="modal-dialog" role="document">
				<div class="modal-content" id="issue-detail">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="myModalLabel">Modal title</h4>
					</div>
					<div class="modal-body">
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						<button type="button" class="btn btn-primary">Save changes</button>
					</div>
				</div>
			</div>
		</div>
		<script src="./js/util/jquery-2.2.1.min.js"></script>
		<script src="./js/bootstrap.min.js" type="text/javascript" ></script>
		<script src="./js/util/io.js"></script>
		<script src="./js/home.js"></script>
	</body>
</html>