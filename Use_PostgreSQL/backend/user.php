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






?>