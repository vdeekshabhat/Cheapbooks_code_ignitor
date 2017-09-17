<?php
class api extends CI_Model {


		function CheckLogin($username, $password) {
			$sql = "SELECT c.username, basketId FROM customers c INNER JOIN shoppingbasket sb ON c.username = sb.username WHERE c.username='".$username."' and password='".md5($password)."'";
			$result = $this->db->query($sql);
			if($result->num_rows()>0) {
				 $row = $result->row(); 
				$data = array('cbuser' => $username,'basketId' => $row->basketId);
            	$this->session->set_userdata('user_session', $data);
				return "true";
			}
			else {
					return "false";	
			}
			
		}
		function SearchByAuthor($text){
			$sql1 = "SELECT * FROM (SELECT ISBN, title, year, price, publisher FROM `book` WHERE ISBN IN(SELECT isbn from writtenby WHERE ssn IN (SELECT ssn FROM author WHERE name LIKE '%".$text."%'))) as A, (SELECT ISBN, SUM(number) as total FROM stocks  GROUP BY ISBN HAVING SUM(number)>0) AS b WHERE A.isbn = b.isbn";
			$query1 = $this->db->query($sql1);

			foreach($query1->result() as $row1){
					$data[] = $row1;
	                
	        }
	        return $data;		
		}
		function SearchByTitle($text){
			$sql2 = "SELECT * FROM (SELECT ISBN, title, year, price, publisher FROM `book` WHERE Title like '%".$text."%') as A, (SELECT ISBN, SUM(number) as total FROM stocks GROUP BY ISBN HAVING SUM(number)>0) AS b WHERE A.isbn = b.isbn";
			$query2 = $this->db->query($sql2);

			foreach($query2->result() as $row2){
					$data[] = $row2;
	                
	        }
	        return $data;	
		}
		function AddToCart($isbn){
		$id=$this->session->user_session['basketId'];
		$sql3 = "SELECT * FROM Contains WHERE ISBN='".$isbn."' AND basketId='".$id."'";
	    $result3 = $this->db->query($sql3);
        if($result3->num_rows() > 0) {
  	    	$sql4 = "UPDATE Contains SET number=number+1 WHERE ISBN='".$isbn."' AND basketId='".$id."'";
  			$result4 = $this->db->query($sql4);
  			return true;
		}
		else {
  			$sql3 = "INSERT INTO Contains (ISBN, basketId, number) VALUES ('".$isbn."', '".$id."', 1)";
  			echo $sql3;
  			$result3 =$this->db->query($sql3);
  			return true;
		}
		}
		public function cart_count($id){
		$id = $this->session->user_session["basketId"];
        $query1 = $this->db->query("SELECT SUM(number) as total FROM Contains WHERE basketid='$id'");
        foreach ($query1->result() as $row1)
        {
            $total = $row1->total;
            if($total == null){
                return 0;
            }else{
                return $total;
            }
        }
		}

		public function cartContent(){
			$id = $this->session->user_session["basketId"];
			$total_price = 0;
			$data= "";
			$sql= $this->db->query("SELECT book.title, contains.ISBN AS isbn, SUM(contains.number) AS addn, SUM(contains.number) * book.price AS price FROM contains LEFT JOIN book ON contains.ISBN = book.ISBN WHERE contains.basketId = '$id' GROUP BY contains.ISBN");
			
			if ($sql->num_rows()> 0) {
				$data .= '<table class="table">
    					<thead class="thead-inverse">
  						<tr>
	  					<th>Book Title</th>
	  					<th>Quantity</th>
	  					<th>Price</th>
	  					</tr>
  						</thead>
  						<tbody>';
		    	foreach ($sql->result() as $row){
		    		$data .="<tr>
		    				<td>".$row->title."</td>
		    				<td>".$row->addn."</td>
		    				<td>$".$row->price."</td></tr>";
		    		$total_price = $total_price + $row->price;
		    	}
		    	$data .="<tr> <td colspan='2'> Total Price </td> <td>" .$total_price ."$</td> </tr></tbody></table>";  
	    	}else{
	    		$data= "<h3> Cart empty! </h3>";
	    	}
	    	return $data;
		}
		public function newuser(){
		$username=$_POST['username'];
		$password=md5($_POST['password']);
		$email=$_POST['email'];
		$phone=$_POST['phone'];
		$address=$_POST['address'];
		$bId=uniqid();

		// $sql2="SELECT * FROM customers WHERE username='$username'";
		// $this->db->query($sq2);
		// if ($sql2->num_rows()> 0){
		// 	return false;
		// }

        //if($username!="" && $password!="" && $email!="" && $phone!="" && $address!)
		$sql="INSERT INTO `customers`(`username`, `password`, `address`, `phone`, `email`) VALUES ('$username','$password','$address','$phone','$email')";
		$this->db->query($sql);

 		 $sql1 = "INSERT INTO shoppingbasket values('".$username."','".$bId."')";
 		 $this->db->query($sql1);

 		 return true;

		

		
  		}
  		public function Buy(){
        $id = $this->session->user_session['basketId'];
        $username = $this->session->user_session['cbuser'];


        $cart_query = "select a.ISBN , SUM(a.number) as num from contains a , book b where a.ISBN = b.ISBN and a.basketId = '$id' GROUP BY a.ISBN";
        $cart_result = $this->db->query($cart_query);
        foreach($cart_result->result() as $order){
            $order_num = $order->num;
            $stock_sql = "select * from stocks where ISBN ='$order->ISBN'";
            $book_warehouse_result = $this->db->query($stock_sql);
            foreach ($book_warehouse_result->result() as $book_warehouse){
                //print_r($book_warehouse);
                $warehouse_books = $book_warehouse->number;

                if (($order_num - $warehouse_books) >0 && $warehouse_books != 0){
                    $countxy = 0;
                    if($order_num > $warehouse_books) {
                        $countxy = $warehouse_books;
                        $balance = $order_num - $warehouse_books;
                    }else {
                        $countxy =  $order_num - $warehouse_books;
                        $balance = $countxy;
                    }
                    $ship =  "INSERT INTO shippingorder VALUES('$order->ISBN', '$book_warehouse->warehouseCode','$username', '$countxy' )";
                    $ship_exec = $this->db->query($ship);

                    $stock_update = "UPDATE stocks SET number='0' WHERE ISBN='$order->ISBN' AND warehouseCode='$book_warehouse->warehouseCode'";
                    $update_stock_result = $this->db->query($stock_update);
                    $order_num = $balance;
					} 
					elseif (($order_num - $warehouse_books) <=0) {
                    $balance =  $warehouse_books - $order_num;
                    $ship =  "INSERT INTO shippingorder VALUES('$order->ISBN', '$book_warehouse->warehouseCode',
'$username', '$order_num' )";
                    $ship_exec = $this->db->query($ship);

                    $stock_update = "UPDATE stocks SET number='$balance' WHERE ISBN='$order->ISBN' AND warehouseCode='$book_warehouse->warehouseCode'";
                    $update_stock_result = $this->db->query($stock_update);
                    $order_num = $balance;
                    break;
                }
            }
        }
        $delete_contains = $this->db->query("delete from contains where basketid ='$id'");
		return true;
    }
    }
