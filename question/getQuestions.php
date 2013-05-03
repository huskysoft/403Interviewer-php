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
	$selectAll = "SELECT *";
	$selectCount = "SELECT COUNT(*)";
	$table = " FROM " . $TABLE_QUESTION;
	$limitOffset = " LIMIT " . $limit . " OFFSET " . $offset;
	
	// get questions and convert to JSON
	$query = $selectAll . $table . $limitOffset;
	$rs = executeQuery($query);
	$jsonResults = convertToJSON($rs);
	
	// get total number of results
	$query = $selectCount . $table;
	$rs = executeQuery($query);
	$totalNum = pg_fetch_result($rs, 0, 0);
	
	$arr = array($PARAM_RESULTS => $jsonResults,
				 $PARAM_TOTAL_NUM_RESULTS => $totalNum,
				 $PARAM_LIMIT => $limit,
				 $PARAM_OFFSET => $offset);
	echo json_encode($arr);
?>