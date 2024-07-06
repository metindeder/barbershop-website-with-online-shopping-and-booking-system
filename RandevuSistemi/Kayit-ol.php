<?php
require_once "config.php";//veritabani baglantisi ekler



if(isset($_POST["kaydet"]))
{
    $form_username = $_POST["username"];
    $form_password = $_POST["password"];
    $form_telno = $_POST["tel-no"];


    if (strlen($_POST["password"])<8)//sifre kontrolu
    {
        echo '<script> alert("Şifre 8 karakterden küçük olamaz.");</script>';
    }
    //kullanici adi kontrolu
    else if (!preg_match('/^[a-z\d_]{5,20}$/i', $_POST["username"]))
{
echo '<script> alert("Kullanıcı adı büyük küçük harf ve rakamdan oluşmalıdır.");</script>';
}
// telefon kontrolu
else if (strlen($form_telno)<10 || !ctype_digit($form_telno)) {
    
    echo '<script> alert("Lütfen geçerli bir telefon numarası giriniz.");</script>';
    }
    else {      
$ekle="INSERT INTO musteri (username,no,password) VALUES ('$form_username','$form_telno','$form_password')";//kontrollerden sonra gelen verileri musteri tablosuna ekler
$calistirekle=mysqli_query($db,$ekle);
if(mysqli_errno($db) != 0)
{
    echo '<script>alert("Bir hata meydana geldi!");</script>';
    exit;
}

echo '<script>alert("Kayıt başarılı!");</script>';
header("Refresh: 2; url=Giris-yap.php");
}
}

?>

<!DOCTYPE html>
<html lang="tr">

<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width,
initial-scale=1.0">
<title>Kayıt ol</title>
<link rel="icon" type="image/x-icon" href="resimler/favicon.ico">
<link rel="stylesheet" href="css/uyelik.css">
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>

<body>

<div class="giris">
<form action="Kayit-ol.php" method="POST" onsubmit="saveCredentials()">
<h1>KAYIT OL</h1>
<div class="yazikutusu">
<input type="text" placeholder="Kullanıcı Adı" name="username"
required>
<i class='bx bxs-user' ></i>
</div>
<div class="yazikutusu">
<input type="text" placeholder="Telefon" name="tel-no"
required>
<i class='bx bxs-phone'></i>
</div>
<div class="yazikutusu">

<input type="password"
placeholder="Şifre" name="password" required>
<i class='bx bxs-lock-alt' ></i>
</div>


<button type="submit" name="kaydet" class="btn">KAYIT OL</button>

<div class="kaydol">
<p>Hesabın varmı? Hemen <a
href="Giris-yap.php">Giriş  Yap</a></p>
</div>


</form>
</div>
<script>
        // Sayfa yüklendiğinde çalışacak fonksiyon
        window.onload = function () {
            const username = sessionStorage.getItem("username");//kayitli form verilerini tanimlar
            const telNo = sessionStorage.getItem("tel-no");
            const password = sessionStorage.getItem("password");
            if (username) document.querySelector("input[name='username']").value = username;//kayitli form verilerini yerlerine yazar
            if (telNo) document.querySelector("input[name='tel-no']").value = telNo;
            if (password) document.querySelector("input[name='password']").value = password;
        }

        // Form gönderildiğinde sessionStorage'ı güncelleyen fonksiyon
        function saveCredentials(event) {
            const username = document.querySelector("input[name='username']").value;
            const telNo = document.querySelector("input[name='tel-no']").value;
            const password = document.querySelector("input[name='password']").value;
            sessionStorage.setItem("username", username);//verileri gunceller
            sessionStorage.setItem("tel-no", telNo);
            sessionStorage.setItem("password", password);
        }
    </script>

</body>

</html>