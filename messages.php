<?php
require 'Message.php';

if ( $_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['messageForm']) ) {
	$messageModel = new Message();

		$body = $_POST['body']; 
		$user_id_send = $_SESSION['id'];
		$id_receive = $messageModel->userInUse($_POST['sendTo'], 'registered');
		$user_id_receive = $id_receive->id;
		
	$messageModel->insertMessage(array('user_id_receive' => $user_id_receive, 'user_id_send' => $user_id_send, 'body' => $body, 'sentTime' => date('Y-m-d H-i-s')));	
	
}



require 'messages.phtml';