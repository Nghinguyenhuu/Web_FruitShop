<?php 
session_start();

$user_ses = $_SESSION['user_ses'];

if(!isset($user_ses)){
   header('location:login.php');
};
include "include/check.php";
include "include/connect.php";
// $query2 = "SELECT * FROM users where $user_ses = id_user";
// $result2 = mysqli_query($conn, $query2);
// with postgresql
$query2 = "SELECT * FROM users where $user_ses = id_user";
$result2 = pg_query($conn2, $query2);

if(isset($_POST['edit'])){
   //lay thong tin tu form update
   $name = test_input($conn2, $_POST['name']);
   $email = test_input($conn2, $_POST['email']);
   $phone = test_input($conn2, $_POST['contact']);
   $image = test_input($conn2, $_FILES['photo']['name']);
   $password = test_input($conn2, $_POST['new_password']);
   $curr_password = test_input($conn2, $_POST['curr_password']);
   
   if (!preg_match("/^\\+?[1-9][0-9]{7,14}$/", $phone)) {
      echo "<script>
      alert('Phone number is invalid');
      window.location.href='profile.php';
      </script>";
      exit();
   }
   if (!preg_match("/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/", $email)) {
      echo "<script>alert('Email is invalid');
      window.location.href='profile.php';
      </script>";
      exit();
   }
   if($_FILES['photo']['name']!=""){
      check_upload_image('photo');
   }
   //$fetch_cart = mysqli_fetch_array($result2);
   $fetch_cart = pg_fetch_array($result2);
   $move = "./img/".$image;
   if (md5($curr_password) == $fetch_cart['password']) {
      // $query4 = "UPDATE users SET name = '$name', email = '$email', phone_number = '$phone' WHERE id_user='$user_ses'";
      // $result_up = mysqli_query($conn, $query4);
      // with postgresql
      $query4 = "UPDATE users SET name = '$name', email = '$email', phone_number = '$phone' WHERE id_user='$user_ses'";
      $result_up = pg_query($conn2, $query4);
      //thay đổi pass nếu ô password được điền 
      if ($_POST['new_password']!="") {
         // $query5 = "UPDATE users SET password = '" . md5($password) . "' WHERE id_user='$user_ses'";
         // $result_up2 = mysqli_query($conn, $query5);
         // with postgresql
         $query5 = "UPDATE users SET password = '" . md5($password) . "' WHERE id_user='$user_ses'";
         $result_up2 = pg_query($conn2, $query5);
      };
      //kiểm tra cập nhật thông tin
      if ($result_up){
         //nếu có upload ảnh thì kiểm tra và thực hiện upload
         if($_FILES['photo']['name']!=""){
            check_upload_image('photo');
            if (move_uploaded_file($_FILES['photo']['tmp_name'], $move)){
               // mysqli_query($conn, 'UPDATE users SET avatar = "'.$image.'" WHERE id_user="'.$user_ses.'"');
               // with postgresql
               pg_query($conn2, 'UPDATE users SET avatar = "'.$image.'" WHERE id_user="'.$user_ses.'"');
               header('location:profile.php');
            }else{
               echo "Update failed";
            }
         }
         header('location:profile.php');
      }else{
         echo "Update failed";                                                                                                                                                                                     
      }
   }else{
      echo "Wrong password";
   }
}

?>
<?php include 'include/header.php'; ?>
   <body>
   <?php include 'include/navbar.php'; ?>
   <?php                    
         // $fetch_cart = mysqli_fetch_array($result2)
         // with postgresql
         $fetch_cart = pg_fetch_array($result2)
      ?>
      <form method="POST" class="info-from px-5">
         <picture>
            <h4>Avatar</h4>
            <img class="image" src="img/<?php echo $fetch_cart['avatar']; ?>">
         </picture>
         <div class="name">
            <h4>Name: </h4>
            <p><?php echo $fetch_cart['name']; ?></p>
         </div>
         <div class="email">
            <h4>Email</h4>
            <p><?php echo $fetch_cart['email']; ?></p>
         </div>
         <div class=phone_number>
            <h4>Phone Number</h4>
            <p><?php echo $fetch_cart['phone_number']; ?></p>
         </div>
         <div class="wallet">
            <h4>Wallet</h4>
            <p><?php echo $fetch_cart['wallet']; ?></p>
         </div>
      </form>
      <hr>
      <h3 class="text-center">Edit your information</h3>
      <form class="form-horizontal" method="POST" action="profile.php?update" enctype="multipart/form-data">
         <div class="form-group">
            <label for="name" class="col-sm-3 control-label">Name</label>
            <div class="col-sm-9">
               <input type="text" class="form-control" id="name" name="name" value="<?php echo $fetch_cart['name']; ?>">
            </div>
         </div>
         <div class="form-group">
            <label for="email" class="col-sm-3 control-label">Email</label>
            <div class="col-sm-9">
               <input type="email" class="form-control" id="email" name="email" value="<?php echo $fetch_cart['email']; ?>">
            </div>
         </div>
         <div class="form-group">
            <label for="password" class="col-sm-3 control-label">Password</label>
            <div class="col-sm-9">
               <input type="password" class="form-control" id="new_password" name="new_password" placeholder="new password?">
            </div>
         </div>
         <div class="form-group">
            <label for="contact" class="col-sm-3 control-label">Contact Info (8-14 number)</label>
            <div class="col-sm-9">
               <input type="text" class="form-control" id="contact" name="contact" value="<?php echo $fetch_cart['phone_number']; ?>">
            </div>
         </div>
         <div class="form-group">
            <label for="photo" class="col-sm-3 control-label">Avatar</label>
            <div class="col-sm-9">
               <input type="file" id="photo" name="photo">
            </div>
         </div>
         <hr>
            <div class="form-group">
               <label for="curr_password" class="col-sm-3 control-label">Current Password</label>

               <div class="col-sm-9">
                  <input type="password" class="form-control" id="curr_password" name="curr_password" placeholder="input current password to save changes" required>
               </div>
            </div>
      </div>
      <div class="modal-footer">
         <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
         <button type="submit" class="btn btn-success btn-flat" name="edit"><i class="fa fa-check-square-o"></i> Update</button>
         </form>
      </div>
   </body>
</html>