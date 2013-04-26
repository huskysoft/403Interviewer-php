<?php
	// Auto-update script for use with a GitHub Service Hook.
	// DO NOT MODIFY
	
	// perform the pull
	`git pull upstream master -f`;
	$message = `git log -1 --pretty=format:'%h | %s [%an]'`;

	// log the update
	$file = fopen("gitlog.txt", "a");
	fwrite($file, strftime('%c') . " | ");
	fwrite($file, $message);
	fwrite($file, "\n");
	fclose($file);	
?>