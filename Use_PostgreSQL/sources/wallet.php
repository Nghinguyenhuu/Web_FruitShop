<?php
session_start();

$user_ses = $_SESSION['user_ses'];

if(!isset($user_ses)){
   header('location:login.php');
};

# biến mở kết nối tới MySQL server
include "include/connect.php";
#$conn = mysqli_connect("localhost", "nbp1", "passMySQL", "fruit_shop");
// $query2 = "SELECT * FROM users where $user_ses = id_user";
// $result2 = mysqli_query($conn, $query2);
// with postgresql
$query2 = "SELECT * FROM users where $user_ses = id_user";
$result2 = pg_query($conn2, $query2);


    if (isset($_POST['recharge'])) {
        // $amount = $_POST['amount'];
        // $query = "UPDATE users SET wallet = wallet + $amount WHERE id_user='$user_ses'";
        // $result = mysqli_query($conn, $query);
        // with postgresql
        $amount = $_POST['amount'];
        $query = "UPDATE users SET wallet = wallet + $amount WHERE id_user='$user_ses'";
        $result = pg_query($conn2, $query);
        if ($result) {
            header('location:wallet.php');
        }else{
            echo '<script> 
                alert("Recharge failed!");
                </script>';
        }
    }
    if (isset($_POST['transf'])) {
        $id_recv = test_input($conn2, $_POST['id_recv']);
        $name = test_input($conn2, $_POST['name']);
        $email = test_input($conn2, $_POST['email']);
        $amount = test_input($conn2, $_POST['amount_transf']);

        // $checkid = "SELECT * FROM users WHERE id_user = '$id_recv' and name = '$name' and email = '$email' and id_user != '$user_ses'";
        // $result_check = mysqli_query($conn, $checkid);
        // if (mysqli_num_rows($result_check) > 0) {
        //     $query = "UPDATE users SET wallet = wallet + $amount WHERE id_user='$id_recv'";
        //     $result = mysqli_query($conn, $query) or die('query failed');
        //     $query2 = "UPDATE users SET wallet = wallet - $amount WHERE id_user='$user_ses'";
        //     $result2 = mysqli_query($conn, $query2) or die('query failed');
        //     if ($result && $result2) {
        //         header('location:wallet.php');
        //     }else{
        //         echo '<script> 
        //         alert("Transfer failed!");
        //         </script>';
        //     }
        // }else{
        //     echo '<script> 
        //         alert("ID not found!");
        //         </script>';
        // }
        // with postgresql
        $checkid = "SELECT * FROM users WHERE id_user = '$id_recv' and name = '$name' and email = '$email' and id_user != '$user_ses'";
        $result_check = pg_query($conn2, $checkid);
        if (pg_num_rows($result_check) > 0) {
            $query = "UPDATE users SET wallet = wallet + $amount WHERE id_user='$id_recv'";
            $result = pg_query($conn2, $query) or die('query failed');
            $query2 = "UPDATE users SET wallet = wallet - $amount WHERE id_user='$user_ses'";
            $result2 = pg_query($conn2, $query2) or die('query failed');
            if ($result && $result2) {
                header('location:wallet.php');
            }else{
                echo '<script> 
                alert("Transfer failed!");
                </script>';
            }
        }else{
            echo '<script> 
                alert("ID not found!");
                </script>';
        }

    }
    if (isset($_POST['vip'])) {
        
        if ($_POST['list_vip'] == 'Monthly' ){
            $amount = 100;
            $date_gain = 30;
        }else{
            $amount = 1111;
            $date_gain = 365;
        }
        //$fetch_users = mysqli_fetch_array($result2);
        $fetch_users = pg_fetch_array($result2);
        if ($fetch_users['wallet'] >= $amount) {          
            // $query = "UPDATE users SET wallet = wallet - $amount WHERE id_user='$user_ses'";
            // $result = mysqli_query($conn, $query);
            // with postgresql
            $query = "UPDATE users SET wallet = wallet - $amount WHERE id_user='$user_ses'";
            $result = pg_query($conn2, $query);
            if ($result) {
                // $query3 = "UPDATE users SET role = 'VIP' WHERE id_user='$user_ses'";
                // $result3 = mysqli_query($conn, $query3);
                // $date_end = date('Y-m-d', strtotime(date("Y-m-d"). ' + '.$date_gain.' days'));
                // $query4 = "UPDATE users SET vip_end =  '$date_end' WHERE id_user='$user_ses'";
                // $result4 = mysqli_query($conn, $query4);
                // with postgresql
                $query3 = "UPDATE users SET role = 'VIP' WHERE id_user='$user_ses'";
                $result3 = pg_query($conn2, $query3);
                $date_end = date('Y-m-d', strtotime(date("Y-m-d"). ' + '.$date_gain.' days'));
                $query4 = "UPDATE users SET vip_end =  '$date_end' WHERE id_user='$user_ses'";
                $result4 = pg_query($conn2, $query4);

                echo '<script> 
                alert("Success update to vip!");
                window.location.href="wallet.php";
                </script>';
               
            }else{
                echo '<script> 
                alert("Update failed!");
                window.location.href="wallet.php";
                </script>';
            }
        }else{
            echo '<script> 
            alert("Not enough money!");
            window.location.href="wallet.php";
            </script>';
        }   
    }
    if (isset($_POST['un_vip'])){
        // $query = "UPDATE users SET role = 'user', vip_end = NULL WHERE id_user='$user_ses'";
        // $result = mysqli_query($conn, $query);
        // with postgresql
        $query = "UPDATE users SET role = 'user', vip_end = NULL WHERE id_user='$user_ses'";
        $result = pg_query($conn2, $query);

        if ($result) {
            echo '<script> 
            alert("Successful unsubscribe!");
            window.location.href="wallet.php";
            </script>';
        }else{
            echo '<script> 
            alert("Update failed!");
            window.location.href="wallet.php";
            </script>';
        }
    }
