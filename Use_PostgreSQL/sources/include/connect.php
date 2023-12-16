<?php
//connect to db
$conn = new mysqli("localhost", "nbp1", "passMySQL", "fruit_shop");
// connect to db of postgresql
$conn2 = pg_connect("host=localhost dbname=fruit_shop user=postgres password=admin123");
?>