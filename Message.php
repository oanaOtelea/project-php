<?php
require 'DB.php';
session_start();

class Message extends DB {
	private $_tableName = 'messages';

	public function insertMessage($fields) {

		$this->insertRow($this->_tableName, array_keys($fields), ':user_id_receive, :user_id_send, :body, :sentTime', $fields);
		
	}

	public function getConversations($nr) {
		$query = "SELECT usr.id, usr.name FROM `messages` as `msg` inner join registered as `usr` on (msg.user_id_send = usr.id and usr.id != $nr) or (msg.user_id_receive = usr.id and usr.id != $nr) where msg.user_id_send = $nr or msg.user_id_receive = $nr group by usr.id";
		try 
		{
			$stmt = $this->connection->prepare($query); 
        	$stmt->execute(); 	
        	$row = $stmt->fetchAll(PDO::FETCH_OBJ);
        	
		}
		catch(PDOException $e)
        {
            throw new Exception($e->getMessage());
        } 
        return $row;
	}

	public function getOneConversation($userInUse, $userInConversation) {
		$query = "SELECT user_id_send, body, sentTime FROM `messages` WHERE user_id_send = $userInUse and user_id_receive = $userInConversation or user_id_send = $userInConversation and user_id_receive = $userInUse order by sentTime DESC";
		try 
		{
			$stmt = $this->connection->prepare($query); 
        	$stmt->execute(); 	
        	$row = $stmt->fetchAll(PDO::FETCH_OBJ);
		}
		catch(PDOException $e)
        {
            throw new Exception($e->getMessage());
        } 
        return $row;
	}
	
}