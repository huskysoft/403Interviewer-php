<?php
	/*
       * Any utility functions or variables relating to security for InterviewAnnihilator
       * PHP scripts
       */
// require secure connection
function secureConnection() {
	if (!isset($_SERVER['HTTPS']) || !$_SERVER['HTTPS']) {
		$url = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
		header('Location: ' . $url);
		exit("Secure connection required");
	}
}