<?php
	/*
	* This script handles postQuestion requests. Requires user authentication.
	* Returns the ID of the newly-created Question.
	*/
	
	// require secure connection
	if (!isset($_SERVER['HTTPS']) || !$_SERVER['HTTPS']) {
		$url = 'https://' . $_SERVER['HTTP_HOST']
						  . $_SERVER['REQUEST_URI'];
		header('Location: ' . $url);
		exit;
	}

	// load dependencies
	require('../util/requestParams.php');
	require('../util/db_tables.php');	
	require('../util/queryTools.php');
	
	// parse JSON payload

	
	// build query
	INSERT INTO users (name, age) VALUES ('Liszt', 10) RETURNING id;
	$query = "INSERT INTO " . $TABLE_QUESTION;
	$query = $query . "(" $columns . ")";
	$query = $query . " VALUES ";
	$query = $query . "(" $values . ")";
	$query = $query . " RETURNING \"" . $COLUMN_QUESTION_QUESTIONID . "\"";
	
	// execute query and return ID
	echo executeQuery($query);
?>