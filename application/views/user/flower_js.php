<?php //$this->load->view('site_js')?>
<script>
	var cursor =  $(".more").attr("id");
	var link =  '<?php echo current_url() ?>';
	// function getFollowers(cursor){
		// var url = BASE+"user/my_followers?cursor="+cursor+"&more=1";
		// $.get(url,function(data,status){
			// console.log(status);
			// if (status=='success'){	
				// return data;
			// }
			//return false;
		// });		
	// }
	
	$(".more").click(function(){		
		$("#loading").show();
		$(this).hide();
		var url = link+"?cursor="+cursor+"&more=1";
		$.get(url,function(data,status){
			console.log(status);
			if (status=='success'){	
				$("#loading").hide();
				$("#more"+cursor).remove();
				$("#flowersul").append(data);
			}
			//return false;
		});		
	 });
	 
	$(".thumb-cont .flow img").each(function(i) {			
		var Id = $(this).attr("id");
		//console.log(Id);
		$(this).bind("load", function() {			
			$('#flow'+Id).fadeIn();
		});
	});
</script>