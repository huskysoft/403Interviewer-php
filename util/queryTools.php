<?php
	/*
	* This script contains functions and constants to execute a PostgreSQL
	* queries and process response values
	*/
	
	$SELECT_ALL = "SELECT *";
	$SELECT_COUNT = "SELECT COUNT(*)";
	$FROM = " FROM ";
	$ORDER_BY_DATE = " ORDER BY \"dateCreated\" DESC, \"questionId\" DESC";
	$ORDER_BY_RANDOM = " ORDER BY random()";
	
	function getLimitOffsetQuery($limit, $offset) {
		return " LIMIT " . $limit . " OFFSET " . $offset;
	}

	function executeQuery($query) {
		// connect to DB		
		require('db_credentials.php');
		$sslmode = "require";
		$options = "'--client_encoding=UTF8'";
		$con = pg_connect("host=$host dbname=$db port=$port user=$user 
			password=$pass sslmode=$sslmode options=$options")
			or die('Could not connect: ' . pg_last_error());
			
		// execute query
		$rs = pg_query($con, $query) 
			or die("Invalid query: $query\n");
		return $rs;
	}
	

	function convertToJSON($rs) {	
		// parse results
		$rows = array();
		while($r = pg_fetch_assoc($rs)) {
			$rows[] = $r;
		}		
		// convert to JSON
		$json = json_encode($rows);
		return $json;
	}
?>