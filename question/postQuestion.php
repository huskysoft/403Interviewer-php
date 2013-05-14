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
		exit("Secure connection required");
	}

	// load dependencies
	require('../util/requestParams.php');
	require('../util/db_tables.php');	
	require('../util/queryTools.php');
	
	// parse JSON payload
	$authorId = $_POST[$COLUMN_QUESTION_AUTHORID];
	$questionText = $_POST[$COLUMN_QUESTION_TEXT];
	$questionTitle = $_POST[$COLUMN_QUESTION_TITLE];
	$questionDifficulty = $_POST[$COLUMN_QUESTION_DIFFICULTY];
	$questionCategory = $_POST[$COLUMN_QUESTION_CATEGORY];
	$dateCreated = $_POST[$COLUMN_QUESTION_DATE];
		
	// build query
	$query = "INSERT INTO " . $TABLE_QUESTION . " VALUES ";
	$query .= ("(DEFAULT, " . $authorId . ", " . $questionText . ", " . $questionTitle);
	$query .= (", 0, 0, " . $questionDifficulty . ", " . $questionCategory);
	$query .= (", " . $dateCreated . ")");
	$query .= ($query . " RETURNING \"" . $COLUMN_QUESTION_QUESTIONID . "\"");
	
	// execute query and return ID
	echo executeQuery($query);
?>