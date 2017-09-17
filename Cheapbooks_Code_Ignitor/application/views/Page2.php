 <?php $id=$this->session->user_session['basketId'];?>
 <nav class="navbar navbar-inverse">
  		<div class="container-fluid">

  			<div class="form-group col-md-3">
  				<input type="text" class="form-control" placeholder="Search for Books" name="searchbox">
  			</div>
  			<button class="btn btn-primary"  id="ByAuthor">By Author</button>
  			<button class="btn btn-primary"  id="ByTitle">By Book Title</button>
  			<div class="navbar-form navbar-right">
          		<button class="btn btn-primary" onclick="document.location.href='Page3'" name="ShoppingCart">Shopping cart <span class="glyphicon glyphicon-shopping-cart"><span id="cart_count"></span></button>
  		    	<button class="btn btn-primary" onclick="logout()">Log Out</button>
  		</div>
  	 </div>
  </nav> 

  <div class="row" id="resultDiv">
  </div>

  <script type="text/javascript">
  function cart_count(){
  	basketId="<?php echo $id?>";
		$.post("<?php echo explode("index.php", site_url())[0].'index.php/cheapbook/cart_count';?>",{basketId : basketId}, function(data){
      $("#cart_count").html(data);
      });
  }
	$(document).ready(function() {

			cart_count();
			$("#ByAuthor").click(function() {
					
			var text= $( "input[name ='searchbox']" ).val();
  			var URL="search.php?name="+text;
  			var flag = 0;

		    $.ajax({
		        url: '<?php echo explode("index.php", site_url())[0];?>index.php/cheapbook/SearchByAuthor',
		        type: 'POST',
		        dataType: "json",
		        data: {
		            'text': text,
		        },
		        success: function(data) {
		        	$("#resultDiv").html('');
					if (data) {
		                var l = Object.keys(data).length;
		                for(var i=0; i<l; i++) {
		                  $("#resultDiv").append('<div class="col-sm-6 col-md-4"><div class="thumbnail"><div class="caption"><h3>'+ data[i]['title'] +'</h3><p>Year: '+ data[i]["year"] +'<br />ISBN: '+data[i]["ISBN"]+'<br />Price: '+ data[i]["price"] + "<br />Publisher: " + data[i]["publisher"]+ '<br />Stocks: ' + data[i]["number"]+'</p><p><button onclick="addToCart('+data[i]["ISBN"]+')" class="btn btn-primary">Add to Cart</button></p></div></div></div>'); 
		                }
		            }
		            // else {
		            // 	$("#resultDiv").append('<div><h3> No match found!!</h3></div>')
		            //     //alert("No match found");
		            // }
		        },
		        error:function (textStatus, errorThrown){
		        	$("#resultDiv").html('');
		        	$("#resultDiv").append('<div class="container-fluid"><h3> No match found!!</h3></div>');
		        }
		    })
		    })
		});

	$(document).ready(function() {
			$("#ByTitle").click(function() {
					
			var text= $( "input[name ='searchbox']" ).val();
  			var URL="search.php?name="+text;
  			var flag = 0;

		    $.ajax({
		        url: '<?php echo explode("index.php", site_url())[0];?>index.php/cheapbook/SearchByTitle',
		        type: 'POST',
		        dataType: "json",
		        data: {
		            'text': text,
		        },
		        success: function(data) {
		            if (data) {
		                var l = Object.keys(data).length;
		                $("#resultDiv").html('');
		                for(var i=0; i<l; i++) {
		                  $("#resultDiv").append('<div class="col-sm-6 col-md-4"><div class="thumbnail"><div class="caption"><h3>'+ data[i]['title'] +'</h3><p>Year: '+ data[i]["year"] +'<br />ISBN: '+data[i]["ISBN"]+'<br />Price: '+ data[i]["price"] + "<br />Publisher: " + data[i]["publisher"]+ '<br />Stocks: ' + data[i]["number"]+'</p><p><button onclick="addToCart('+data[i]["ISBN"]+')" class="btn btn-primary">Add to Cart</button></p></div></div></div>'); 
		                }
		            }
		            else {
		                alert("Some Error");
		            }
		        },
		         error:function (textStatus, errorThrown){
		        	$("#resultDiv").html('');
		        	$("#resultDiv").append('<div class="container-fluid"><h3> No match found!!</h3></div>');
		        }
		    })
		    })
		});
	function addToCart(isbn) {
  			var isbn = isbn;
        console.log(isbn);
			  $.ajax({
		        url: "<?php echo explode("index.php", site_url())[0].'index.php/cheapbook/AddToCart';?>",
		        type: 'POST',
		        dataType: "json",
		        data: {
		            'isbn': isbn
		        },
		        success: function(data) {
		        	
		                alert("Added to cart successfully");
		                cart_count();
		        }
		    });
  		}
    function logout(){
    var url= "<?php echo explode("index.php", site_url())[0].'index.php/cheapbook/logout';?>";
    $.post(url,{}, function( data )
    {
      window.location = "<?php echo explode("index.php", site_url())[0]?>";
    });
  }


</script>