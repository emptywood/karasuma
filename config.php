<?php
// 環境ごとに設定変更要 -------
$host = 'localhost';
$dbname = 'karasuma';
$dbuser = 'root';
$dbpass = '';
// ------------------------
$dsn = "mysql:host={$host};dbname={$dbname};charset=utf8";
$pdo = new PDO($dsn, $dbuser, $dbpass);

?>
