<?php
	/*
	* This script retrieves the userId for a given email. If the email is
	* not found in the database, then a new table entry is created and the
	* id of the new user is echoed
	*/
	require('../util/requestParams.php');
	require('../util/queryTools.php');
	require('../util/db_tables.php');
	require('../util/security.php');

	// fetch POST body
	$email = filter_var(file_get_contents('php://input'), FILTER_SANITIZE_EMAIL);
	
	// check for existing userId
	$userId = getUserId($email);
	
	if ($userId >= 0) {
		// user exists; return the ID
		echo $userId;
	} else {
		// user does not exist; create a new ID
		if ($email) {
			// build new query to insert new user into the table
			$newUserQuery = $INSERT . $TABLE_USER . $VALUES;
			$newUserQuery .= ("(DEFAULT, 0, '" . $email . "') RETURNING ");
			$newUserQuery .= ("\"" . $COLUMN_USER_USERID . "\"");

			// execute query and return ID
			$rs = executeQuery($newUserQuery);
			echo pg_fetch_result($rs, 0, 0);
		}
	}
?>