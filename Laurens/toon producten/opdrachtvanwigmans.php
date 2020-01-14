<?php
include "module.php";
$conn = connect();
$conn = $conn -> query("SELECT * FROM product");
printer($conn->fetchAll())
?>