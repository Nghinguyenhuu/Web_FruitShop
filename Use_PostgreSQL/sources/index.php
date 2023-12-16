<?php 
//set thoi gian session het han trong vong 1 tieng
session_set_cookie_params(3600);
session_start();
$user_ses = $_SESSION['user_ses'];
if(!isset($_SESSION['user_ses'])){
   header('location:login.php');
};
include "include/connect.php";

// $users_query = mysqli_query($conn, "SELECT * FROM `users` WHERE id_user = '$user_ses'");
// //check vip
// $fetch_users = mysqli_fetch_assoc($users_query);
// if($fetch_users['role'] = "VIP" ){
//    if ($fetch_users['vip_end'] <= date("Y-m-d")) {
// 	$query = "UPDATE `users` SET `role` = 'user' WHERE `users`.`id_user` = '$user_ses'";
// 	mysqli_query($conn, $query);
//    }
// }
// check vip with postgresql
$users_query = pg_query($conn2, "SELECT * FROM users WHERE id_user = '$user_ses'");
//check vip
$fetch_users = pg_fetch_assoc($users_query);
if($fetch_users['role'] = "VIP" ){
   if ($fetch_users['vip_end'] <= date("Y-m-d")) {
	$query = "UPDATE users SET role = 'user' WHERE id_user = '$user_ses'";
	pg_query($conn2, $query);
   }
}

// if(isset($_POST['add_to_cart'])){
// 	$product_id = $_POST['product_id'];
// 	$product_name = $_POST['product_name'];
// 	$product_price = $_POST['product_price'];
// 	$product_quantity = $_POST['product_quantity'];

// 	$query3 = "SELECT * FROM `cart` WHERE name = '$product_name' AND id_user = '$user_ses'" ;
// 	$select_cart = mysqli_query($conn, $query3) or die ('query failed');
	
// 	#Nếu sản phẩm đã tồn tại trong giỏ hàng thì tăng số lượng sp lên theo số lượng đã chọn
// 	if(mysqli_num_rows($select_cart) > 0){
// 		$product_quantity_before = mysqli_fetch_assoc($select_cart)['quantity']; 
// 		$update_quantity = $product_quantity_before + $product_quantity;
// 		mysqli_query($conn, "UPDATE `cart` SET quantity = '$update_quantity' WHERE name = '$product_name' AND id_user = '$user_ses'") or die('query failed');
// 	}else{
// 	   mysqli_query($conn, "INSERT INTO `cart`(id_user, id_item, name, price, quantity) VALUES('$user_ses', '$product_id', '$product_name',  '$product_price', '$product_quantity')") or die('query failed');
// 	}
// 	header('location:index.php');
//  };

// add to cart but with postgresql
if(isset($_POST['add_to_cart'])){
	$product_id = $_POST['product_id'];
	$product_name = $_POST['product_name'];
	$product_price = $_POST['product_price'];
	$product_quantity = $_POST['product_quantity'];

	$query3 = "SELECT * FROM cart WHERE name = '$product_name' AND id_user = '$user_ses'" ;
	$select_cart = pg_query($conn2, $query3) or die ('query failed');
	
	#Nếu sản phẩm đã tồn tại trong giỏ hàng thì tăng số lượng sp lên theo số lượng đã chọn
	if(pg_num_rows($select_cart) > 0){
		$product_quantity_before = pg_fetch_assoc($select_cart)['quantity']; 
		$update_quantity = $product_quantity_before + $product_quantity;
		pg_query($conn2, "UPDATE cart SET quantity = '$update_quantity' WHERE name = '$product_name' AND id_user = '$user_ses'") or die('query failed');
	}else{
	   pg_query($conn2, "INSERT INTO cart(id_user, id_item, name, price, quantity) VALUES('$user_ses', '$product_id', '$product_name',  '$product_price', '$product_quantity')") or die('query failed');
	}
	header('location:index.php');
 };


// if(isset($_GET['remove'])){
// 	$remove_id = $_GET['remove'];
// 	mysqli_query($conn, "DELETE FROM `cart` WHERE id_order = '$user_ses'") or die('query failed');
// 	header('location:index.php');
// }
// remove but with postgresql
if(isset($_GET['remove'])){
	$remove_id = $_GET['remove'];
	pg_query($conn2, "DELETE FROM cart WHERE id_order = '$user_ses'") or die('query failed');
	header('location:index.php');
}

// if(isset($_GET['delete_all'])){
// 	mysqli_query($conn, "DELETE FROM `cart` WHERE id_user = '$user_ses'") or die('query failed');
// 	header('location:index.php');
// }

// delete all but with postgresql
if(isset($_GET['delete_all'])){
	pg_query($conn2, "DELETE FROM cart WHERE id_user = '$user_ses'") or die('query failed');
	header('location:index.php');
}

// if(isset($_POST['buy_all'])){
// 	$total = $_POST['product_total'];
// 	if ($total < $fetch_users['wallet']) {
// 		mysqli_query($conn, "UPDATE `users` SET wallet = wallet - $total WHERE id_user = '$user_ses'") or die('query failed');
// 		mysqli_query($conn, "DELETE FROM `cart` WHERE id_user = '$user_ses'") or die('query failed');
// 		header('location:index.php');
// 	} else {
// 		echo "<script>alert('You don't have enough money to buy all products in your cart')</script>";
// 		}			
// }
// buy all but with postgresql
if(isset($_POST['buy_all'])){
	$total = $_POST['product_total'];
	if ($total < $fetch_users['wallet']) {
		pg_query($conn2, "UPDATE users SET wallet = wallet - $total WHERE id_user = '$user_ses'") or die('query failed');
		pg_query($conn2, "DELETE FROM cart WHERE id_user = '$user_ses'") or die('query failed');
		header('location:index.php');
	} else {
		echo "<script>alert('You don't have enough money to buy all products in your cart')</script>";
		}			
}

