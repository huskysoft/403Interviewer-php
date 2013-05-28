<?php
	/*
	This script votes on a question in the database. We validate that the voting
	is happening from a user of our app with an email address.
	*/

	require('../util/requestParams.php');
	require('../util/queryTools.php');
	require('../util/db_tables.php');
	require('../util/security.php');

	// fetch vars
	$questionId = filter_var($_GET[$PARAM_QUESTIONID], FILTER_SANITIZE_NUMBER_INT);
	$vote = filter_var($_GET[$PARAM_VOTE, FILTER_SANITIZE_STRING);
	$email = filter_var(file_get_contents('php://input'), FILTER_SANITIZE_EMAIL);

	// determine whether it is a like or a dislike
	$vote = strtolower(trim($vote));
	$changeColumn = "";
	if ($vote == $TRUE) {
		$changeColumn = $COLUMN_QUESTION_LIKES;
	}
	else if ($vote == $FALSE) {
		$changeColumn = $COLUMN_QUESTION_DISLIKES;
	}

	if ($changeColumn) {
		// check for existing userId
		$userId = getUserId($email);
		if ($userId < 0) {
			header("HTTP/1.1 401 Unauthorized");
			exit("User not found");
		}

		// prepare query
		$query = $UPDATE . $TABLE_QUESTION . $SET;
		$query .= ("\"" . $changeColumn . "\"= " . "\"";
		$query .= ($changeColumn . "\" + 1" . $WHERE . "\"" . $PARAM_QUESTIONID);
		$query .= ("\"=" . $questionId . $RETURNING . "\"" . $PARAM_QUESTIONID . "\"");

		$rs = executeQuery($query);
		if ($rs) {
			echo pg_fetch_result($rs, 0, 0);
		}
		else {
			echo "-1";
		}
	}
	else {
		echo "-1";
	}
?>