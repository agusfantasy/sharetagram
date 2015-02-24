<div class="info-container">
    <h1><?php echo $title; ?></h1>
    <h3>Raise your hand, we'll come to you shortly</h3>
    <div style="float:left">
        Thank you for visiting Sharetagram!<br>
        Tell us what you think about Sharetaragram, or if you have any questions, feel free to ask us!<br>
        Send email to us at <a href="mailto:admin@sharetagram.com" target="_top"> admin@sharetagram.com</a> or fill the form below!
        <br/><br/>
        <form id="register" action="<?php echo site_url('contact_post')?>" method="post">
            <!--<label>I am</label><br/>
            <select name="type"  id="type" class="form-control" >
                <option value="customer">Customer</option>
                <option value="brand">Brand</option>
                <option value="agency">Agency</option>
                <option value="investor">Investor</option>
            </select><br/>-->
            <label>Name</label><br/><input type="text" size="30" name="name" id="name" class="form-control"  value="<?php echo isset($name)?$name:""?>" required><br/>
            <label>Email</label><br/><input type="email" size="30" name="email" id="email"  class="form-control"  value="<?php echo isset($email)?$email:""?>" required><br/>
            <label>Message</label><br/><textarea name="message" rows="4" class="form-control" id="message"  required><?php echo isset($message)?$message:""?></textarea><br/>
            <button class="btn btn-primary">Submit </button>
        </form><br>
        <div id="info"></div>
    </div>
    <div style="float:right">
        <?php //echo $desc; ?>
    </div>
</div>
<script>
	$("#register").validate();
	$("#register").submit(function( event ) {
		//alert( "Handler for .submit() called." );
		$.ajax({
			url: BASE+'contact_post',
			error: function() {
				$('#info').html('<p>An error has occurred</p>');
			},
			data:{
				type: $( "#type" ).val(),				
				name: $( "#name" ).val(),
				email: $( "#email" ).val(),
				message: $( "#message" ).val()			
			},			
			success: function(res) {
				if(res=='fail'){
					$('#info').addClass('alert alert-error').html(res);	
				}else{
					$('#info').addClass('alert alert-success').html(res);	
				}							
			},
			type: 'POST'
		});
		event.preventDefault();
	});
</script>