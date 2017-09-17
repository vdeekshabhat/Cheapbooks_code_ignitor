<body>
	<div class="panel panel-default col-md-4" style="position: fixed; top: 30%; left: 30%;">
	<div class="panel-body">
		<h3 style="text-align:center;">Login</h3><br>
		<form action="Login.php" method="post">
	  		<div><input class="form-control" type="text" id="username" placeholder="Username" required autofocus></div>
	  		<div><input class="form-control" type="password" id="password" placeholder="Password" required></div>
	  		<br/>
	  		<div>
	  			<button type="button" class="btn btn-primary col-md-6" id="btnSend">Login</button>
	  			<button class="btn btn-primary col-md-6" name="Register_Here" onclick="document.location.href='index.php/Page4'">Register Here</button>
	  	</div>

  		</form>
  	</div>
  	</div>
  </body>
<!-- <input type="text" id="username" />
<input type="text" id="password" /> -->


<script type="text/javascript">
/*		function send() {
			var message = document.getElementById("#message");
					console.log(message);
		}*/
	$(document).ready(function() {
			$("#btnSend").click(function() {
					var username = $("#username").val();
    				var password = $("#password").val();
					$.ajax({
						url: '<?php echo site_url('cheapbook/CheckLogin'); ?>',
	        type: 'POST',
	        dataType: "json",
	        data: {
	            'username': username,
	            'password': password
	        },
	        success: function(response) {
	        	if(response=="true"){
	        	window.location="index.php/Page2";
	        	}
	        	else{
	        		$("#username").val("");
	        		$("#password").val("");
	        		alert("Incorrect username and password!!!")

	        	}

	        }
					});
			});
	});
</script>