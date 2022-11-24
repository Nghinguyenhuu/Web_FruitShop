<?php
session_start();

$user_ses = $_SESSION['user_ses'];

if(!isset($user_ses)){
   header('location:login.php');
};

# biến mở kết nối tới MySQL server
include "include/connect.php";
#$conn = mysqli_connect("localhost", "nbp1", "passMySQL", "fruit_shop");
$query2 = "SELECT * FROM users where $user_ses = id_user";
$result2 = mysqli_query($conn, $query2);


    if (isset($_POST['recharge'])) {
        $amount = $_POST['amount'];
        $query = "UPDATE users SET wallet = wallet + $amount WHERE id_user='$user_ses'";
        $result = mysqli_query($conn, $query);
        if ($result) {
            header('location:wallet.php');
        }else{
            echo "Update failed";
        }
    }
    if (isset($_POST['transf'])) {
        $id_recv = $_POST['id_recv'];
        $amount = $_POST['amount_transf'];
        $checkid = "SELECT * FROM users WHERE id_user = '$id_recv'";
        $result_check = mysqli_query($conn, $checkid);
        if (mysqli_num_rows($result_check) > 0) {
            $query = "UPDATE users SET wallet = wallet + $amount WHERE id_user='$id_recv'";
            $result = mysqli_query($conn, $query) or die('query failed');
            $query2 = "UPDATE users SET wallet = wallet - $amount WHERE id_user='$user_ses'";
            $result2 = mysqli_query($conn, $query2) or die('query failed');
            if ($result && $result2) {
                header('location:wallet.php');
            }else{
                echo "Update failed";
            }
        }else{
            echo "ID not found";
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
        $fetch_users = mysqli_fetch_array($result2);
        if ($fetch_users['wallet'] >= $amount) {          
            $query = "UPDATE users SET wallet = wallet - $amount WHERE id_user='$user_ses'";
            $result = mysqli_query($conn, $query);
            if ($result) {
                $query3 = "UPDATE users SET role = 'VIP' WHERE id_user='$user_ses'";
                $result3 = mysqli_query($conn, $query3);
                $date_end = date('Y-m-d', strtotime(date("Y-m-d"). ' + '.$date_gain.' days'));
                $query4 = "UPDATE users SET vip_end =  '$date_end' WHERE id_user='$user_ses'";
                $result4 = mysqli_query($conn, $query4);
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
        $query = "UPDATE users SET role = 'user', vip_end = NULL WHERE id_user='$user_ses'";
        $result = mysqli_query($conn, $query);
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
               $fetch_cart = mysqli_fetch_array($result2);
        ?>
        <h4>Current money: <?php echo $fetch_cart['wallet']; ?> $ </h4>
        <hr>
        <h3>Recharge money</h3>
        <form method="POST">
            <div class="form-group">
                <label for="amount">Amount</label>
                <input type="number" class="form-control" id="amount" min = 1.00 max= 10000 name="amount" placeholder="Enter amount">
                <label> Card ID </label>
                <input type="text" class="form-control" id="card_id" name="card_id" placeholder="Enter card ID">
            </div>
            <button type="submit" class="btn btn-primary" name="recharge">Recharge</button>
           <!-- <input type="number" name="amount" min=1.00 >
           <input type="submit" name="recharge"  value="Recharge"> -->
        </form>
        <hr>
            <h3>Transfers</h3>
            <form method="POST">
                <label for="id_recv">ID receive:</label>
                <input type="number" name="id_recv" min=1.00 >
                <label for="amount_transf">Amount want to transfers:</label>
                <input type="number" name="amount_transf" min=1.00 >
                <input type="submit" name="transf"  value="Transfers">
            </form>
        <hr>
        <div class="vip py-5">
           <h3>VIP Account</h3> 
           <?php
                $query1 = "SELECT * FROM users where $user_ses = id_user";
                $result = mysqli_query($conn, $query2);
                $fetch_users = mysqli_fetch_array($result);
                if ($fetch_users['role'] == 'VIP') {
                     echo '<h4>Current VIP: '.$fetch_cart['vip_end'].'</h4>';
                     echo '<form method="POST">            
                         <input type="submit" name="un_vip"  value="Unsubscribe vip">
                     </form>';
                }else{
                     echo '<h4>Current VIP: Not VIP</h4>';
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




