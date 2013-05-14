<?php
	/*
	* This script handles getQuestions requests. Requests can be filtered by
	* by difficulty and/or category. Pagination is supported.
	*/
	require('../util/requestParams.php');
	require('../util/db_tables.php');
	require('../util/queryTools.php');	
	
	$diffSet = false;
	// parse filtering parameters
	if (isset($_GET[$COLUMN_QUESTION_DIFFICULTY])) {
		$diffSet = true;
		$where = " WHERE \"". $COLUMN_QUESTION_DIFFICULTY . "\"=" .
			"'$_GET[$PARAM_DIFFICULTY]'";
	} else {
		$where = "";
	}
	
	if (isset($_GET[$COLUMN_QUESTION_CATEGORY])) {
		$categories = $_GET[$PARAM_CATEGORY];
		$categoryArr = explode($CATEGORY_DELIM, $categories);
		if ($diffSet) {
			$where .= " AND";
		}
		else {
			$where .= " WHERE ";
		}
		$where .= " (";
		$appendOr = false;
		foreach ($categoryArr as $filter) {
			if ($appendOr) {
				$where .= " OR ";
			}
			$appendOr = true;
			$where .= ("\"" . $COLUMN_QUESTION_CATEGORY . "\"=" . "'" . $filter . "'");
		}
		$where .= ")";
	}

	// parse pagination parameters
	$limit = (isset($_GET[$PARAM_LIMIT])) ? 
		filter_var($_GET[$PARAM_LIMIT], FILTER_SANITIZE_NUMBER_INT) : "ALL";
	$offset = (isset($_GET[$PARAM_OFFSET])) ?
		filter_var($_GET[$PARAM_OFFSET], FILTER_SANITIZE_NUMBER_INT) : "0";
	$limitOffsetSQL = getLimitOffsetQuery($limit, $offset);
	
	// get questions and convert to JSON
	$query = $SELECT_ALL . $FROM . $TABLE_QUESTION . $where . $limitOffsetSQL;
	$rs = executeQuery($query);
	$jsonResults = convertToJSON($rs);
	
	// get total number of results
	$query = $SELECT_COUNT . $FROM . $TABLE_QUESTION . $where;
	$rs = executeQuery($query);
	$totalNum = pg_fetch_result($rs, 0, 0);
	
	// build and return paginatedResults JSON
	$arr = array($PARAM_RESULTS => $jsonResults,
				 $PARAM_TOTAL_NUM_RESULTS => $totalNum,
				 $PARAM_LIMIT => $limit,
				 $PARAM_OFFSET => $offset);
	echo json_encode($arr);
?>