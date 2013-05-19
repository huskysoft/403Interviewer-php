<?php
	// require secure connection
	if (!isset($_SERVER['HTTPS']) || !$_SERVER['HTTPS']) {
		header("HTTP/1.1 301 Moved Permanently");
		exit("Secure connection required");
	}
?>