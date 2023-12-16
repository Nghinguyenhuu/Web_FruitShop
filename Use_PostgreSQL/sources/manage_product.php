<?php
    session_start();
    $admin_ses = $_SESSION['sadmin'];
    if(!isset($admin_ses)){
        header('location:login.php');
    };
    include "include/connect.php";
    #$conn = mysqli_connect("localhost", "nbp1", "passMySQL", "fruit_shop");

    include "include/check.php";


    if(isset($_GET['remove'])){
        $remove_id = $_GET['remove'];
        // mysqli_query($conn, "DELETE FROM `cart` WHERE id_item = '$remove_id'") or die('query failed');
        // mysqli_query($conn, "DELETE FROM `fruits_table` WHERE id = '$remove_id'") or die('query failed');
        // with postgresql
        pg_query($conn2, "DELETE FROM cart WHERE id_item = '$remove_id'") or die('query failed');
        pg_query($conn2, "DELETE FROM fruits_table WHERE id = '$remove_id'") or die('query failed');
        header('location:manage_product.php');
     }
    if (isset($_POST['add'])) {
        $product_name = test_input($conn2, $_POST["name"]);
        $product_price = test_input($conn2, $_POST["price"]);
        $file_img = test_input($conn2, $_FILES["add_image"]["name"]);
        //chuyen ảnh vào folder img
        $folder = "./img/" . $file_img; 
        if($_FILES['add_image']['name']!=""){
            check_upload_image('add_image');
            if (move_uploaded_file($_FILES['add_image']['tmp_name'], $folder)){
                //mysqli_query($conn, "INSERT INTO fruits_table (name, price, image) VALUES ('$product_name', '$product_price', '$file_img' )");
                pg_query($conn2, "INSERT INTO fruits_table (name, price, image) VALUES ('$product_name', '$product_price', '$file_img' )");
                echo '<script> 
                alert("Success to add new product!");
                window.location.href="manage_product.php";
                </script>';
            }else{
                echo '<script> 
                alert("Failed to add new product!");
                window.location.href="manage_product.php";
                </script>';
            }
         }       
    }
?>
<?php include 'include/header.php'; ?>
<body>
<?php include 'include/navbar_admin.php'; ?>
    <h3>List of Product</h3>
    <div class="container">
        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#form">
            Add Product
        </button>  
    </div>
    <div class="modal fade" id="form" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header border-bottom-0">
                    <h5 class="modal-title" id="exampleModalLabel">Add a product</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action="" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="form-group">
                            <label">Product's name</label>
                            <input type="text" class="form-control" name="name" placeholder="Enter product's name">
                        </div>
                        <div class="form-group">
                            <label">Price</label>
                            <input type="number" class="form-control" name="price" placeholder="Enter product's price">
                        </div>
                        <div class="form-group">
                            <input class="form-control" type="file" name="add_image" placeholder="Upload file jpg"/>
                        </div>
                    </div>
                    <div class="modal-footer border-top-0 d-flex justify-content-center">
                        <button type="submit" class="btn btn-success" name="add">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered">
            <tr>
                <th width="30%">Item Name</th>
                <th width="10%">Price</th>
                <th width="7%"></th>
            </tr>
            <?php
                // $cart_query = mysqli_query($conn, "SELECT * FROM `fruits_table`");
                // if(mysqli_num_rows($cart_query) > 0){
                //     while ($fetch_cart = mysqli_fetch_array($cart_query)){
                $cart_query = pg_query($conn2, "SELECT * FROM fruits_table");
                if(pg_num_rows($cart_query) > 0){
                    while ($fetch_cart = pg_fetch_array($cart_query)){

            ?>
            <tr>
                <td><?php echo $fetch_cart['name']; ?></td>
                <td>$<?php echo $fetch_cart['price']; ?></td>
                <td><img class="image" src="img/<?php echo $fetch_cart['image']; ?>"></td>       
                <td ><a href="manage_product.php?remove=<?php echo $fetch_cart['id']; ?>" class="delete-btn" onclick="return confirm('remove item from list product?');">Remove</a></td>
            </tr>
            <?php
                    }
                }else{
                    echo '<tr><td style="padding:20px; text-transform:capitalize;" colspan="6">no item added</td></tr>';
                }
            ?>
        </table>			
    </div>
</body>
</html>
