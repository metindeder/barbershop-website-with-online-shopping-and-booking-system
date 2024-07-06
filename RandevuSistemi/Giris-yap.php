<?php
require_once "config.php";//veritabani baglantisi ekler


if(isset($_POST["giris"]))
{
    $form_usernname = $_POST["username"];
    $form_password = $_POST["password"];
   
    $giris=mysqli_query($db,"SELECT* FROM musteri WHERE username='$form_usernname' AND password='$form_password' ");//gonderilen bilgileri musteri tablosunda arar 
    $kayitsayisi= mysqli_num_rows($giris);//kayitsayisi degiskenine bulunan satir sayisini ata
    $kullanici= mysqli_fetch_assoc($giris);//gelen bilgileri kullanici degiskenine dizi olarak ata
    $kontrol = false;

    foreach ($admins as $adm_name => $adm_pass ){//admin dizisini foreach dongusuyle oku
        if ($adm_name == $form_usernname && $adm_pass == $form_password){
           
                // girildi
                $kontrol=true;

        }
    }
    if ($kontrol==true){//giren kisi adminse admin oturumunu aktif et
       
        $_SESSION["admingirdi"]= "1";
        $_SESSION["username"]="$form_usernname";
        $_SESSION["password"]="$form_password";
        echo '<script> alert("Admin Olarak Giriş Yapıldı");</script>';
       header("location:admin.php");
        exit;
    }

    if($kayitsayisi==0){//kayit bulunmadiysa hata ver
        echo '<script> alert("Şifre veya Kullanıcı Adı yanlış!");</script>';
    }
    else if($kayitsayisi==1){//kayit bulunduysa oturumu baslat
        
        $_SESSION["admingirdi"]= "0";
        $_SESSION["username"]="$form_usernname";//oturum kullanici adi olarak tanimladik
        $_SESSION["password"]="$form_password";
        header("location:randevular.php");
        exit;
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
<title>Giriş Yap</title>
<link rel="icon" type="image/x-icon" href="resimler/favicon.ico">
<link rel="stylesheet" href="css/uyelik.css">
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>

<body>

<div class="giris">
<form action="Giris-yap.php" method="POST" onsubmit="saveCredentials()">
<h1>GİRİŞ YAP</h1>
<div class="yazikutusu">
<input type="text" placeholder="Kullanıcı Adı" name="username"
required>
<i class='bx bxs-user' ></i>
</div>
<div class="yazikutusu">

<input type="password"
placeholder="Şifre" name="password" required>
<i class='bx bxs-lock-alt' ></i>
</div>


<button type="submit" name="giris" class="btn">Giriş</button>

<div class="kaydol">
<p>Hesabın yokmu? Hemen <a
href="kayit-ol.php">Kayıt ol</a></p>
</div>


</form>
</div>
<script>
        // Sayfa yüklendiğinde çalışacak fonksiyon
        window.onload = function () {
            const username = sessionStorage.getItem("username");//kayitli verileri tanimlar
            const password = sessionStorage.getItem("password");
            if (username) document.querySelector("input[name='username']").value = username;//forma kayitli veriyi ekler
            if (password) document.querySelector("input[name='password']").value = password;
        }

        // Form gönderildiğinde sessionStorage'ı güncelleyen fonksiyon tarayici kapanana kadar form verilerini saklar
        function saveCredentials(event) {
            const username = document.querySelector("input[name='username']").value;
            const password = document.querySelector("input[name='password']").value;
            sessionStorage.setItem("username", username);//verileri kaydeder
            sessionStorage.setItem("password", password);
        }
    </script>

</body>

</html>
