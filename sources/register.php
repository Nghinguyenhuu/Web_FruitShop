<?php 
    session_start();
    # biến mở kết nối tới MySQL server
    #$conn = mysqli_connect("localhost", "nbp1", "passMySQL", "fruit_shop");
    include "include/connect.php";

    function test_input($conn, $data) {
        $data = trim($data); //loại bỏ ký tự không cần thiết như khoảng trắng, tab, xuống dòng
        $data = stripslashes($data); //bỏ dấu gạch chéo "\" ra khỏi chuỗi
        $data = htmlspecialchars($data); //chuyển các ký tự đặc biệt thành các ký tự HTML entity  (vd: < thành &lt;)
        // https://www.w3schools.com/html/html_entities.asp
        $data = mysqli_real_escape_string($conn, $data);
        return $data;
    }

?>
<?php include 'include/header.php'; ?>
<body>
    <div class="container">
        <?php
            // When form submitted, insert values into the database.
            if (isset($_POST['username'])) {
                // // removes backslashes
                // $username = stripslashes($_POST['username']);
                // //escapes special characters in a string
                // $username = mysqli_real_escape_string($conn, $username);

                // $password = stripslashes($_POST['password']);
                // $password = mysqli_real_escape_string($conn, $password);

                // $name = stripslashes($_POST['name']);
                // $name = mysqli_real_escape_string($conn, $name);

                // $email = stripslashes($_POST['email']);
                // $email = mysqli_real_escape_string($conn, $email);

                // $contact = stripslashes($_POST['contact']);
                // $contact = mysqli_real_escape_string($conn, $contact);

                $username = test_input($conn, $_POST['username']);
                $password = test_input($conn, $_POST['password']);
                $name = test_input($conn, $_POST['name']);
                $email = test_input($conn, $_POST['email']);
                $contact = test_input($conn, $_POST['contact']);

                //regex lấy từ mạng, chưa tìm hiểu kỹ
                if (!preg_match("/^\\+?[1-9][0-9]{7,14}$/", $contact)) {
                    echo "Phone number is invalid";
                    exit();
                }
                if (!preg_match("/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/", $email)) {
                    echo "Email is invalid";
                    exit();
                }
                // if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                //     $emailErr = "Invalid email format";
                //   }


                $query    = "INSERT into `users` (username, password, name, email, phone_number, role)
                            VALUES ('$username', '" . md5($password) . "', '$name', '$email', '$contact', 'user')";
                $result   = mysqli_query($conn, $query);
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
            } else {
        ?>

            <h1 class="login-title">Registration</h1> 
            <hr>

        <!-- <form class="form " action="" method="post">
            <h1 class="login-title">Registration</h1> 
            <hr>
            <ul class="list-unstyled">
                <li><label><b>User Name</b></label></li>       
                <li><input type="text" class="login-input" name="username" placeholder="Username" required /></li> 
                <li><label><b>Email</b></label> </li> 
                <li><input type="email" name="email" placeholder="Email" required /></li> 
                <li><label><b>Phone Number</b></label> </li> 
                <li><input type="tel" name="phone_number" placeholder="Phone Number" required /></li> 
                <li><label><b>Password</b></label> </li> 
                <li><input type="password" class="login-input" name="password" placeholder="Password"></li> 
            </ul>
            <hr>
            <input type="submit" name="submit" value="Register" class="login-button">
            <p class="link"><a href="login.php">Click to Login</a></p>
        </form> -->

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
    <?php
        }
    ?>
    </div>
</body>
</html>
