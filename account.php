<?php 
include 'User.php';

if ( $_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['updateForm'])) {
	$userModel = new User();
	$userDetails = $userModel->findById($_SESSION['id'], 'registered');
    $status = "";

        if (!empty($_POST['email'])) {
    		if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
      			$status .= "Please enter a valid email adress!";
      			$email = $userDetails->email;
    		} else {
      			$email = $_POST['email'];
      		}
  		} else {
    		$email = $userDetails->email;
 		}

  		if (!empty($_POST['password'])) {
    		if (strlen($_POST['password']) < 5) {
      			$status .= "Your password must be at least 5 characters.";
      			$password = $userDetails->password;
    		} elseif ($_POST['confirm_password'] != $_POST['password']) {
      			$status .= "Your passwords mismatch";
      			$password = $userDetails->password;
    		} else {
      			$password = $_POST['password'];
    		}
 	 	} else {
    		$password = $userDetails->password;
  		}

  		if (!empty($_POST['name'])) {
    		$name = $_POST['name'];
  		} else {
    		$name = $userDetails->name;
  		}

  		if (!empty($_POST['bdaytime'])) {
    		$bdaytime = $_POST['bdaytime'];
  		} else {
    		$bdaytime = $userDetails->bdaytime;
  		}

  		if (!empty($_POST['sex'])) {
    		$sex = $_POST['sex'];
  		} else {
    		$sex = $userDetails->sex;
  		}

  		
		if ($email != null && $password != null && $sex != null) {
			$update = $userModel->update($email, $password, $name, $bdaytime, $sex);
			$status .= "Details have succesfully updated!";
		}
}


include 'account.phtml';