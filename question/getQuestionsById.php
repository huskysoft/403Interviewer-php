<?php
	/*
	* This script handles getQuestions requests for retrieving questions
	* when the id of the question is known
	*/
	require('../util/requestParams.php');
	require('../util/db_tables.php');
	require('../util/queryTools.php');	
	
	$questionIds = filter_var($_GET[$PARAM_QUESTIONID], FILTER_SANITIZE_STRING);
	$questionIdArr = explode($CATEGORY_DELIM, $questionIds);
	$where .= $WHERE;
	$where .= "(";
	$appendOr = false;
	foreach ($questionIdArr as $newId) {
		if ($appendOr) {
			$where .= " OR ";
		}
		$appendOr = true;
		$where .= ("\"" . $COLUMN_QUESTION_QUESTIONID . "\"=" . $newId);
	}
	$where .= ")";

	// build the query to send to the database
	$query = $SELECT_ALL . $FROM . $TABLE_QUESTION . $where;
	$rs = executeQuery($query);
	$jsonResults = convertToJSON($rs);

	// return the results of the query
	echo $jsonResults;
?>