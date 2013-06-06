<?php
	/*
	* This script contains functions and constants to execute a PostgreSQL
	* queries and process response values
	*/
	
	$SELECT_ALL = "SELECT *";
	$SELECT_COUNT = "SELECT COUNT(*)";
	$SELECT = "SELECT ";
	$DELETE = "DELETE ";
	$FROM = " FROM ";
	$WHERE = " WHERE ";
	$AND = " AND ";
	$UPDATE = "UPDATE ";
	$SET = " SET ";
	$TRUE = "true";
	$FALSE = "false";
       $DEFAULT_LANGUAGE = "EN";
	$INSERT = "INSERT INTO ";
	$VALUES = " VALUES ";
	$ORDER_BY_DATE = " ORDER BY \"dateCreated\" DESC, \"questionId\" DESC";
	$ORDER_BY_RANDOM = " ORDER BY random()";
	$RETURNING = " RETURNING ";
	
	function getLimitOffsetQuery($limit, $offset) {
		return " LIMIT " . $limit . " OFFSET " . $offset;
	}

	function executeQuery($query) {
		// connect to DB		
		require('db_credentials.php');
		$sslmode = "require";
		$options = "'--client_encoding=UTF8'";
		$con = pg_connect("host=$host dbname=$db port=$port user=$user 
			password=$pass sslmode=$sslmode options=$options")
			or die('Could not connect: ' . pg_last_error());
			
		// execute query
		$rs = pg_query($con, $query);
		if ($rs) {
			return $rs;
		} else {
			header("HTTP/1.1 400 Bad Request");
			exit("Invalid query: $query\n");
		}
	}

	function convertToJSON($rs) {	
		// parse results
		$rows = array();
		while($r = pg_fetch_assoc($rs)) {
			$rows[] = $r;
		}		
		// convert to JSON
		$json = json_encode($rows);
		return $json;
	}
	
	function getUserId($email) {
		require('requestParams.php');
		require('db_tables.php');
		global $SELECT;
		global $FROM;
		global $WHERE;
		
		$query = $SELECT . "\"" . $COLUMN_USER_USERID . "\"" . $FROM .
		$TABLE_USER . $WHERE . "\"" . $PARAM_EMAIL . "\"=" . "'" . $email . "'";
		$rs = executeQuery($query);

		$totalRows = pg_num_rows($rs);
		// if user was not found, return -1
		if ($totalRows == 1) {
			return pg_fetch_result($rs, 0, 0);
		} else {
			return -1;
		}
	}
	
	function appendWhereClause($where, $newClause) {
		global $WHERE;
		global $AND;
		if (strlen($where) == 0) {
			$where .= $WHERE;
		} else {
			$where .= $AND;
		}
		return $where . $newClause;
	}
?>