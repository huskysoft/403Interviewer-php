<?php
	/*
	* This script handles getQuestions requests. Requests can be filtered by
	* by difficulty and/or category. Pagination is supported.
	*/
	require('../util/requestParams.php');
	require('../util/db_tables.php');
	require('../util/queryTools.php');
	
	// parse filtering parameters
	if (isset($_GET[$COLUMN_QUESTION_DIFFICULTY])) {
		$where = " WHERE \"". $COLUMN_QUESTION_DIFFICULTY . "\"=" .
			filter_var($_GET[$PARAM_DIFFICULTY], FILTER_SANITIZE_NUMBER_INT);
	} else {
		$where = "";
	}
	
	// parse pagination parameters
	$limit = (isset($_GET[$PARAM_LIMIT])) ? 
		filter_var($_GET[$PARAM_LIMIT], FILTER_SANITIZE_NUMBER_INT) : "ALL";
	$offset = (isset($_GET[$PARAM_OFFSET])) ?
		filter_var($_GET[$PARAM_OFFSET], FILTER_SANITIZE_NUMBER_INT) : "0"; 	
	
	// build query
	$query = "SELECT * FROM " . $TABLE_QUESTION;
	$query = $query . $where;
	$query = $query . " LIMIT " . $limit;
	$query = $query . " OFFSET " . $offset;
	
	// execute query and return JSON
	$rs = executeQuery($query);
	$json = convertToJSON($rs);
	echo $json;
?>