?>
<?php include 'include/header.php'; ?>
   <body>
   <?php include 'include/navbar.php'; ?>
        <div class="container">
        <h1>Wallet</h1>
        <hr>
        <?php
               //$fetch_cart = mysqli_fetch_array($result2);
                // with postgresql
                $fetch_cart = pg_fetch_array($result2);
        ?>
        <h4>Current money: <?php echo $fetch_cart['wallet']; ?> $ </h4>
        <hr>
        <h3>Recharge money</h3>
        <form method="POST">
            <div class="form-group">
                <label for="amount">Amount</label>
                <input type="number" class="form-control" id="amount" min = 1.00 max= 10000 name="amount" placeholder="Enter amount">
                <label> Card ID </label>
                <input type="number" class="form-control" min=1 id="card_id" name="card_id" placeholder="Enter card ID">
            </div>
            <button type="submit" class="btn btn-primary" name="recharge">Recharge</button>
           <!-- <input type="number" name="amount" min=1.00 >
           <input type="submit" name="recharge"  value="Recharge"> -->
        </form>
        <hr>
            <h3>Transfers</h3>
            <form method="POST">
            <div class="form-group">
                <label> ID receive: </label>
                <input type="number" class="form-control" name="id_recv" placeholder="Enter card ID" required>
                <label> Name </label>
                <input type="text" class="form-control" name="name" placeholder="Enter Recipient's Name" required>
                <label> Email </label>
                <input type="email" class="form-control" name="email" placeholder="Enter Recipient's Email" required>
                <label for="amount">Amount</label>
                <input type="number" class="form-control" name="amount_transf" min=1.00 max= 10000 placeholder="Enter amount" required>
            </div>
            <button type="submit" class="btn btn-primary" name="transf">Transfers</button>
        </form>
        <hr>
        <hr>
        <div class="vip py-5">
           <h3>VIP Account</h3> 
           <?php
                // $query1 = "SELECT * FROM users where $user_ses = id_user";
                // $result = mysqli_query($conn, $query2);
                // $fetch_users = mysqli_fetch_array($result);
                // with postgresql
                $query1 = "SELECT * FROM users where $user_ses = id_user";
                $result = pg_query($conn2, $query2);
                $fetch_users = pg_fetch_array($result);
                
                if ($fetch_users['role'] == 'VIP') {
                    echo '<h4> VIP status: Subscribed</h4>';
                    echo '<h4>Now you have 30% discount to '.$fetch_cart['vip_end'].'</h4>';
                    echo '<form method="POST">            
                        <input type="submit" name="un_vip"  value="Unsubscribe vip">
                    </form>';
                }else{
                     echo '<h4>VIP status: Not VIP</h4>';
                     echo '<p>Get 30% discount on all products</p>
                     <div>
                         <form method="POST">
                         <div class="form-group ">
                             <label for="sel1">Register VIP account with only: Monthly Package (100$/1m), Yearly Package (1111$/1y) </label>
                             <select class="form-control" id="sel1" name="list_vip" class="list_vip" style="width: 200px;">
                                 <option>Monthly</option>
                                 <option>Yearly</option>
                             </select>
                         </div>
                             <input type="submit" name="vip"  value="Buy">
                         </form>
         
                 </div>';
                }
           ?>
            

        
        

   </body>
</html>




