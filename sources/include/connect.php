<?php
//connect to db when use docker compose
$conn = new mysqli("db", "nbp1", "passMySQL", "fruit_shop");
// when use xampp to deploy
//$conn = new mysqli("localhost", "nbp1", "passMySQL", "fruit_shop");
?>