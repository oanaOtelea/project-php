<?php 
require 'Message.php';
$Message = new Message();

$conversation = $Message->getOneConversation($_SESSION['id'], $_GET['id']);

	
require 'conversation.phtml';