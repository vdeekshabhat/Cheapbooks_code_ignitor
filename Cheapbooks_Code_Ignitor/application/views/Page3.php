  <nav class="navbar navbar-inverse">
  		<div class="container-fluid">

  			<div class="navbar-form navbar-right">
  		    	<button class="btn btn-primary" onclick="logout()">Log Out</button>
  			</div>
  	 	</div>
  </nav> 
  <h3>Current Items in Shopping Cart</h3>
  <div class="data"></div>
  <div>
     <div class = "col-md-8"></div>
  	 <button class="btn btn-primary col-md-2" onclick= "Buy()" >Buy</button>
  </div>
  <script type="text/javascript">
  	  $(document).ready(function(){
      var url= "<?php echo explode("index.php", site_url())[0].'index.php/cheapbook/cartContent';?>";
      $.post(url,{}, function( data )
      {
        $( ".data" ).html( data );
      });
    });
    function logout(){
    var url= "<?php echo explode("index.php", site_url())[0].'index.php/cheapbook/logout';?>";
    $.post(url,{}, function( data )
    {
      window.location = "<?php echo explode("index.php", site_url())[0]?>";
    });
  }
   function Buy(){
    var url= "<?php echo explode("index.php", site_url())[0].'index.php/cheapbook/Buy';?>";
    $.post(url,{}, function( data )
    {
      window.location = "<?php echo explode("index.php", site_url())[0]?>";
    });
  }
  	
  </script>