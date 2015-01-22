<!DOCTYPE html>
<html lang="en">
<head>
  <title>FaceBook Challenge</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
	<div style="clear:both; margin-top:10px;">
		<br />
	</div>

	<div class="container"  style="background-color:rgba(157, 172, 181, 0.4);" align="center">
		<div class="row border-top-radius row border-bottom-radius" style="padding:18px 0px 18px 0px;">
			<div class="col-md-12 col-sm-12">
				<?php
session_start();

require_once 'Zend/Loader.php';
Zend_Loader::loadClass('Zend_Gdata_Photos');
Zend_Loader::loadClass('Zend_Gdata_ClientLogin');
Zend_Loader::loadClass('Zend_Gdata_AuthSub');

$gp = new Zend_Gdata_Photos(getAuthSubHttpClient(), "Google-DevelopersGuide-1.0");
$entry = new Zend_Gdata_Photos_AlbumEntry();


if ( isset( $_GET['album_id'] ) ) 
{
	$album_id = $_GET['album_id'];
	
	if ( file_exists( $album_id ) ) 
	{
				add_new_album( $entry, $gp, $album_id, $album_id );
				rrmdir($album_id);
				$response = 1;
	}else
	{
			$response = 0;
	}
} else if (isset($_GET['albumids'])) 
{
	$album_ids = explode(",", $_GET['albumids']);
	foreach ($albumids as $album_id) 
	{
			if ( file_exists( $album_id ) ) 
			{
				add_new_album($entry, $gp, $album_id, $album_id);
				rrmdir($album_id);
				$response = 1;
			}
	}
}
else
{
	$response = 0;
}
echo '<script > document.location.href="index.php?r='.$response.'"; </script>';

//---------------------------------------------------------------------------------------------
function getAuthSubUrl()
{
    $next = getCurrentUrl(); 
    $scope = 'https://picasaweb.google.com/data';
    $secure = false;
    $session = true;
    return Zend_Gdata_AuthSub::getAuthSubTokenUri($next, $scope, $secure,
        $session);
}

function getAuthSubHttpClient()
{
    if (!isset($_SESSION['sessionToken']) && !isset($_GET['token']) ){
		echo '<h2>Need to login your google..</h2>';
        echo '<a href="' . getAuthSubUrl() . '"><img src="assets/images/google.png" alt="Login to picasa.!"/></a>';
        exit;
    } else if (!isset($_SESSION['sessionToken']) && isset($_GET['token'])) {
        $_SESSION['sessionToken'] =
            Zend_Gdata_AuthSub::getAuthSubSessionToken($_GET['token']);
    }
    $client = Zend_Gdata_AuthSub::getHttpClient($_SESSION['sessionToken']);
    return $client;
}

/*function getAuthSubHttpClient() {
	if ( isset( $_SESSION['google_session_token'] ) ) {
		$client = Zend_Gdata_AuthSub::getHttpClient( $_SESSION['google_session_token'] );
		return $client;
	}
}
*/
function getCurrentUrl() {
	global $_SERVER;
	$php_request_uri = htmlentities(substr($_SERVER['REQUEST_URI'], 0, strcspn($_SERVER['REQUEST_URI'], "\n\r")), ENT_QUOTES);

	if (isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) == 'on') {
		$protocol = 'https://';
	} else {
		$protocol = 'http://';
	}
	$host = $_SERVER['HTTP_HOST'];
	if ($_SERVER['SERVER_PORT'] != '' && (($protocol == 'http://' && $_SERVER['SERVER_PORT'] != '80') || ($protocol == 'https://' && $_SERVER['SERVER_PORT'] != '443'))) {
		$port = ':' . $_SERVER['SERVER_PORT'];
	} else {
		$port = '';
	}
	return $protocol . $host . $port . $php_request_uri;
}

function add_new_album( $entry, $gp, $album_id, $album_name ) {
//	$new_album_name = str_replace( " ", "_", $album_name );
	$new_album_name = $album_name.'_'.uniqid();
	$entry->setTitle( $gp->newTitle( $new_album_name ) );
	$entry->setSummary( $gp->newSummary("Album added by FbPress") );
	$gp->insertAlbumEntry( $entry );

	$path = $album_id;
	if ( file_exists( $path ) ) {
		$photos = scandir( $path );
		foreach ( $photos as $photo ) {
			if ( $photo != "." && $photo != ".." ) {
				$photo_path = $path.'/'.$photo;
				add_new_photo_to_album( $gp, $photo_path, $new_album_name );
			}
		}
	}	
}

function add_new_photo_to_album( $gp, $path, $new_album_name ) {
	$user_name = "default";
	$file_name = $path;
	$photo_name = rand(11,99999);
	$photo_caption = "FbPress";
	$photo_tags = "Facebook Album";
	$fd = $gp->newMediaFileSource( $file_name );
	$fd->setContentType("image/jpeg");
	// Create a PhotoEntry
	$photo_entry = $gp->newPhotoEntry();
	$photo_entry->setMediaSource( $fd );
	$photo_entry->setTitle( $gp->newTitle( $photo_name ) );
	$photo_entry->setSummary( $gp->newSummary( $photo_caption ) );
	$photo_media = new Zend_Gdata_Media_Extension_MediaKeywords();
	$photo_media->setText( $photo_tags );
	$photo_entry->mediaGroup = new Zend_Gdata_Media_Extension_MediaGroup();
	$photo_entry->mediaGroup->keywords = $photo_media;
	$album_query = $gp->newAlbumQuery();
	$album_query->setUser( $user_name );
	$album_query->setAlbumName( $new_album_name );
	$gp->insertPhotoEntry( $photo_entry, $album_query->getQueryUrl() );
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

?>
			</div>
		</div>
	</div>
</body>
</html>