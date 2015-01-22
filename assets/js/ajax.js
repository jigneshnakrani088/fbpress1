function loadAlbum(response) {
	alert('ff');
	$('#main').show();
}


function CheckForm(){
	var selectedcheckbox = [];
	$.each($("input[name='checkalbum[]']:checked"), function(){            
		selectedcheckbox.push($(this).val());
	});
	if (selectedcheckbox.length === 0) {
  		alert('Yada yada yada, some error message');
		return false;
	}
	return selectedcheckbox;
}
function zipAlbum(album_id)
{
	var divid=[];
	divid.push(album_id);
	zipit(divid);
}

function moveAlbum(album_id)
{
	var divid=[];
	divid.push(album_id);
	moveit(divid);
}

function moveit(respoce){
	$.each( responce, function( index, value ){
			var data = {'album_id': value,	}
			$.ajax({
				url : 'prepare_move.php?album_id=' + album_id + '&move=true',
				type : 'get',
				success : function(data) {
					location.href = "picasamove.php?album_id=" + album_id;
				},
				error : function(data) {
					alert('Error Occure on server,Please Try again')
				}
			});	
}

function zipit(responce){
	if ( responce != false ){
		$('#progress-bar').show();
		var n=Math.round(100/responce.length);
		$('#link').hide();
		
		if(responce.length !==1) { $('.progress-bar').width(1).text(1);}
		else { $('.progress-bar').width(11).text(11);}
		
		var val=0;
		$.post('zip_selected.php', null , function(){
			if(true){
			 $.each( responce, function( index, value ){
					var data = {
						'album_id': value,
					}
				$.post('zip1.php',data, function(response){
						 
							if ( responce.length-1 == index ){
								val=val+n;
								$('.progress-bar').width(val + '%').text(val + '%');
								setTimeout(function(){  $('#progress-bar').hide();}, 1000);
								$('#link').show();
								var res = jQuery.parseJSON(response);
								$("#link").html("<a href='"+res.url+"'>click here..</a>");
							}else{
								val=val+n;
								 $('.progress-bar').width(val + '%').text(val + '%');
							}
				})
			});
		 }
		});										
	}
}

$( document ).ready(function() {
		$('#download_selected').click(function(){
								responce = CheckForm();
								zipit(responce);
						   })
		$('#move_selected').click(function(){
								responce = CheckForm();
								alert(responce);
						   })
	
		$('#logout_button').click(function(){  top.location.href="lib/logout.php"; } )
		
		$('#lnk a').click(function(){ $('#link').hide(); } )
		
		$('#download_all').click(function(){
		
				var allcheckbox = [];
				$.each($("input[name='checkalbum[]']"), function(){            
					allcheckbox.push($(this).val());
				});
				zipit(allcheckbox);
			})
	
		$('#move_all').click(function(){
		
				var allcheckbox = [];
				$.each($("input[name='checkalbum[]']"), function(){            
					allcheckbox.push($(this).val());
				});
				alert(allcheckbox);
			})
});