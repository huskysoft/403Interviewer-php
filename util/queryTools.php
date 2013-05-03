<?php
	/*
	* This script contains functions to execute a PostgreSQL query and process
	* response values response in JSON format
	*/
	require('db_credentials.php');
	require('db_tables.php');
	
	function connect() {
		// connect to DB
		$sslmode = "require";
		$options = "'--client_encoding=UTF8'";
		$con = pg_connect("host=$host dbname=$db port=$port user=$user 
			password=$pass sslmode=$sslmode options=$options")
			or die('Could not connect: ' . pg_last_error());
	}


	function executeQuery($query) {
		connect();
		$rs = pg_query($con, $query) 
			or die("Invaid query: $query\n");
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