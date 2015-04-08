function loadAlbum(response){
	$('#main').show();
			 $.each(response.data, function(key, value) {
				FB.api("/"+value.cover_photo +"", function(response){ 
						var src= response.source;		
						var strtmp = '<div id="div' + value.id + '" class="col-md-3 col-sm-6"> ' +
								'<div class="album"> '+
								'<a href="#" class="img'+ value.id +'" > <img src="'+src+'" height="210px" width="100%" />' +
								'<h4 style="margin-bottom:0px">'+ value.name.substring(0, 16).toLowerCase()+'('+value.count+') </h4> </a>' +
								'<input type="checkbox" name="checkalbum[]" value="'+ value.id +'"/>'+
								'<button class="btn btn-primary btn-color" style="margin:10px;padding:0px;" onClick="singleZip('+ value.id +');" ><img src="assets/images/download.jpg" height="30px" /></button>'+
								'<button class="btn btn-primary btn-color" onClick="singleMove('+ value.id +');">Move</button>' +'</div> </div>';					
				
						$('#album_list').append(strtmp);			
						$('.img' + value.id).click(function(event) {
									event.preventDefault();
									slideShow(value.id);
						});
				});
			});			  
}
function slideShow(albumId){	
	FB.api("/"+ albumId +"/photos",function(response){
											var para=new Array();
											$.each(response.data, function(key, value) {para.push(value.source);});
											para=para;
											var form = $('<form action="fatch_photo.php" method="post">' +
											 '<input type="hidden" name="source" value="' + para + '"></input>' + '</form>');
											 $('body').append(form);
											 $(form).submit();
											});
}


function zipit1(responce){
	$('#link').hide();
	$('html, body').animate({ scrollTop: $('#profile_head').offset().top }, 'slow');
	$('#loader').show();
	FB.api('/me', function(user) {
						   	var data1 = {'album_id': user.name,}
						   	
						   	$.post('remove_zip.php', data1 , function(){});
						   			var data = {'zip_name':user.name,
												'album_id': responce, }
								//	alert(JSON.stringify(data));	
							$.post('zip1.php',data, function(response){
															 $('#loader').hide();
										var res = jQuery.parseJSON(response);
										if(res.status!=true){
											alert("Opps Something went wrong sorry..");	
										}else{
											$('#link').show(400);
											var res1 = jQuery.parseJSON(response);
											$('#link').html("<h4><a href='"+ res1.url +"'>click here for download..</a></h4>");
											$('#link').click(function(){$('#link').hide(600);$('#progress-bar').hide();});
										}
										 });
	});
}

function CheckForm(){
	var selectedcheckbox = [];
	$.each($("input[name='checkalbum[]']:checked"), function(){            
		selectedcheckbox.push($(this).val());
		
	});
	if (selectedcheckbox.length === 0) {
  		alert('Aww.. Select Album(s)..');
		return false;
	}
	return selectedcheckbox;
}


function singleZip(albumid){
	var aid=[];
	aid.push(albumid);
	zipit1(aid);
}

function singleMove(albumid){
	$('#loader').show();
	var aid=[];
	aid.push(albumid);
	moveAlbum(aid);
}

function moveAlbum(albumId) {
	$('#loader').show();
	$.ajax({
		url : 'prepare_move.php?album_id=' + albumId + '&move=true',
		type : 'get',
		success : function(data) {
			location.href = "move_picasa.php?album_id=" + albumId;
			$('#loader').hide(200);	
		},
		error : function(data) {
			alert('Opps.. Error Occure on server,Sorry...')
			$('#loader').hide(200);	
		}
	});
}

function moveSelectedAlbum(albumId) {
	$('#loader').show();
	$.ajax({
		url : 'prepare_move.php?album_ids=' + albumId + '&move=true',
		type : 'get',
		success : function(data) {
			location.href = "move_picasa.php?album_ids=" + albumId;
				$('#loader').hide(200);	
		},
		error : function(data) {
			alert('Opps.. Error Occure on server,Sorry...')
			$('#loader').hide(200);	
		}
	});
}

$(document).ready(function() {
		$('#link1').click(function(){ location.href = "index.php"; });
		$('#download_selected').click(function(){
								selectedbox = CheckForm();
								zipit1(selectedbox);
		});
		$('#move_selected').click(function(){
								selectedbox = CheckForm();
								moveSelectedAlbum(selectedbox);			   
		});
	
		$('#logout_button').click(function(){  
							   FB.logout(function(response) {
								$('#main').hide();
								$('#profile_head').hide();
								top.location.href='index.php';
								});		   
		} );
		
//		$('#lnk a').click(function(){ $('#link').hide(); } )
		
		$('#download_all').click(function(){
				var allcheckbox = [];
				$.each($("input[name='checkalbum[]']"), function(){            
					allcheckbox.push($(this).val());
				});
				zipit1(allcheckbox);
			});
	
		$('#move_all').click(function(){
				var allcheckbox = [];
				$.each($("input[name='checkalbum[]']"), function(){            
					allcheckbox.push($(this).val());
				});
				moveSelectedAlbum(allcheckbox);
			});
});