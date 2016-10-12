<?php 
require 'User.php';

if ( $_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['userForm'])) {
	$user = new User();
	$status = "";
		$email = $_POST['email'];
		$password = $_POST['password'];
		$confirm_password = $_POST['confirm_password'];
		$name = $_POST['name'];
		$bdaytime = $_POST['bdaytime'];
		$sex = $_POST['sex'];

	if (empty($email)) {
		$status .= "Please enter an email adress!";
	} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$status .= "Please enter a valid email adress!";
	} elseif (empty($password)) {
		$status .= "Please enter an password!";
	} elseif (strlen($password) < 5) {
		$status .= "Your password must be at least 5 characters.";
	} elseif ($confirm_password != $password) {
		$status .= "Your passwords mismatch";
	} elseif (!isset($_POST['agree'])) {
		$status .= "You must agree with the terms and conditions if you want to register!";
	} else {
		$user->insertUser(array('email' => $email, 'password' => $password, 'name' => $name, 'bdaytime' => $bdaytime, 'sex' => $sex, 'joined' => date('Y-m-d H-i-s')));	
	}

	
}






require 'register.phtml';