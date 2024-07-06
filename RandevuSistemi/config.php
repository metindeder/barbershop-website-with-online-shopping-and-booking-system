<?php
session_start();//oturum baslatir

$db_host = "localhost"; //veritabani sunucusu
$db_user = "root";//veritabani kullanici adi
$db_pass = ""; //veritabani sifresi
$db_name = "berber"; //veritabani adi


$db= mysqli_connect($db_host,$db_user,$db_pass,$db_name);//veritabani baglantisini db degiskeniyle bagdastirdik
mysqli_set_charset($db,"UTF8");//veritabani harf duzeni utf8 olarak ayarla
if(mysqli_connect_errno()){//baglanti sirasinda hata alinirsa
    echo "Bağlantı kurulamadı";
    exit();
}

$admins = [ //admin listesi
    "admin" => "4747"

]

?>