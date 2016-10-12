<?php
require 'DB.php';

$db = new DB;

if (!$db ) {
	die("Database Connection Failed" . mysql_error());
}

require 'second.php';