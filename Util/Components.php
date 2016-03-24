<?php

class Components{
	private $project;
	private $user;
	private $sessionSet;
	
	function __construct($project, $user="Guest"){
		$this->setCurrentProject($project);
		$this->setUser($user);
	}
	protected function printBox($row){
		$tags = explode("-", $row["tags"]);
		echo '	<div class="issue-header col-md-12">
					<span class="issue-id">
						<a href="javascript: findDetails('.$row["id"].')">ISSUE '.$row["id"].'  </a>
					</span>
					<div class="issue-tag col-md-8">';
		if(count($tags) > 0){
			echo '<ul class="pager">';
			for($i=0; $i<count($tags); $i++){
				echo '<li><a>'.$tags[$i].'</a></li>';
			}
			echo '</ul>';
		}
		echo '		</div>
				</div>
				<div class="truncate">
					'.$row["title"].'
				</div>';
	}
	public function printIssueBox($row){
		echo '<div class="issue-item col-md-12" id="iss-'.$row['id'].'">';
		$this->printBox($row);
		echo '	<div class="issue-footer">
					<a href="javascript: resolved(\''.$row["id"].'\');" class="issue-close" data-target="'.$row["id"].'">Close Issue</a>
				</div>
			</div>';
	}
	public function printResolvedBox($row){
		echo '<div class="issue-item col-md-12" id="iss-'.$row['id'].'">';
		$this->printBox($row);
		echo '	<div class="issue-footer">
					<a href="javascript: reopen(\''.$row["id"].'\');" class="issue-open" data-target="'.$row["id"].'">Reopen Issue</a>
				</div>
			</div>';
	}
	public function getCurrentProject(){
		return $this->project;
	}
	public function setCurrentProject($projectName){
		$this->project = $projectName;
		$this->setSession('project', $this->project);
	}
	public function setUser($userName){
		$this->user = $userName;
		$this->setSession('username', $this->user);
	}
	public function getUser(){
		return $this->user;
	}
	public final function setSession($name, $value="NULL"){
		if(!isset($_SESSION)) session_start();
		if($value == "NULL"){
			$this->sessionSet -= 2;
			unset($_SESSION[$name]);
		}
		$_SESSION[$name] = $value;
		$this->sessionSet ++;
		return true;
	}
	public final function unsetSession($name){
		$this->setSession($name);
		return true;
	}
	public final function closeSession(){
		session_unset();
		session_destroy();
		$this->sessionSet = 0;
	}
}