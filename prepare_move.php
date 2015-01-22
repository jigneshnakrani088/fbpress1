<?php
$reponse = array();
require_once 'lib/facebook/facebook.php';
$facebook = new facebook(array(						 //	JigsApp								demo
	'appId'  => '815325925197979',   				 // 815325925197979  					1523273831269396
	'secret' => 'e6dcecf8b128ca7dcbd5b2a3797c0661',  // e6dcecf8b128ca7dcbd5b2a3797c0661   	05e1d394341cb408eda496cd4d174a4f
    'cookie'    => true,
));

if (isset($_GET["album_id"])) 
{
		$album_id=$_REQUEST['album_id'];
		$photos = $facebook->api("/{$album_id}/photos");
		$files_to_zip = array();
		foreach($photos['data'] as $photo)
		{
				$files_to_zip[] = $photo["source"];
		}
		prepare_move($files_to_zip, $album_id);
		$reponse["status"] = 1;
		echo json_encode($reponse);

} else if (isset($_GET['album_ids'])) 
{

		$album_ids = explode(",", $_GET['album_ids']);
		foreach ($album_ids as $album_id) 
		{
			$photos = $facebook->api("/{$album_id}/photos");
			$files_to_zip = array();
			foreach($photos['data'] as $photo)
			{
					$files_to_zip[] = $photo["source"];
			}
					
			prepare_move($files_to_zip, $album_id);
			$reponse["status"] = 1;
			echo json_encode($reponse);
		}
}

function rrmdir($dir) {
	if (is_dir($dir)) {
		$objects = scandir($dir);
		foreach ($objects as $object) {
			if ($object != "." && $object != "..") {
				if (filetype($dir . "/" . $object) == "dir")
					rrmdir($dir . "/" . $object);
				else
					unlink($dir . "/" . $object);
			}
		}
		reset($objects);
		rmdir($dir);
	}
}
function getfile($url, $dir) {
	ini_set('max_execution_time', 300);
	try{
		file_put_contents($dir . substr($url, strrpos($url, '/'), strlen($url)), file_get_contents($url));
	} catch(Exception $ex){ }
}

function prepare_move($files = array(), $album_id) {
	if (file_exists($album_id)){
		rrmdir($album_id);	}

	mkdir($album_id);
	if (is_array($files)) {
		foreach ($files as $file) {
			getfile($file, $album_id);
		}
	}
}

?>