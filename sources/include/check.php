<?php

function test_input($conn, $data) {
    $data = trim($data);
    $data = stripslashes($data); 
    $data = htmlspecialchars($data); 
    $data = mysqli_real_escape_string($conn, $data);
    return $data;
}
function check_upload_image($image){
    if ($_FILES[$image]['error'] !== UPLOAD_ERR_OK) {
        die("Upload failed with error code " . $_FILES[$image]['error']);
    }
    $info = getimagesize($_FILES[$image]['tmp_name']);
    if ($info === FALSE) {
        die("Unable to determine image type of uploaded file");
    }
    if (($info[2] !== IMAGETYPE_GIF) && ($info[2] !== IMAGETYPE_JPEG) && ($info[2] !== IMAGETYPE_PNG)) {
        die("Not a gif/jpeg/png");
    }
}
function check_length_pass($pass){
    if (strlen($pass) < 8) {
        die("Password must have at least 8 characters");
    }
}
?>