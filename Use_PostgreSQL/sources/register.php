<?php 
    session_start();
    # biến mở kết nối tới MySQL server
    #$conn = mysqli_connect("localhost", "nbp1", "passMySQL", "fruit_shop");
    include "include/connect.php";

    function test_input($conn2, $data) {
        $data = trim($data); //loại bỏ ký tự không cần thiết như khoảng trắng, tab, xuống dòng
        $data = stripslashes($data); //bỏ dấu gạch chéo "\" ra khỏi chuỗi
        $data = htmlspecialchars($data); //chuyển các ký tự đặc biệt thành các ký tự HTML entity  (vd: < thành &lt;)
        // https://www.w3schools.com/html/html_entities.asp
        //$data = mysqli_real_escape_string($conn, $data);
        $data = pg_escape_string($conn2, $data);
        return $data;
    }

?>
<?php include 'include/header.php'; ?>
<body>
    <div class="container">
        <?php
            // When form submitted, insert values into the database.
            if (isset($_POST['username'])) {
                $username = test_input($conn2, $_POST['username']);
                $password = test_input($conn2, $_POST['password']);
                $name = test_input($conn2, $_POST['name']);
                $email = test_input($conn2, $_POST['email']);
                $contact = test_input($conn2, $_POST['contact']);

                if (!preg_match("/^\\+?[1-9][0-9]{7,14}$/", $contact)) {
                    echo "<script>
                    alert('Phone number is invalid! Please input again!');
                    </script>";
                    
                }
                else if (!preg_match("/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/", $email)) {
                    echo "<script>alert('Email is invalid! Please input again!');
                    </script>";
                }
                else {

                //$query    = "INSERT into `users` (username, password, name, email, phone_number, role)
                            // VALUES ('$username', '" . md5($password) . "', '$name', '$email', '$contact', 'user')";
                // $result   = mysqli_query($conn, $query);
                $query = "INSERT into users (username, password, name, email, phone_number, role)
                            VALUES ('$username', '" . md5($password) . "', '$name', '$email', '$contact', 'user')";
                $result = pg_query($conn2, $query) or die('Query failed: ' . pg_last_error());
                if ($result) {
                    echo "<div class='form'>
                        <h3>You are registered successfully.</h3><br/>
                        <p class='link'>Click here to <a href='login.php'>Login</a></p>
                        </div>";
                } else {
                    echo "<div class='form'>
                        <h3>Required fields are missing.</h3><br/>
                        <p class='link'>Click here to <a href='registration.php'>registration</a> again.</p>
                        </div>";
                }
            } 
            }
            else {
        ?>

            <h1 class="login-title">Registration</h1> 
            <hr>

        <form class="form-horizontal" method="POST" action="" enctype="multipart/form-data">
            <div class="form-group">
                <label for="user name" class="col-sm-3 control-label">User Name</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="username" name="username" placeholder = "User Name" required>
                </div>
                </div>
                <div class="form-group">
                    <label for="name" class="col-sm-3 control-label">Name</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="name" name="name" placeholder = "Name" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="email" class="col-sm-3 control-label">Email</label>
                    <div class="col-sm-9">
                        <input type="email" class="form-control" id="email" name="email" placeholder = "Email" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="password" class="col-sm-3 control-label">Password</label>
                    <div class="col-sm-9">
                        <input type="password" class="form-control" id="password" name="password" placeholder = "Password" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="contact" class="col-sm-3 control-label">Contact Info</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="contact" name="contact" placeholder = "Phone number" required>
                    </div>
                </div>     
                <hr>   
                <input type="submit" name="submit" value="Register" class="login-button">
                <p class="link"><a href="login.php">Click to Login</a></p>            
            </div>
                
        </form>
    <?php } ?>
    </div>
</body>
</html>
