<?php 

$dbh['host'] = "localhost";
$dbh['user'] = "root";
$dbh['pass'] = "Ferd1n4ndasd";
$dbh['name'] = "vkvxweok_mbd_05111640000033";

$db = new mysqli($dbh['host'], $dbh['user'], $dbh['pass'], $dbh['name']);

if ($db->connect_errno) {
    printf("Connect failed: %s\n", $db->connect_error);
    exit();
}

 ?>