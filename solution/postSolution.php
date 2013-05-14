<?php
	/*
	* This script handles postSolution requests. Requires user authentication.
	* Returns the ID of the newly-created Solution.
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
	$questionId = filter_var($_POST[$COLUMN_SOLUTION_QUESTIONID], FILTER_SANITIZE_NUMBER_INT);
	$authorId = filter_var($_POST[$COLUMN_SOLUTION_AUTHORID], FILTER_SANITIZE_NUMBER_INT);
	$solutionText = filter_var($_POST[$COLUMN_SOLUTION_TEXT], FILTER_SANITIZE_STRING);
	$dateCreated = filter_var($_POST[$COLUMN_SOLUTION_DATE], FILTER_SANITIZE_NUMBER_INT);
		
	// build query
	$query = "INSERT INTO " . $TABLE_SOLUTION . " VALUES ";
	$query .= ("(DEFAULT, " . $questionId . ", " . $authorId . ", ")
	$query .= ("'$solutionText'" . ", " . $dateCreated . ", " . "0, 0)");
	$query .= (" RETURNING \"" . $COLUMN_SOLUTION_SOLUTIONID . "\"");
	
	// execute query and return ID
	echo executeQuery($query);
?>