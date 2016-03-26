<?php
if(!defined('__ROOT__')) define("__ROOT__", dirname(__FILE__));
require_once __ROOT__.'/Util/Components.php';
require_once __ROOT__.'/Util/connectdb.php';
if(!isset($_SESSION)) session_start();
$query = "SELECT COUNT(*) AS total FROM issues WHERE ".
"project_id = (SELECT id FROM project WHERE project = '".$_SESSION['project']."')";
$manager->executeQuery($query);
$row1 = $manager->getStateHandle()->fetch(PDO::FETCH_ASSOC);
$total_bugs = $row1['total'];

$query = "SELECT COUNT(*) AS open FROM issues WHERE is_resolved = 1 AND ".
"project_id = (SELECT id FROM project WHERE project = '".$_SESSION['project'] ."')";
$manager->executeQuery($query);
$row2 = $manager->getStateHandle()->fetch(PDO::FETCH_ASSOC);
$open_bugs = $row2['open'];

$query = "SELECT COUNT(*) AS user_total FROM issues WHERE ".
		"project_id = (SELECT id FROM project WHERE project = ? AND creator = (SELECT id FROM user where name = ?))";
$arguments = array($_SESSION['project'], $_SESSION['username']);
$manager->executeQuery($query, $arguments);
$row1 = $manager->getStateHandle()->fetch(PDO::FETCH_ASSOC);
$user_total_bugs = $row1['user_total'];

// $HeaderType = 1;   // This value is used in case of header type selection in header.php
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Amber | The all new Notepad</title>
		<meta charset="UTF-16">
		<link href="./css/bootstrap.min.css" rel="stylesheet" >
		<link href="./css/font-awesome.min.css" rel="stylesheet" >
		<link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
		<link href='https://fonts.googleapis.com/css?family=Open+Sans:300,600' rel='stylesheet' type='text/css'>
		<style type="text/css">
		body, html {
		    background-color: #FDFDFD;
		    font-family: 'Open Sans', sans-serif;
		}div#issue-list {
		    position: relative;
		    overflow: hidden;
		    font-family: sans-serif;
		}.row .col.browser-default {
		    padding: 3px;
		    height: 2em;
		}.issue-item, .alert{
		transition: 2s all ease-in-out;
		}.issue-item:first-child {
		    border-radius: 4px 4px 0 0;
		}.issue-item {
		    background-color: white;
		    border: 1px solid #ccc;
		    border-bottom: 0;
		    padding: 15px;
		}.issue-item:last-child {
		    border-bottom: 1px solid #ccc;
		    border-radius: 0 0 4px 4px;
		}.navbar{
		background-color: #345;
		}.navbar .navbar-brand{
		color: #ccc !important;
		}.panel {
		    font-size: 15px;
		    line-height: 1.6em;
		}.panel .panel-heading{
		    height: 130px;
		    background-color: #2A5279;
		}.panel-profile .panel-title {
		    font-size: 23px;
		    word-break: break-word;
		    letter-spacing: 0.01em;
		    line-height: 1.8em;
		}.panel-title{
			font-weight: bold;
		}.fa {
		    margin-right: 8px;
		}.project-selector{
			text-transform: capitalize;
			cursor: pointer;
		}a:focus, a:hover, a:visited, a:active {
		    outline: none;
		    text-decoration: none;
		}
		</style>
	</head>
	<body>
		<?php require_once __ROOT__.'/Public/header.php';?>
		<div class="container">
			<div class="row">
				<div class="col-md-3">
					<div class="panel panel-default panel-profile">
						<div class="panel-heading"></div>
						<div class="panel-body">
							<div class="panel-title"><?php echo $_SESSION['username']; ?></div>
							<div class="">
								<i class="fa fa-file-text-o"></i>
								Open project:<b> <?php echo $_SESSION['project']; ?></b>
							</div>
							<div class="">
								<i class="fa fa-bug"></i>
								<span><?php echo $total_bugs; ?> issues posted</span>
							</div>
							<div class="">
								<i class="fa fa-check"></i>
								<span><?php echo $open_bugs; ?> issues resolved</span>
							</div>
						</div>
					</div>
					<div class="panel panel-default">
						<div class="panel-body">
							<div class="panel-title">Stats</div>
							<div>
								<b><?php echo $user_total_bugs; ?></b>
								 issues posted by you
							</div>
						</div>
					</div>
					<div class="panel panel-default">
						<div class="panel-body">
							<div class="panel-title">Available project</div>
							<?php 
							$queryForProjectName = "SELECT * FROM project WHERE active = 1";
							$manager->executeQuery($queryForProjectName);
							while($row = $manager->getStateHandle()->fetch(PDO::FETCH_ASSOC)){
								echo "<div><i class='fa fa-link'></i>".
										"<span class='project-selector' data-target='".$row['id']."'>".
											"<a tabindex='0' data-toggle='popover' data-trigger='manual' title='".$row['project']."' data-content=''>".
										$row['project']."</a></span>".
								"</div>";
							}
							?>
						</div>
					</div>
				</div>
				<div class='col-md-6'>
					<div id="issue-list">
						<div class="issue-item col-md-12">
							<h3>Issues</h3>
						</div>
						<div class="issue-item col-md-12">
							<span><i class="fa fa-filter"></i>Filter: </span>
							<div class="btn-group bay">
							  	<button class="btn btn-default btn-sm dropdown-toggle" type="button" id="sorting-bay" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
							    	Sort by:<b> Date</b>
							    	<span class="caret"></span>
							  	</button>
							  	<ul class="dropdown-menu" aria-labelledby="sorting-bay">
							    	<li><a data-value='severity' data-family='sort'>Severity</a></li>
							    	<li><a data-value='date' data-family='sort'>Date</a></li>
								</ul>
							</div>
							<div class="btn-group bay">
							  	<button class="btn btn-default btn-sm dropdown-toggle" type="button" id="display-bay" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
							    	Show from:<b> Open</b>
							    	<span class="caret"></span>
							  	</button>
							  	<ul class="dropdown-menu" aria-labelledby="display-bay">
							    	<li><a data-value='all' data-family='display'>All</a></li>
							    	<li><a data-value='resolved' data-family='display'>Resolved</a></li>
							    	<li><a data-value='open' data-family='display'>Open</a></li>
								</ul>
							</div>
						</div>
						<?php 
							$query = "SELECT id, title, tags FROM issues WHERE is_resolved = 0 AND ".
							"project_id = (SELECT id FROM project WHERE project = '".$_SESSION['project']."') ".
							"ORDER BY ID DESC";
							$manager->executeQuery($query);
							$component = new Components($_SESSION['project'], $_SESSION['username']);
							while ($row = $manager->getStateHandle()->fetch(PDO::FETCH_ASSOC)){
								$component->printIssueBox($row);
							}
							?>
					</div>
				</div>
			</div>
		</div>
		<div class="modal fade" id="issueModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content" id="issue-detail">
				</div>
			</div>
		</div>
		<script src="./js/util/jquery-2.2.1.min.js"></script>
		<script src="./js/bootstrap.min.js" type="text/javascript" ></script>
		<script src="./js/util/io.js"></script>
		<script src="./js/home.js"></script>
	</body>
</html>