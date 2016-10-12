<?php
require 'DB.php';
session_start();

class User extends DB {
    private $_tableName = 'registered';
    const LOGIN_VALIDATE_ERROR = "no user exists.";
	
    public function insertUser($fields) {

		    $this->insertRow($this->_tableName, array_keys($fields), ':email, :password, :name, :bdaytime, :sex, :joined', $fields);
		
    }

    public function login($email, $password) {
        $return = array('success' => true);
        $user = $this->findOneByFilters(array('email' => $email, 'password' => $password), $this->_tableName);
    
  		if ($user == false) {
        $return['success'] = false;
        $return['message'] = self::LOGIN_VALIDATE_ERROR;
      } else {
          $_SESSION['email'] = $user->email;
          $_SESSION['id'] = $user->id;
      }
      return $return;
    }
  	
    public function update($email, $password, $name, $bdaytime, $sex) {

        $this->updateRow($this->_tableName, array('email' => $email, 'password' => $password, 'name' => $name, 'bdaytime' => $bdaytime, 'sex' => $sex), $_SESSION['id']);

    }

    public function findBySearch($name) {

      $query = "SELECT  name FROM $this->_tableName WHERE name LIKE '$name'";
    
        try { 
            $stmt = $this->connection->prepare($query); 
            $stmt->execute(); 
            $row = $stmt->fetch(PDO::FETCH_OBJ);
            if ($row == null) {
              echo 'No username with this name is registered.';
            } else {
              echo 'This is a registered user.';
            }
        } catch(PDOException $e) {
            throw new Exception($e->getMessage());
        }
        return $row;
    }

}