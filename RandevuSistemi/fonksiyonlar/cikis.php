<?php
require_once "../config.php";

$_SESSION["admingirdi"]="0";//admin oturumunu sonlandir.

$_SESSION["username"]="";//kullanici adini varsayilana dondur
$_SESSION["password"]="";//sifreyi varsayilana dondur

session_destroy();//tum oturumlari sonlandir

session_start();//oturumu baslat
session_regenerate_id();// geçerli oturum kimliğini yenisiyle değiştirirken oturum bigisini korur
header("location:../../index.html");//giris sayfasina yonlendir

?>