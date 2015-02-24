<script>
	// variable media ID
	var userSelfId = '<?php echo $user_self_id; ?>';
	var loading = '<img src="'+BASE+'images/loading40x40.gif">';
	var mediaId="";
	
	function like(mediaId){
		
		if(userSelfId==''){
			alert("You should login");
		}
		else{
			console.log(mediaId);			
			$('#like'+mediaId).removeClass('like-icon').addClass('like-icon-active').css('margin','3px 1px 0 0').attr('onclick','unlike("'+mediaId+'")');
			
			var likeCount = $("#likecount"+mediaId);
			var likeCountTotal =  likeCount.data('total');
			console.log(likeCountTotal);	
			likeCount.text(likeCountTotal+1);			
					
			var url = BASE+"site/post_like";
			
			$.post(url,
			{
				mid : mediaId			
			},
			function(data,status){
				console.log(data);							
				if(status==false){
					alert("failed. Please try again!"); 
					$('#like'+mediaId).removeClass('like-icon-active').addClass('like-icon').attr('onclick','like("'+mediaId+'")');
					likeCount.text(likeCountTotal-1);
					//$( this ).data('act','like-icon');
				}	
				else{		
					return true;
				}
			});	
		}
		
	}
	
	function unlike(mediaId){
		
		if(userSelfId==''){
			alert("You should login");
		}
		else{
			console.log(mediaId);			
			$('#like'+mediaId).removeClass('like-icon-active').addClass('like-icon').css('margin','0 1px').attr('onclick','like("'+mediaId+'")');
			
			var likeCount = $("#likecount"+mediaId);
			var likeCountTotal =  likeCount.data('total');
			console.log(likeCountTotal);	
			likeCount.text(likeCountTotal-1);			
					
			var urlRemove = BASE+"site/remove_like";
			
			$.post(urlRemove,
			{
				mid : mediaId			
			},
			function(data,status){
				console.log(data);							
				if(status==false){
					alert("failed. Please try again!"); 
					$('#like'+mediaId).removeClass('like-icon').addClass('like-icon-active').attr('onclick','unlike("'+mediaId+'")');
					likeCount.text(likeCountTotal+1);
					//$( this ).data('act','like-icon');
				}	
				else{		
					return true;
				}
			});	
		}
		
	}	
</script>
