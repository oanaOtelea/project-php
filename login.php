<?php
require 'User.php';

$userModel = new User();


if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
  	$response = $userModel->login($_POST['email'], $_POST['password']);
  	echo json_encode($response);
}