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
	$zip_name = $_POST['user_id'];
	$zip_name=basename(str_replace(' ', '_', $zip_name));
	$zip_name = "$zip_name.zip";
	$a_id=$_REQUEST['album_id'];
	
	$zip = new ZipArchive;
	if ($zip->open($zip_name,ZipArchive::CREATE) === TRUE){

	$a_name=$_REQUEST['a_name'];
		if($zip->addEmptyDir($a_name)) {
			
			try{
				$photos = $facebook->api("/{$a_id}/photos");
			}catch(Exception $e){
			}
			
			$photo = '';
			$tmpn=1;
			foreach($photos['data'] as $photo)
			{
					try{
					$tmp=$tmpn++.".jpeg";
					$str = file_get_contents($photo['source']);
					$zip->addFromString("$a_name/$tmp", $str);
					}catch(Exception $e){ 
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
