

	window.fbAsyncInit = function() {
		FB.init({
			appId   : '490590447735463',
			oauth   : true,
			status  : true, // check login status
			cookie  : true, // enable cookies to allow the server to access the session
			xfbml   : true // parse XFBML
		});  
	};



	function fb_login(){
		$("#loading").show();
		FB.login(function(response) {
			if (response.authResponse) {
				console.log('Welcome!  Fetching your information.... ');
				//console.log(response); // dump complete info
				access_token = response.authResponse.accessToken; //get access token
				user_id = response.authResponse.userID; //get FB UID
				
				FB.api('/me', function(response) {
					user_email = response.email; //get user email
					// you can store this data into your database 
					var url = '<?php echo base_url()?>register/fb_connect?js=1'; 
					$.get(url,function(data,status){
						if(status=="success"){	
							$("#loading").hide();
							window.location = '<?php echo base_url()?>register/form';
						}
					});
				});
			} else {
				//user hit cancel button
				console.log('User cancelled login or did not fully authorize.');
			}
		}, {
			scope: 'publish_stream,email'
		});
	}

	(function() {
		var e = document.createElement('script');
		e.src = document.location.protocol + '//connect.facebook.net/en_US/all.js';
		e.async = true;
		document.getElementById('fb-root').appendChild(e);
	}());	
	
	function fbAutoPost(){
		//var body = 'Reading JS SDK documentation';
		FB.api('/me/feed', 'post', {
			message: '<?php echo $fb_name ?> telah mendaftar Toyota Etios Amazing Drive. Ayo Ikutan!',
			link : 'http://bit.ly/PGF27S'			
		}, function(response) {
		  if (!response || response.error) {
			alert('Error autopost facebook occured');
		  } else {
			//alert('Post ID: ' + response.id);
			return TRUE;
		  }
		});
	}


