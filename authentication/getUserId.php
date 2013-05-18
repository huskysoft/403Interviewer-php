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
	
       secureConnection();
	
       // parse GET parameter
       $email = filter_var($_GET[$PARAM_EMAIL], FILTER_SANITIZE_STRING);

       $query = $SELECT . "\"" . $COLUMN_USER_USERID . "\"" . $FROM .
		$TABLE_USER . $WHERE . "\"" . $PARAM_EMAIL . "\"=" . "'" . $email . "'";
       $rs = executeQuery($query);
       
	$totalRows = pg_num_rows($rs);
	// If email wasn't already in the database, then issue new query inserting
	// it into the database
       if ($totalRows < 1) {
		if ($email) {
			// build new query to insert new user into the table
			$newUserQuery = $INSERT . $TABLE_USER . $VALUES;
              	$newUserQuery .= ("(DEFAULT, 0, '" . $email . "') RETURNING ");
			$newUserQuery .= ("\"" . $COLUMN_USER_USERID . "\"");

			// execute query and return ID
			$rs = executeQuery($newUserQuery);
		}
	}

	$userId = pg_fetch_result($rs, 0, 0);
	echo $userId;
?>