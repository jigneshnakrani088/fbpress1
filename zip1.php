<?php
//error_reporting(0);
require_once 'lib/facebook/facebook.php';
$facebook = new facebook(array(						 //	JigsApp								demo
	'appId'  => '1523273831269396',   				 // 815325925197979  					1523273831269396
	'secret' => '05e1d394341cb408eda496cd4d174a4f',  // e6dcecf8b128ca7dcbd5b2a3797c0661   	05e1d394341cb408eda496cd4d174a4f
    'cookie'    => true,
));


if(isset($_REQUEST['album_id'])&&isset($_REQUEST['user_id']))
{
	$response = array();
	$zip_name = $_REQUEST['user_id'];
	$zip_name=basename(str_replace(' ', '_', $zip_name));
	$zip_name = "./$zip_name.zip";
	$zip = new ZipArchive;
	$a_id=$_REQUEST['album_id'];	

	if ($zip->open($zip_name,ZipArchive::CREATE) === TRUE){
		try{
			$a = $facebook->api("/{$a_id}");
			$a_name=$a['name'];
		}catch(Exception $e){
		}	
		
		if($zip->addEmptyDir($a_name)) {
			$params = $_POST['source'];
			foreach($params as $photo)
			{
				try{
					$tmp=rand(11,10000) .".jpeg";
					$str = file_get_contents($photo);
					$zip->addFromString("$a_name/$tmp", $str);
				}catch(Exception $ex){ 
					
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