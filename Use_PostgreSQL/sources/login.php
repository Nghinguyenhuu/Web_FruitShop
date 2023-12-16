<?php 
session_start();
#Kiểm tra nếu đã đăng nhập thì chuyển vào trang index.php
if(isset($user_ses)){
    header('location:index.php');
};
include "include/check.php";
include "include/connect.php";
?>
<?php include 'include/header.php'; ?>
	<body>
    <?php
        // When form submitted, check and create user session.
        if (isset($_POST['submit']) && $_POST['g-recaptcha-response']!="" ) {
            $secret = '6LfCFTIjAAAAAJfpk4_4LExgTwgK_d0RFMkkX_cU';
            $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.$_POST['g-recaptcha-response']);
            $responseData = json_decode($verifyResponse);
            if($responseData->success)
            { 
                $username = stripslashes($_REQUEST['username']);    
                $username = mysqli_real_escape_string($conn, $username);
                $password = stripslashes($_REQUEST['password']);
                $password = mysqli_real_escape_string($conn, $password);
                // Check user is exist in the database
                // $query    = "SELECT * FROM `users` WHERE username='$username'
                //             AND password='" . md5($password) . "'";
                // $result = mysqli_query($conn, $query) or die(mysql_error());
                // $result2 = mysqli_query($conn, "SELECT * FROM `users` WHERE username='$username' AND role = 'admin'
                // AND password='" . md5($password) . "'") or die(mysql_error());


                //check admin or user 
                // if (mysqli_num_rows($result2) > 0) {
                //     $row = mysqli_fetch_assoc($result2);
                //     $_SESSION['sadmin'] = $row['id_user'];
                //     echo "<script>window.location.href='admin.php'</script>";
                // } else if (mysqli_num_rows($result) > 0) {
                //     $row = mysqli_fetch_assoc($result);
                //     $_SESSION['user_ses'] = $row['id_user'];   
                //     //remmember me: this function have bug after i am docker this app
                //     // if (isset($_POST['remember'])) {
                //     //     setcookie('user_ses', $row['username'], time() + 60*60*24*30);
                //     // }             
                //     echo "<script>window.location.href='index.php'</script>";
                // } else {
                //     echo "<div class='form'>
                //         <h3>Incorrect Username/password.</h3><br/>
                //         <p class='link'>Click here to <a href='login.php'>Login</a> again.</p>
                //         </div>";
                // }

                // check user but use postgresql
                $query2 = "SELECT * FROM users WHERE username='$username' AND password='" . md5($password) . "'";
                $result = pg_query($conn2, $query2) or die('Query failed: ' . pg_last_error());
                $result2 = pg_query($conn2, "SELECT * FROM users WHERE username='$username' AND role = 'admin';") or die('Query failed: ' . pg_last_error());

                // check admin or user
                if (pg_num_rows($result2) > 0) {
                    $row = pg_fetch_assoc($result2);
                    $_SESSION['sadmin'] = $row['id_user'];
                    echo "<script>window.location.href='admin.php'</script>";
                } else if (pg_num_rows($result) > 0) {
                    $row = pg_fetch_assoc($result);
                    $_SESSION['user_ses'] = $row['id_user'];   
                    //remmember me: this function have bug after i am docker this app
                    // if (isset($_POST['remember'])) {
                    //     setcookie('user_ses', $row['username'], time() + 60*60*24*30);
                    // }             
                    echo "<script>window.location.href='index.php'</script>";
                } else {
                    echo "<div class='form'>
                        <h3>Incorrect Username/password.</h3><br/>
                        <p class='link'>Click here to <a href='login.php'>Login</a> again.</p>
                        </div>";
                }
            }
        }
    ?>
        <div class="container">
                <form class="form" method="post" name="login">
                    <h1 class="login-title">Login</h1>
                    <hr>
                    <input type="text" class="login-input" name="username" placeholder="Username" autofocus="true"/>
                    <input type="password" class="login-input" name="password" placeholder="Password"/>
                    <div class="g-recaptcha" data-sitekey="6LfCFTIjAAAAAKTiq6i2_Zfgv0ybNou6I6D8I4l9"></div>
                    <input type="submit" value="Login" name="submit" class="login-button"/>
                    <!-- <input type="checkbox" name="remember" id="remember">Remember me</label> -->
                    <hr>
                    <p class="link"><a href="register.php">New Registration</a></p>

                </form>
        <?php
            
        ?>
        </div>
</body>
</html>