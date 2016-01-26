<?php

if (isset($_GET['file']) === true && $_GET['file'] != '') {

	$file = '/var/www/html/security/dir/open/'.$_GET['file'];
	if ((strpos($_GET['file'], '..') === false) && file_exists($file)) {
		readfile($file);
	} else {
		echo '不正なファイルパスです';exit;
	}	
}
