<?php
	/*
	* This script handles getSolutions requests. Pagination is supported.
	*/
	require('../util/requestParams.php');
	require('../util/db_tables.php');
	require('../util/queryTools.php');
	
	// parse questionId
	if (!isset($_GET[$COLUMN_SOLUTION_QUESTIONID])) {
		header(':', true, 400);	// HTTP response code 400: bad request
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
	$selectAll = "SELECT *";
	$selectCount = "SELECT COUNT(*)";
	$table = " FROM " . $TABLE_SOLUTION;
	$limitOffset = " LIMIT " . $limit . " OFFSET " . $offset;
	
	// get solutions and convert to JSON
	$query = $selectAll . $table . $where . $limitOffset;
	$rs = executeQuery($query);
	$jsonResults = convertToJSON($rs);
	
	// get total number of results
	$query = $selectCount . $table . $where;
	$rs = executeQuery($query);
	$totalNum = pg_fetch_result($rs, 0, 0);
	
	// build and return paginatedResults JSON
	$arr = array($PARAM_RESULTS => $jsonResults,
				 $PARAM_TOTAL_NUM_RESULTS => $totalNum,
				 $PARAM_LIMIT => $limit,
				 $PARAM_OFFSET => $offset);
	echo json_encode($arr);
?>