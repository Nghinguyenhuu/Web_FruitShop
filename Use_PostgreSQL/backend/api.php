<?php
// api.php
error_reporting(E_ALL); ini_set('display_errors', 1);
header('Content-Type: application/json');

// Kết nối đến cơ sở dữ liệu
include "connect.php";

// Hàm xác thực người dùng
function authenticateUser($conn2, $username, $password) {
    $query = "SELECT * FROM users WHERE username='$username' AND password='" . md5($password) . "'";
    
    $result = pg_query($conn2, $query);

    if (pg_num_rows($result) > 0) {
        return true;
    } else {
        return false;
    }
}

$res = ['success' => false];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if (authenticateUser($conn2, $username, $password)) {
        $res = [
			"status" => 1,
			"msg"    => "Login success!!!"
		];
        
    } else {
        $res = [
			"status" => -1,
			"msg"    => "Login failed!!!"
		];
    }
}

echo json_encode($res);
?>
