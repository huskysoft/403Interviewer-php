<?php
	/*
	* This script handles postQuestion requests. Requires user authentication.
	* Returns the ID of the newly-created Question.
	*/
	
	// require secure connection
	if (!isset($_SERVER['HTTPS']) || !$_SERVER['HTTPS']) {
		header("HTTP/1.1 301 Moved Permanently");
		exit("Secure connection required");
	}

	// load dependencies
	require('../util/requestParams.php');
	require('../util/db_tables.php');	
	require('../util/queryTools.php');
	
	$json = json_decode(file_get_contents('php://input'));
	
	// parse JSON payload
	$authorId = filter_var($json->$COLUMN_QUESTION_AUTHORID, FILTER_SANITIZE_NUMBER_INT);
	$questionText = "'" . filter_var($json->$COLUMN_QUESTION_TEXT, FILTER_SANITIZE_STRING) . "'";
	$questionTitle = "'" . filter_var($json->$COLUMN_QUESTION_TITLE, FILTER_SANITIZE_STRING) . "'";
	$questionDifficulty = "'" . filter_var($json->$COLUMN_QUESTION_DIFFICULTY, FILTER_SANITIZE_STRING) . "'";
	$questionCategory = "'" . filter_var($json->$COLUMN_QUESTION_CATEGORY, FILTER_SANITIZE_STRING) . "'";
	$dateCreated = filter_var($json->$COLUMN_QUESTION_DATE, FILTER_SANITIZE_NUMBER_INT);
		
	// build query
	$query = "INSERT INTO " . $TABLE_QUESTION . " VALUES ";
	$query .= ("(DEFAULT, " . $authorId . ", " . $questionText . ", " . $questionTitle);
	$query .= (", 0, 0, " . $questionDifficulty . ", " . $questionCategory);
	$query .= (", " . $dateCreated . ")");
	$query .= (" RETURNING '" . $COLUMN_QUESTION_QUESTIONID . "'");
	
	// execute query and return ID
	echo executeQuery($query);
?>