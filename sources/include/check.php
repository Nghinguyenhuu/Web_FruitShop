<?php

function test_input($conn, $data) {
   $data = trim($data); //loại bỏ ký tự không cần thiết như khoảng trắng, tab, xuống dòng
   $data = stripslashes($data); //bỏ dấu gạch chéo "\" ra khỏi chuỗi
   $data = htmlspecialchars($data); //chuyển các ký tự đặc biệt thành các ký tự HTML entity  (vd: < thành &lt;)
   // https://www.w3schools.com/html/html_entities.asp
   $data = mysqli_real_escape_string($conn, $data); //loại bỏ những ký tự có thể gây ảnh hưởng database
   return $data;
}
function check_upload_image($image){
    // không tải file lên nếu không xuất hiện lỗi
    if ($_FILES[$image]['error'] !== UPLOAD_ERR_OK) {
        die("Upload failed with error code " . $_FILES[$image]['error']);
    }
    // lấy thông tin của ảnh, không lấy được thì lỗi
    $info = getimagesize($_FILES[$image]['tmp_name']);
    if ($info === FALSE) {
        die("Unable to determine image type of uploaded file");
    }
    // không tải file lên nếu không phải là gif, jpeg, png
    if (($info[2] !== IMAGETYPE_GIF) && ($info[2] !== IMAGETYPE_JPEG) && ($info[2] !== IMAGETYPE_PNG)) {
        die("Not a gif/jpeg/png");
    }
    // https://stackoverflow.com/questions/9314164/php-uploading-files-image-only-checking
}

?>