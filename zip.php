<?php
//error_reporting(0);
require_once 'lib/facebook/facebook.php';
$facebook = new facebook(array(						 //	JigsApp								demo
	'appId'  => '815325925197979',   				 // 815325925197979  					1523273831269396
	'secret' => 'e6dcecf8b128ca7dcbd5b2a3797c0661',  // e6dcecf8b128ca7dcbd5b2a3797c0661   	05e1d394341cb408eda496cd4d174a4f
    'cookie'    => true,
));

if(isset($_REQUEST['album_id']))
{
	$response = array();
	$response['status'] = false;
	$zip_name = $_POST['user_id'];
	$zip_name=basename(str_replace(' ', '_', $zip_name));
	$zip_name = "$zip_name.zip";
	$a_id=$_REQUEST['album_id'];
	
	$zip = new ZipArchive;
	if ($zip->open($zip_name,ZipArchive::CREATE) === TRUE){

		try{
			$a = $facebook->api("/{$a_id}");
		}catch(Exception $e){
			$response['status'] = false;
			echo json_encode($response);
			die();
		}
		$a_name=$a['name'];
		if($zip->addEmptyDir($a_name)) {
			
			try{
				$photos = $facebook->api("/{$a_id}/photos");
			}catch(Exception $e){
				$response['status'] = false;
				echo json_encode($response);
				die();
			}
			
			$photo = '';
			foreach($photos['data'] as $photo)
			{
					$tmp=rand(11,10000) .".jpeg";
					$str = file_get_contents($photo['source']);
					$zip->addFromString("$a_name/$tmp", $str) or die ("ERROR: Could not add file from: ".$a_name);
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