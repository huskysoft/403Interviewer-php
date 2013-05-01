<?php
	/*
	* This script executes a PostgreSQL query stored in $query and prints the 
	* response in JSON format
	*/
	require('db_credentials.php');
	require('db_tables.php');

	// connect to DB
	$sslmode = "require";
	$options = "'--client_encoding=UTF8'";
	$con = pg_connect("host=$host dbname=$db port=$port user=$user 
		password=$pass sslmode=$sslmode options=$options")
		or die('Could not connect: ' . pg_last_error());

	// execute query
	$rs = pg_query($con, $query) 
		or die("Invaid query: $query\n");

	// parse results
	$rows = array();
	while($r = pg_fetch_assoc($rs)) {
		$rows[] = $r;
	}
	
	// convert to JSON
	$json = json_encode($rows);
	echo $json;

	// clean up
	pg_close($con);
?>