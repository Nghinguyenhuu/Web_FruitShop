<?php
// api.php
error_reporting(E_ALL); ini_set('display_errors', 1);
header('Content-Type: application/json');
session_start();
// Kết nối đến cơ sở dữ liệu
include "connect.php";
include "utility.php";

// check $action
$action = getPOST('action');


switch ($action) {
	case 'login':
		authenticateUser($conn2);
		break;
	case 'checkAccessPage':
		checkAccessPage($conn2);
		break;
	case 'register':
		doRegister($conn2);
		break;
	case 'list':
		doUserList();
		break;
    case 'checkSession':
        doCheckSession();
        break;
}


// Hàm xác thực người dùng
function authenticateUser($conn2) {
    
    $username = getPOST('username');
	$password = getPOST('password');
    $query = "SELECT * FROM users WHERE username='$username' AND password='" . md5($password) . "'";
    $result = pg_query($conn2, $query);
    if (pg_num_rows($result) > 0) {
        $id_user = getIdUser($conn2, $username, $password);
        if (checkAdminOrUser($conn2, $username, $password)) {
            $res = [
                "status" => 1,
                "msg"    => "Login success!!!",
                "role" => "admin",
                "id_user" => $id_user
            ];
            $_SESSION['sadmin'] = $id_user;
        } else {
            $res = [
                "status" => 1,
                "msg"    => "Login success!!!",
                "role" => "user",
                "id_user" => $id_user
            ];
            $_SESSION['user_ses'] = $id_user;
        }
    } else {
        $res = [
			"status" => -1,
			"msg"    => "Login failed!!!"
		];
    }

    echo json_encode($res);
}

// check admin or user and response user_session
function checkAdminOrUser($conn2, $username, $password) {
    $query = "SELECT * FROM users WHERE username='$username' AND role = 'admin'";
    
    $result = pg_query($conn2, $query);

    if (pg_num_rows($result) > 0) {
        return true;
    } else {
        return false;
    }
}
// get id_user
function getIdUser($conn2, $username, $password) {
    $query = "SELECT * FROM users WHERE username='$username' AND password='" . md5($password) . "'";
    $result = pg_query($conn2, $query);
    if (pg_num_rows($result) > 0) {
        $row = pg_fetch_assoc($result);
        return $row['id_user'];
    } else {
        return false;
    }
}
// check access page
function checkAccessPage($conn2) {

    if (!isset($_SESSION['user_ses']) && !isset($_SESSION['sadmin'])) {
        $res = [
            "status" => -1,
            "msg"    => "No access!!!",
            'role' => 'guest'
        ];
    }
    else if (isset($_SESSION['user_ses'])) {
        $res = [
            "status" => 1,
            "msg"    => "User Access!!!",
            "role" => "user"
        ];
    }
    else if (isset($_SESSION['sadmin'])) {
        $res = [
            "status" => 1,
            "msg"    => "Admin Access!!!",
            "role" => "admin"
        ];
    }
    else {
        $res = [
            "status" => -1,
            "msg"    => "No access!!!"
        ];
    }

    echo json_encode($res);
}

// doRegister
function doRegister($conn2){
    $username = getPOST('username');
    $password = getPOST('password');
    $name = getPOST('name');
    $email = getPOST('email');
    $contact = getPOST('contact');
    $query = "INSERT INTO users (username, password, name, email, phone_number, role) VALUES ('$username', '" . md5($password) . "', '$name', '$email', '$contact', 'user')";
    $result = pg_query($conn2, $query);
    if ($result) {
        $res = [
            "status" => 1,
            "msg"    => "Register success!!!"
        ];
    } else {
        $res = [
            "status" => -1,
            "msg"    => "Register failed!!!"
        ];
    }

    echo json_encode($res);
}
?>
