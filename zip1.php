<?php
error_reporting(0);
require_once 'lib/facebook/facebook.php';
require_once'remove_dir.php';
$facebook = new facebook(array(						 //	JigsApp								demo
	'appId'  => '815325925197979',   				 // 815325925197979  					1523273831269396
	'secret' => 'e6dcecf8b128ca7dcbd5b2a3797c0661',  // e6dcecf8b128ca7dcbd5b2a3797c0661   	05e1d394341cb408eda496cd4d174a4f
    'cookie'    => true,
));

if(isset($_REQUEST['album_id']))
{
	$response = array();
	
	$zip_name = $_REQUEST['zip_name'];
	$a_id=$_REQUEST['album_id'];
	
	$zip_name=basename(str_replace(' ', '_', $zip_name));
	$zip_name = "$zip_name.zip";
	//$a_name=$_REQUEST['album_name'];
	foreach ($a_id as $a_name)
	{
			$album = $facebook->api("/{$a_name}");
			$album=$album['name'];
			
			$photos = $facebook->api("/{$a_name}/photos");
			$files_to_zip = array();
			foreach($photos['data'] as $photo)
			{
					$files_to_zip[] = $photo["source"];
			}
			prepare_move($files_to_zip, $album);

			createZip($zip_name,$album);	
			
			$remove_dir = new remove_dir();
			$remove_dir->rrmdir($album);	
	}			
			
			$response['status'] = true;
			$response['url'] = $zip_name;
			echo json_encode($response);	
}

function createZip($zip_name,$dir){
	$zip = new ZipArchive;
	if ($zip->open($zip_name,ZipArchive::CREATE) === TRUE)
	{
		$zip -> addEmptyDir($dir); 
        $dh = opendir($dir);
		
		 if (false !== ($handle = opendir($dir))) {
		 	$i=10;
			while (false !== ($file = readdir($handle))) {
				if ($file != '.' && $file != '..') { $i++;
				try{
					$zip -> addFile($dir . DIRECTORY_SEPARATOR . $file, $dir . DIRECTORY_SEPARATOR . $i.'.jpg');
					}
					catch(Exception $ex){
					}
				}
			}
		}
		
        closedir($dh); 
		$zip -> close(); 
	}
}

function moveToDir($a_id) 
{
}
	
function getfile($url, $dir) {
	ini_set('max_execution_time', 300);
	try{
		file_put_contents($dir . substr($url, strrpos($url, '/'), strlen($url)), file_get_contents($url));
	} catch(Exception $ex){ }
}

function prepare_move($files = array(), $a_id) {
	if (file_exists($a_id)){

		$remove_dir = new remove_dir();
		$remove_dir->rrmdir($a_id);	
	}

	mkdir($a_id);
	if (is_array($files)) {
		foreach ($files as $file) {
			getfile($file, $a_id);
		}
	}
}

?>