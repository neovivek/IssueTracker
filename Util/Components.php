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
		$tags = explode(",", $row["tags"]);
		echo '	<div class="issue-header col-m12">
					<div class="issue-id col-m4">
						<a href="/issue/'.$row["id"].'">ISSUE '.$row["id"].'  </a>
					</div>
					<div class="issue-tag col-m8">';
		if(count($tags) > 0){
			echo '<ul class="pager left">';
			for($i=0; $i<count($tags); $i++){
				echo '<li><a>'.$tags[$i].'</a></li>';
			}
			echo '</ul>';
		}
		echo '		</div>
				</div>
				<div class="issue-body col-s12">
					'.$row["title"].'
				</div>';
	}
	public function printIssueBox($row){
		echo '<div class="bs-callout bs-callout-warning col-m12">';
		$this->printBox($row);
		echo '	<div class="issue-footer col-s12">
					<a href="javascript: void();" class="issue-close" data-target="'.$row["id"].'">Close Issues</a>
				</div>
			</div>';
	}
	public function printResolvedBox($row){
		echo '<div class="bs-callout bs-callout-warning col-m12">';
		$this->printBox($row);
		echo '	<div class="issue-footer col-s12">
					<a href="javascript: void();" class="issue-open" data-target="'.$row["id"].'">Reopen Issues</a>
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
		if ($this->sessionSet == 0)	session_start();
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