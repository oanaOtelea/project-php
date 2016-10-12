<?php 
require 'User.php';
$userModel = new User();

if ( $_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['searchForm'])) {
	if (isset($_POST['submit'])) { 
	 	
			$var = $userModel->findBySearch($_POST['name']);	
			
			if (!$var == null) {
	      		
	   		
	      		echo "$var is an user registered here.";
	   		} 
		}
	 else {
		echo 'Please enter a search query.';
	}

}

require 'second.php';