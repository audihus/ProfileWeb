<?php 
date_default_timezone_set('Asia/jakarta');

$servername = "localhost";
$username = "root";
$password = "";
$db = "webdailyjurnal";

//membuat koneksi, menggunakan fungsi mysqli
$conn = new mysqli($servername,$username,$password,$db);

//mengecek koneksi
if($conn->connect_error){
    die("Connection failed : " .$conn->connect_error);
}

//echo "Connected successfully <hr>";
?>