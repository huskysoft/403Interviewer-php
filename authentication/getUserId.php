<?php
	/*
	* This script retrieves the userId for a given email. If the email is
       * not found in the database, then a new table entry is created and the
       * id of the new user is echoed
	*/
	require('../util/requestParams.php');
	require('../util/queryTools.php');
       require('../util/security.php');	
	
       secureConnection();
	
	// parse parameters
	if (isset($_GET[$PARAM_EMAIL])) {
		$where = " WHERE \"". $COLUMN_QUESTION_DIFFICULTY . "\"=" .
			"'" . filter_var($_GET[$PARAM_DIFFICULTY], FILTER_SANITIZE_STRING)
				. "'";
	} else {
		$where = "";
	}
?>