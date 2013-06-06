<?php
	/*
	* This script handles postQuestion requests. Requires user authentication.
	* Returns the ID of the newly-created Question.
	*/

	// load dependencies
	require('../util/security.php');
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
	$language = filter_var($json->$COLUMN_QUESTION_LANGUAGE, FILTER_SANITIZE_STRING);
		
	// build query
	$query = $INSERT . $TABLE_QUESTION . $VALUES;
	$query .= ("(DEFAULT, " . $authorId . ", " . $questionText . ", " . $questionTitle);
	$query .= (", 0, 0, " . $questionDifficulty . ", " . $questionCategory);
	$query .= (", " . $dateCreated . ", " . $language . ")");
	$query .= (" RETURNING \"" . $COLUMN_QUESTION_QUESTIONID . "\"");
	
	// execute query and return ID
	$rs = executeQuery($query);
	echo pg_fetch_result($rs, 0, 0);
?>