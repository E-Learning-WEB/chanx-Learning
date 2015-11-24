<?php

$db2 = new PDO('mysql:host=127.0.0.1;port=3306;dbname=learning;charset=UTF8;','root',''); //pindah ke pdo
//$db2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Set Errorhandling to Exception




$db = new mysqli("127.0.0.1", "root", "", "learning");

?>