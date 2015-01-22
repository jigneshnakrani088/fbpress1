<?php
error_reporting(0);
if(isset($_REQUEST['album_id']) && isset($_REQUEST['user_id']))
{
	$response = array();
	$zip_name = $_REQUEST['user_id'];
	$zip_name=basename(str_replace(' ', '_', $zip_name));
	$zip_name = "$zip_name.zip";
	$zip = new ZipArchive;
	if ($zip->open($zip_name,ZipArchive::CREATE) === TRUE){
		$a_id=$_REQUEST['album_id'];
		if($zip->addEmptyDir($a_id)) {
		 	$photos =$_REQUEST['source'];
			foreach($photos as $photo)
			{
				try{
					$tmp=rand(11,10000) .".jpeg";
					$str = file_get_contents($photo);
					$zip->addFromString("$a_id/$tmp", $str) ;
				}catch(Exception $ex){ 
					echo $ex;
				}			
			}
			$response['album_id'] = $a_id;
			$response['status'] = true;
			$response['url'] = $zip_name;
			$zip->close();
			echo json_encode($response);
		}
	}
}
?>