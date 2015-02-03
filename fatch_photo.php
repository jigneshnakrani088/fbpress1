<!DOCTYPE html>
<html lang="en" class="no-js">
	<head>
		<title> Background Slideshow</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />	
	<title>Responsive Web Mobile</title>
	<link rel="stylesheet" href="assets/js/bootstrap/css/bootstrap.min.css" />
	<link rel="stylesheet" href="assets/js/jquery.carousel.fullscreen.js" />
	<style type="text/css">
#top {
		  position: fixed;
		  top: 5px;
		  left: 88%;
		  z-index: 999;
		  width: 150px;
		  height: 23px;
}
</style>

</head>
<body>
	<div id="top">
	<a href="index.php"><h2>CLOSE[X] </h2></a>
	</div>
	<div>
	<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
		<ol class="carousel-indicators">
				 <?php
				 	if(isset($_POST['source']))
					{
							$str =$_POST['source'];
							$ary=explode(",",$str);
							$n=sizeof($ary);
							for($j=0; $j<$n; $j++)
							{
								if($j==0){
									echo '<li data-target="#carousel-example-generic" data-slide-to="'.$j.'" class="active"></li> ';
								}
								else{
								echo ' <li data-target="#carousel-example-generic" data-slide-to="'.$j.'"></li>';
								}
							}
							echo '</ol>
							<div class="carousel-inner" >';
							for($j=0; $j<$n; $j++)
							{
								if($j==0){
									echo '<div class="item active"> <img src="'. $ary[$j] .'"  />	</div>';
								}
								else{
								echo '<div class="item "> <img src="'. $ary[$j] .'" align="center"/>	</div>';
								}
							}
					}else{
						$host  = $_SERVER['HTTP_HOST'];
						$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
						$url= 'http://'.$host.$uri.'/index.php';
						header("Location: $url");
					}
				?>
			</div>

		<a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
			<span class="glyphicon glyphicon-chevron-left"></span>
		</a>
		<a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
			<span class="glyphicon glyphicon-chevron-right"></span>
		</a>

	</div>
	<script src="assets/js/jquery-1.10.0.min.js"></script>
	<script src="assets/js/bootstrap/js/bootstrap.min.js"></script>
	<script src="assets/js/jquery.carousel.fullscreen.js"></script><script>
		$( document ).ready(function(){$('#carousel-example-generic').carousel(); });
	</script>
	</body>
</html>