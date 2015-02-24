<!--<script src="<?php echo base_url()?>assets/js/jquery-2.1.0.js" type="text/javascript"></script>-->
<script>
	//var BASE = '<?php echo base_url(); ?>';
	var userID = '<?php echo $user_id; ?>';
	var maxId =  $(".more").attr("id");	
	var uri2 = '<?php echo $this->uri->segment(2); ?>';
	if (uri2=='feed'){
		var url = BASE+"user/feed/?max_id="+maxId+"&more=1";
	}
	else{
		var url = BASE+"user/recent/?user_id="+userID+"&max_id="+maxId+"&more=1";
	}
	
	$(".more").click(function(){
		//alert("click");
		$(this).text("Loading...");
		//$("#loading").show();
		$.get(url,function(data,status){
			if(status=='success'){
				//alert(status);				
				//$("#loading").hide();
				$("#more"+maxId).remove();
				$("#tagsul").append(data);
			}			
		});
	});
	
	$(".thumb-cont .img .rec-mg img").each(function(i) {			
		var Id = $(this).attr("id");
		//console.log(Id);
		$(this).bind("load", function() {			
			$('#rec-mg'+Id).fadeIn();
		});
	});
	
</script>