// if(isset($_POST['buy_item'])){
// 	$product_price = $_POST['product_price'];
// 	if ($product_price < $fetch_users['wallet']) {
// 		mysqli_query($conn, "UPDATE `users` SET wallet = wallet - $product_price WHERE id_user = '$user_ses'") or die('query failed');
// 		header('location:index.php');
// 	} else {
// 		echo "<script>alert('You don't have enough money to buy this product')</script>";
// 		}
// }
// buy item but with postgresql
if(isset($_POST['buy_item'])){
	$product_price = $_POST['product_price'];
	if ($product_price < $fetch_users['wallet']) {
		pg_query($conn2, "UPDATE users SET wallet = wallet - $product_price WHERE id_user = '$user_ses'") or die('query failed');
		header('location:index.php');
	} else {
		echo "<script>alert('You don't have enough money to buy this product')</script>";
		}
}

?>
<?php include 'include/header.php'; ?>
	<body>
	<?php include 'include/navbar.php'; ?>
		<div class="container-fluid pt-4 ">	
			<div class="view">
				<div class="row">
				<?php
					// $select_product = mysqli_query($conn, "SELECT * FROM `fruits_table`") or die('query failed');
					// if(mysqli_num_rows($select_product) > 0){
					// 	while($fetch_product = mysqli_fetch_assoc($select_product)){
					// show product but with postgresql
					$select_product = pg_query($conn2, "SELECT * FROM fruits_table") or die('query failed');
					if(pg_num_rows($select_product) > 0){
						while($fetch_product = pg_fetch_assoc($select_product)){
				?>
				<form method="post" class="box border w-25" action="index.php?action=add" align="center">
					<ul class="list-unstyled list-group list-group-horizontal">
						<li><ul class="list-unstyled">
							<li><img class="image img-fluid" src="img/<?php echo $fetch_product['image']; ?>"><br /></li>
						</ul></li>
						<li><ul class="list-unstyled m-3 ">
							<li><div class="name text-info"><h4><?php echo $fetch_product['name']; ?></h4></div></li>
							<li><div class="price text-danger">$<?php echo $fetch_product['price']; ?></div></li>						
							<input type="number" min="1" max="1000" name="product_quantity" style="width: 7em" value="1" >
							<li><input type="submit" value="Add to cart" name="add_to_cart" style="margin-top:5px" ; class="btn btn-danger"></li>
							<li><input type="submit" value="Buy" name="buy_item" style="margin-top:5px" ; class="btn btn-success"></li>
						</ul></li>
						<input type="hidden" name="product_id" value="<?php echo $fetch_product['id']; ?>">			
						<input type="hidden" name="product_name" value="<?php echo $fetch_product['name']; ?>">
						<input type="hidden" name="product_price" value="<?php echo $fetch_product['price']; ?>">
					</ul>		
				</form>
   				<?php
					};
				};
				?>
				</div>
				<br />
				<h3>Cart</h3>
				<div class="table-responsive">
					<table class="table table-bordered">
						<tr>
							<th width="40%">Item Name</th>
							<th width="8%">Quantity</th>
							<th width="20%">Price</th>
							<th width="15%">Total</th>
							<th width="7%">Action</th>
						</tr>
						<?php
							// $cart_query = mysqli_query($conn, "SELECT * FROM `cart` WHERE id_user = '$user_ses'");
							// $grand_total = 0;
							// if(mysqli_num_rows($cart_query) > 0){
							// 	while ($fetch_cart = mysqli_fetch_array($cart_query)){
							//cart query but with postgresql
							$cart_query = pg_query($conn2, "SELECT * FROM cart WHERE id_user = '$user_ses'");
							$grand_total = 0;
							if(pg_num_rows($cart_query) > 0){
								while ($fetch_cart = pg_fetch_array($cart_query)){
									
						?>
						<tr>
							<td><?php echo $fetch_cart['name']; ?></td>							
							<td><?php echo $fetch_cart['quantity']; ?></td>
							<td>$<?php echo $fetch_cart['price']; ?></td>
							<td>$<?php echo $sub_total = ($fetch_cart['price'] * $fetch_cart['quantity']); ?></td>
							<td><a href="index.php?remove=<?php echo $fetch_cart['id_order']; ?>" class="delete-btn" onclick="return confirm('remove item from cart?');">Remove</a></td>
						</tr>
						<?php
							$grand_total += $sub_total;
								}
							}else{
								echo '<tr><td style="padding:20px; text-transform:capitalize;" colspan="6">no item added</td></tr>';
							}
						?>
						<tr class="table-bottom">
							<td colspan="3"><h5>Grand total<h5></td>
							<td>$<?php echo $grand_total; ?></td>
							<td><a href="index.php?delete_all&id=?" onclick="return confirm('Delete all products from cart?');" >Delete All</a></td>
						</tr>
					</table>
					<form method = "POST" >
						<!-- <a href="index.php?buy_all&id=?" onclick="return confirm('Buy all products from cart?');" >Buy All</a></td> -->
						<input type="submit" name="buy_all" value="Buy All" class="btn btn-danger">
						<input type="hidden" name="product_total" value="<?php echo $grand_total; ?>">
					</form>
					<hr>	
					<div>
						<h4>Wallet: <?php echo $fetch_users['wallet']; ?> $</h4>
					</div>
			</div>
		</div>
	</body>
</html>

