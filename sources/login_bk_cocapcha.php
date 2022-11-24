<?php 

#Kiểm tra nếu đã đăng nhập thì chuyển vào trang index.php
if(isset($user_ses)){
    header('location:index.php');
 };

 function test_input($conn, $data) {
    $data = trim($data); //loại bỏ ký tự không cần thiết như khoảng trắng, tab, xuống dòng
    $data = stripslashes($data); //bỏ dấu gạch chéo "\" ra khỏi chuỗi
    $data = htmlspecialchars($data); //chuyển các ký tự đặc biệt thành các ký tự HTML entity  (vd: < thành &lt;)
    // https://www.w3schools.com/html/html_entities.asp
    $data = mysqli_real_escape_string($conn, $data);
    return $data;
}

session_start();
# biến mở kết nối tới MySQL server
$connect = mysqli_connect("localhost", "nbp1", "passMySQL", "fruit_shop");
?>

<?php include 'include/header.php'; ?>
	<body>
    <?php
        // When form submitted, check and create user session.
        if (isset($_POST['submit']) && $_POST['g-recaptcha-response']!="" ) {
            $secret = '6LdZ8QQjAAAAAD_PJjlRelJyEaox-hf8dyeNq1J3';
            $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.$_POST['g-recaptcha-response']);
            $responseData = json_decode($verifyResponse);
            if($responseData->success)
            { 
                $username = stripslashes($_REQUEST['username']);    
                $username = mysqli_real_escape_string($connect, $username);
                $password = stripslashes($_REQUEST['password']);
                $password = mysqli_real_escape_string($connect, $password);
                // Check user is exist in the database
                $query    = "SELECT * FROM `users` WHERE username='$username'
                            AND password='" . md5($password) . "'";
                $result = mysqli_query($connect, $query) or die(mysql_error());
                $result2 = mysqli_query($connect, "SELECT * FROM `users` WHERE username='$username' AND role = 'admin'
                AND password='" . md5($password) . "'") or die(mysql_error());
                
                // nếu tất cả tham số đều đã được check và không có lỗi xảy ra
                // nếu role là admin thì tới trang admin (quản lý user và product)
                if (mysqli_num_rows($result2) > 0) {
                    $row = mysqli_fetch_assoc($result2);
                    $_SESSION['sadmin'] = $row['id_user'];
                    header("Location: admin.php");
                } else if (mysqli_num_rows($result) > 0) {
                    $row = mysqli_fetch_assoc($result);
                    $_SESSION['user_ses'] = $row['id_user'];   
                    //với tính năng remember me, nếu ta không logout, thì ta sẽ không phải đăng nhập lại khi trong 1 tháng
                    if (isset($_POST['remember'])) {
                        // $params = session_get_cookie_params();
                        // setcookie(session_name(), $_COOKIE[session_name()], time() + 60*60*24*30, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
                        setcookie('user_ses', $row['username'], time() + 60*60*24*30);
                    }               
                    header("Location: index.php");
                } else {
                    echo "<div class='form'>
                        <h3>Incorrect Username/password.</h3><br/>
                        <p class='link'>Click here to <a href='login.php'>Login</a> again.</p>
                        </div>";
                }
            }
        } else {
    ?>
        <div class="container">
                <form class="form" method="post" name="login">
                    <h1 class="login-title">Login</h1>
                    <hr>
                    <input type="text" class="login-input" name="username" placeholder="Username" autofocus="true"/>
                    <input type="password" class="login-input" name="password" placeholder="Password"/>
                    <div class="g-recaptcha" data-sitekey="6LdZ8QQjAAAAAMD9ep928yPu2E7-vhj9EvpImGkF"></div>
                    <input type="submit" value="Login" name="submit" class="login-button"/>
                    <input type="checkbox" name="remember" id="remember">Remember me</label>
                    <hr>
                    <p class="link"><a href="register.php">New Registration</a></p>

                </form>
        <?php
            }
        ?>
        </div>
</body>
</html>