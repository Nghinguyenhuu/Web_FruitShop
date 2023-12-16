<?php
    session_start();
    $admin_ses = $_SESSION['sadmin'];
    if(!isset($admin_ses)){
        header('location:login.php');
    };
    include "include/connect.php";
    // $query = "SELECT * FROM fruits_table ORDER BY id ASC";
    // $query2 = "SELECT * FROM users ORDER BY id_user ASC";
    // $result2 = mysqli_query($conn, $query2);
    // if(isset($_GET['remove_user'])){
    //     $remove_id = $_GET['remove_user'];
    //     mysqli_query($conn, "DELETE FROM `cart` WHERE id_user = '$remove_id'") or die('query failed');
    //     mysqli_query($conn, "DELETE FROM `users` WHERE id_user = '$remove_id'") or die('query failed');
    //     header('location:manage_account.php');
    //  }
    // with postgresql
    $query = "SELECT * FROM fruits_table ORDER BY id ASC";
    $query2 = "SELECT * FROM users ORDER BY id_user ASC";
    $result2 = pg_query($conn2, $query2);
    if(isset($_GET['remove_user'])){
        $remove_id = $_GET['remove_user'];
        pg_query($conn2, "DELETE FROM cart WHERE id_user = '$remove_id'") or die('query failed');
        pg_query($conn2, "DELETE FROM users WHERE id_user = '$remove_id'") or die('query failed');
        header('location:manage_account.php');
     }

?>
<?php include 'include/header.php'; ?>
	<body>
    <?php include 'include/navbar_admin.php'; ?>
    <div class="container-fluid pt-4">	
        <br />
        <h3>Cart</h3>
        <div class="table-responsive">
            <table class="table table-bordered">
                <tr>
                    <th width="20%">User ID</th>
                    <th width="30%">User Name</th>
                    <th width="20%">Password</th>
                    <th width="20%">Wallet</th>
                    <th width="10%">Role</th>
                </tr>
                <?php
                    // if(mysqli_num_rows($result2) > 0){
                    //     while ($fetch_user = mysqli_fetch_array($result2)){
                    // with postgresql
                    if(pg_num_rows($result2) > 0){
                        while ($fetch_user = pg_fetch_array($result2)){
                ?>
                <tr>
                    <td><?php echo $fetch_user['id_user']; ?></td>
                    <td><?php echo $fetch_user['username']; ?></td>
                    <td><?php echo $fetch_user['password']; ?></td>
                    <td><?php echo $fetch_user['wallet']; ?></td>
                    <td><?php echo $fetch_user['role']; ?></td>
                    <td><a href="manage_account.php?remove_user=<?php echo $fetch_user['id_user']; ?>" class="delete-btn" onclick="return confirm('remove user?');">Remove</a></td>
                </tr>
                <?php
                        }
                    }
                ?>		
            </table>			
        </div>
    </body>
</html>