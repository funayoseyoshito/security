<?php

if (isset($_GET['file']) === true && $_GET['file'] != '') {
	$file = '/var/www/html/security/dir/open/'.$_GET['file'];
	if (file_exists($file)) {
		readfile($file);
	}	
}
