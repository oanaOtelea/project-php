<?php
require 'Message.php';

$Message = new Message();

$allMessages = $Message->getConversations($_SESSION['id']);




require 'archive.phtml';