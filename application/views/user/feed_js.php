<script>	var tag = $("a.more").attr("rel");
	var maxId =  $("a.more").attr("id");	
	$("a.more").click(function(){
		$(this).hide(5,function(){
			$("#loading").hide();
		});		var url = BASE+"user/feed/?more=1&max_id="+maxId;
		$.get(url,function(data,status){
			//alert(status);
			$("#loading").show('fast',function(){
				$("#more"+maxId).remove();
				$("#tagsul").append(data);
			});
		});
	});
	
</script>
