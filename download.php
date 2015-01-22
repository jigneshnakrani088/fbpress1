<?php

		$zip_name= $_REQUEST['filename'];
		$zip_name=basename(str_replace(' ', '_', $zip_name));
		$zip_name = $zip_name.".zip";
		header('Content-disposition: attachment; filename='.$zip_name);
		header('Content-type: application/zip');
//		header('Content-Length: ' . filesize($zip_name));
		readfile($filename);
?>