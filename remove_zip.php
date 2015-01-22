<?php
	error_reporting(0);
	$response['status']=false;
	$zip_name= $_REQUEST['album_id'];
	$zip_name=basename(str_replace(' ', '_', $zip_name));
	$zip_name = "$zip_name.zip";
	if(file_exists ( $zip_name )){
		if(	unlink($zip_name)){
			$response['status']=true;
		}	else{$response['status']=false; }
	}else{ $response['status']=true;
	}
	echo json_encode($response);
?>