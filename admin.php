<?php
$name="CCT123";
$password="CCT3034";
$host = '127.0.0.1';
$dbname = 'library';
$user = 'root';
$pass = '';
# MySQL with PDO_MYSQL
$DBH = new PDO("mysql:host=$host;dbname=$dbname", $user,$pass);
$phash = password_hash($password, PASSWORD_BCRYPT);
$stmt = $DBH->prepare("insert into admin (username, password)
values (?,?)");
$stmt->bindParam(1, $name);
$stmt->bindParam(2, $phash);
$stmt->execute();
?>