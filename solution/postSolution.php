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
	$questionId = $_POST[$COLUMN_SOLUTION_QUESTIONID];
	$authorId = $_POST[$COLUMN_SOLUTION_AUTHORID];
	$solutionText = $_POST[$COLUMN_SOLUTION_TEXT];
	$dateCreated = $_POST[$COLUMN_SOLUTION_DATE];
		
	// build query
	$query = "INSERT INTO " . $TABLE_SOLUTION . " VALUES ";
	$query .= ("(DEFAULT, " . $questionId . ", " . $authorId . ", ")
	$query .= ("'$solutionText'" . ", " . $dateCreated . ", " . "0, 0)");
	$query .= (" RETURNING \"" . $COLUMN_SOLUTION_SOLUTIONID . "\"");
	
	// execute query and return ID
	echo executeQuery($query);
?>