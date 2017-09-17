
   <nav class="navbar navbar-inverse">
      <div class="container-fluid">

        <div class="navbar-form navbar-right">
            <button class="btn btn-primary" onclick="logout()">Log Out</button>
        </div>
      </div>
  </nav> 
  <body>
  		<div class="panel panel-default col-md-4" style="position: fixed; top: 30%; left: 30%;">
			<div class="panel-body">
				<h3 style="text-align:center;">New User</h3><br>
				<form  method="post">
  					<div><input class="form-control" type="text" id="username" placeholder="Username" required></div>
  					<div><input class="form-control" type="password" id="password" placeholder="Password" required></div>
  					<div><input class="form-control" type="email" id="email" placeholder="Email" required></div>
  					<div><input class="form-control" type="tel" id="phone" placeholder="Phone" required></div>
					<div><input class="form-control" type="text" id="address" placeholder="Address" required></div>
  					<br/>
  					<button class="btn btn-primary" style="text-align:center" onclick="newuser()">Submit</button>      
  				</form>
  			</div>
  		</div>
  	</body>
    <script type="text/javascript">
    function logout(){
    var url= "<?php echo explode("index.php", site_url())[0].'index.php/cheapbook/logout';?>";
    $.post(url,{}, function( data )
    {
      window.location = "<?php echo explode("index.php", site_url())[0]?>";
    });
  }
    function newuser(){
    var username = $("#username").val();
    var password = $("#password").val();
    var email = $("#email").val();
    var phone = $("#phone").val();
    var address = $("#address").val();
    var url= "<?php echo explode("index.php", site_url())[0].'index.php/cheapbook/newuser';?>";
    console.log(username);
    if(username=="" || password=="" || email=="" || phone=="" || address==""){
      alert("Please enter all the fields")
    }
    else{
    $.post(url,{username:username,password:password,email:email,phone:phone,address:address}, function( data )
    {
      // if($data==false){
      //   alert ("Username already exists");
      // }
      // else{
      //alert("Successfully registered");
      window.location = "<?php echo explode("index.php", site_url())[0]?>";

    });
  }
  }
    </script>


