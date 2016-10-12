<?php 

class DB {
	
	private $_config = array(
		'username' => 'root',
		'password' => '0743',
		'database' => 'users'
	);

	public $connectionErr = false;
	protected $connection = null;

	public function __construct() {
		$this->connect($this->_config);
	}

	public function connect($config) 
	{
		try {
			$conn = new PDO('mysql:host=localhost;dbname=' . $config['database'], 
							$config['username'], 
							$config['password']);
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$this->connection = $conn;
		} catch(Exception $e) {
			$this->connectionErr = $e->getMessage();
		}
	}	

	public function insertRow($tableName, $post_values, $values, $fields) {
		
		$query = "INSERT INTO $tableName(`" . implode('`, `', $post_values) . "`) VALUES({$values})";
		
		try {
			$stmt = $this->connection->prepare($query);
			$stmt->execute($fields);
		} catch(PDOException $e) {
			throw new Exception($e->getMessage());
		}
		
	}

	public function substring_index($subject, $delim, $count) 
	{
		    if($count < 0){
		        return implode($delim, array_slice(explode($delim, $subject), $count));
		    }else{
		        return implode($delim, array_slice(explode($delim, $subject), 0, $count));
		    }
		}
	
	public function findOneByFilters($filters, $table)
	{
		$sql = '';

		foreach ($filters as $field => $value) {
			$sql .= $field . ' = ' . "'" . $value . "'" . ' and ';
		}
					
		$query = "SELECT * FROM $table WHERE {$sql}";
		$result = $this->substring_index($query, ' and', count($filters));	
		
        try { 
           	$stmt = $this->connection->prepare($result); 
            $stmt->execute($filters); 
            $row = $stmt->fetch(PDO::FETCH_OBJ);
        } catch(PDOException $e) {
            throw new Exception($e->getMessage());
        }
        return $row;
	}

	public function updateRow($tableName, $filters, $id) {
		$sql = '';
		
		foreach ($filters as $field => $value) {
			$sql .= $field . ' = ' . "'" . $value . "'" . ', ';
		}

		$query = " UPDATE $tableName SET {$sql}";
		$result = $this->substring_index($query, ',', count($filters));
		$result .= " WHERE id=" . '"' . $id . '"';
	
		try { 
           	$stmt = $this->connection->prepare($result); 
            $stmt->execute($filters); 
        } catch(PDOException $e) {
            throw new Exception($e->getMessage());
        }
        
	}

	public function userInUse($user, $table) {
      $sql = "SELECT id FROM $table WHERE email='$user' OR name='$user'";
          try
          {
              $stmt = $this->connection->prepare($sql);
              $stmt->execute();
              $row = $stmt->fetch(PDO::FETCH_OBJ);
          }
          catch(PDOException $e)
          {
              throw new Exception($e->getMessage());
          }
          return $row;
  	}

  	public function findById($id, $table) {
  		$query = "SELECT * FROM $table WHERE id='$id'";
  		try
          {
              $stmt = $this->connection->prepare($query);
              $stmt->execute();
              $row = $stmt->fetch(PDO::FETCH_OBJ);
          }
          catch(PDOException $e)
          {
              throw new Exception($e->getMessage());
          }
          return $row;
  	}
	
}