<style>
.breadcrumb:before{font-size:18px;}
#welcome .welcome-data {padding-top: 15px;}
#welcome-head {margin-bottom: 20px;}
#welcome-head .col.orange-text {padding: 5px 17px;}
#welcome-body {overflow: hidden;}
#welcome-name {position: absolute;background-color: #424242;transition: 0.3s all ease-in-out;z-index:1;}
#welcome-name .title, #welcome-project .title {font-weight: bold;color:#949494;font-size: 18px; padding: 0 5px;}
#welcome-body .special {color: cyan;font-weight: bold;font-size: 36px;font-family: sans-serif;padding: 0 36px 0 11px;}
.fa-mobile{	font-size: 13em; margin: 0% 29%; color:white;}
.fa-chevron-circle-right{cursor:pointer;}
#project-suggestion{position: absolute;right: 13%;color: white;top: 56px;cursor:pointer;}
#project-suggestion-container {display:none;background: rgb(66, 66, 66);position: absolute;width: 453px;top: 244px;margin: 0 33px;max-height: 300px;}
li.suggestion {padding: 8px 20px;font-size: 32px;color: #ccc;border-bottom: 1px solid #ccc;cursor:pointer;}
#welcome-error-container {position: absolute;width: 450px;margin: 0 28px;top: 131px;}
</style>

<div id="welcome" class="container">
	<div class="col-sm-7" style="margin-bottom:0px;float:none;margin:auto;">
		<div class="col-sm-3 left welcome-logo teal darken-2">
			<i class="fa fa-mobile"></i>
		</div>
		<div class="col-sm-9 right welcome-data grey darken-3">
			<div class="row">
				<div id="welcome-head" class="col-sm-12">
					<div class="col-sm-12 orange-text text-darken-2 truncate">
						<kbd><a class="breadcrumb">Name</a></kbd>
					</div>
				</div>
				<div id="welcome-body" class="col-sm-12">
					<form method="POST" action="" style="position:relative;">
						<div id="welcome-name" class="col-sm-12">
							<span class="title">Enter Your Name</span>
							<div class="input-field col-sm-10">
								<input type="text" name="name" id="welcome-user-name" class="special" />
							</div>
							<div class="input-field col-sm-1 right">
								<i class="red-text text-darken-1 fa fa-chevron-circle-right fa-3x"></i>
							</div>
						</div>
						<div id="welcome-project" class="col-sm-12">
							<span class="title">Enter Your Project Name</span>
							<div class="input-field col-sm-10">
								<input type="text" name="project" id="welcome-project-name" class="special" />
							</div>
							<i class="fa fa-angle-down fa-2x" id="project-suggestion"></i>
							<div class="input-field col-sm-1 right">
								<i class="red-text text-darken-1 fa fa-chevron-circle-right fa-3x"></i>
							</div>
						</div>
					</form>
				</div>
				<div id="welcome-error-container" class="truncate red-text text-darken-2"></div>
				<?php 
					require_once '/Util/connectdb.php';
					$query = "SELECT * FROM project WHERE active='1' ";
					$manager->executeQuery($query);
					echo "<ul id='project-suggestion-container'>";
					while($row = $manager->getStateHandle()->fetch(PDO::FETCH_ASSOC)){
						echo "<li class='suggestion' name='1'>".$row['project']."</li>";
					}
					echo "</ul>";
				?>
			</div>
		</div>
	</div>
</div>