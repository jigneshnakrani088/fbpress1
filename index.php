<!DOCTYPE html>
<html lang="en">
<head>
  <title>FaceBook Challenge</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="assets/css/style.css">
  <script src="assets/js/script.js"></script>
</head>

<body>
	                <script>
                    function statusChangeCallback(response) {
                        console.log('statusChangeCallback');
                        console.log(response);
                        if (response.status === 'connected') {
                            testAPI();
                        } else if (response.status === 'not_authorized') {
                            document.getElementById('status').innerHTML = 'Please log ' + 'into this app.';
                        } else {
                            document.getElementById('status').innerHTML = 'Please log ' +
                            'into Facebook.';
                        }
                    }

                    function checkLoginState() {
                        FB.getLoginStatus(function(response) {
                            statusChangeCallback(response);
                        });
                    }

                    window.fbAsyncInit = function() {
                        FB.init({							 //demo					jigsApp
                            appId      : '1523273831269396', //1523273831269396    815325925197979
                            cookie     : true,  
                            xfbml      : true,  
                            version    : 'v2.1' 
                        });

                        FB.getLoginStatus(function(response) {
                            statusChangeCallback(response);
                        });

                    };

                    (function(d, s, id) {
                        var js, fjs = d.getElementsByTagName(s)[0];
                        if (d.getElementById(id)) return;
                        js = d.createElement(s); js.id = id;
                        js.src = "//connect.facebook.net/en_US/sdk.js";
                        fjs.parentNode.insertBefore(js, fjs);
                    }(document, 'script', 'facebook-jssdk'));

                    function testAPI() {
                        console.log('Welcome!  Fetching your information.... ');
                        FB.api('/me', function(response) {
                            console.log('Successful login for: ' + response.name);
                            document.getElementById('status').innerHTML =
                                'Thanks for logging in, ' + response.name + '!';
							$('#profile_head').show(500);
							$('#profile_pic').html("<img src='http://graph.facebook.com/"+response.id +"/picture??fields=picture&type=large' class='image'/>");
							$('#user_title').html(" <h2>Wel-come <em> "+response.name +"</em>, Here is your albums...</h2> ");
                            $('#status').hide(500);
							$('#chksts').hide();
							FB.api('/me/albums',loadAlbum);
                        });
                    }
                </script>


	<div style="clear:both; margin-top:10px;">
		<br />
	</div>

	<div class="container" id="content" style="background-color:rgba(157, 172, 181, 0.4);" align="center">
		<div id="status">
		</div>
		<div class="row border-top-radius" id="profile_head" style="padding:18px 0px 18px 0px; display:none;">
			<div class="col-md-2 col-sm-2" id="profile_pic">
			</div>		
			<div class="col-md-8 col-sm-8" id="user_title"> 
			</div>					
			<div class="col-md-2 col-sm-2 btn-group-vertical">
				<button class="btn btn-primary btn-lg " id="logout_button">	LogOut </button>
				<button class="btn btn-primary btn-lg " id="download_all">	Download All </button>
				<button class="btn btn-primary btn-lg " id="move_all">		Move All </button>
			</div>
		</div>
		
		<div class="row"  style="margin:5px;">
			<hr style="margin:5px -10px 5px -10px;border-top: 11px solid #B1B2AF;"/>
		</div>
		
		<?php if(isset($_GET['r']) ){
		?>
			<div id="link1" style="cursor: pointer; background-color:rgba(100,100,100,0.3);margin:0px -5px 0px -5px; padding:2px 10px 0px 10px; border:5px solid;">
		<?php
		if($_GET['r']==0)
		{ ?>
			<h4>opps something went wrong... </h4>
		<?php } 
		else if($_GET['r']==1)  
		{
		?>			
			<h4>album moved succefully... </h4>
		<?php } ?>
			</div>
		<?php } ?>

		<div id="link" style="background-color:rgba(100,100,100,0.3);margin:0px -5px 0px -5px; padding:2px 10px 0px 10px; border:5px solid;display:none;">
		</div>
		<div id="progress-bar" style="margin:0px -5px 0px -5px; padding:2px 10px 0px 10px; border:5px solid;display:none;">
			<div id="link">
			</div>			
			<strong>Preparing your album(s)...</strong>
			<div class="progress progress-striped active" style="margin-bottom:15px">
				<div class="progress-bar progress-bar-info"  role="progressbar" aria-valuenow="100" aria-valuemin="1" aria-valuemax="100" style="width: 1%">
				
				</div>
			</div>
		</div>

		<div class="row" id="main" style="display:none;">		
			<div class="row" id="album_list" style="margin:0px;">
			
			</div>
			<div class="row"  style="margin:5px;">
				<hr style="margin:5px 0px 10px 0px;border-top: 11px solid #B1B2AF;"/>
			</div>					
			<div class="row  border-bottom-radius">
				<div class="col-md-2 col-sm-2" style="clear:both; margin-bottom:10px;">	</div>
				<div class="col-md-4 col-sm-4" style="margin-bottom:10px;">
					<button class="btn-lg btn-primary" type="submit" id='download_selected'>Download selected albums</button>
				</div>
				<div class="col-md-4 col-sm-4" style="margin-bottom:10px;">
					<button class="btn-lg btn-primary"  id='move_selected' >Move selected albums</button>		
				</div>
				<div class="col-md-2 col-sm-2"><br/></div>
			</div>
		</div>
		
		
        <fb:login-button scope="public_profile,email,user_friends,user_photos " onlogin="checkLoginState();" id="chksts">
        </fb:login-button>
	</div>  
	<div  id="loader" style="position:fixed; top:0px; left:0px; background-color:rgba(100,100,100,0.3); height:100%; width:100%; display:none;" >
	<div  style=" position:absolute; top:40%; left:40%; ">
		<img src="assets/images/ajax-loader.gif" style=" top:33%; left:33%; width:200px; " />
		</div>	
	</div>
		<div style="clear:both; margin-bottom:10px;">
		</div>
</body>
</html>