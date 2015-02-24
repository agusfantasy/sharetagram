<div class="search">
	<h2> Search Instagram online</h2>

    <div class="row">
        <p>
            Finding what’s interesting for you is made easy with our Instagram search engine
            digging into both tags and usernames for any keywords entered.
        </p>
    </div>

    <div class="row">
        <div class="col-md-8">
	        <input class="form-control" maxlength="20" type="text"  id="keyword2" name="keyword" value="<?php echo isset($value)?$value:'';?>" onkeypress="return pressEnter(event)">
        </div>
        <div class="col-md-4">
            <input class="btn btn-primary" type="submit" name="submit" id="search-input" value="Search hashtags or users">
        </div>
    </div>

	<h4>You will also see:</h4>
	<ul>
		<li>Similar usernames</li>
		<li>Similar hashtags and how much content for each.</li>
	</ul>
</div>
<script>
	$("#search-input").on("click",function(){		
		var keyword2 = $("#keyword2").val();
		if ( keyword2!="" ){	
			var fCar = keyword2.substr(0,1); 
			if(  fCar == '#' ||  fCar == '@' ) { 
				keyword2 =  keyword2.replace(fCar,'');
			}
			location.assign(BASE+"search/"+keyword2);
		}
		return false;	
	});
	
	function pressEnter(e) {
        if (e.keyCode == 13){
			$("#search-input").click();
        }
    }
</script>