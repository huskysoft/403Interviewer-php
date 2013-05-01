<?php
	/*
	* This script handles getQuestions requests. Requests can be filtered by
	* by difficulty and/or category. Pagination is supported.
	*/
	require('../util/requestParams.php');
	require('../util/db_tables.php');
	
	// parse questionId
	if (!isset($_GET[$COLUMN_SOLUTION_QUESTIONID])) {
		echo "Invalid request: no questionId specified";
		exit;
	}
	$where = " WHERE \"". $COLUMN_SOLUTION_QUESTIONID . "\"=" .
		filter_var($_GET[$PARAM_QUESTIONID], FILTER_SANITIZE_NUMBER_INT);
	
	// parse pagination parameters
	$limit = (isset($_GET[$PARAM_LIMIT])) ? 
		filter_var($_GET[$PARAM_LIMIT], FILTER_SANITIZE_NUMBER_INT) : "ALL";
	$offset = (isset($_GET[$PARAM_OFFSET])) ?
		filter_var($_GET[$PARAM_OFFSET], FILTER_SANITIZE_NUMBER_INT) : "0"; 	
	
	// build query
	$query = "SELECT * FROM " . $TABLE_SOLUTION;
	$query = $query . $where;
	$query = $query . " LIMIT " . $limit;
	$query = $query . " OFFSET " . $offset;
	
	// execute query
	include('../util/executeQuery.php');
?>