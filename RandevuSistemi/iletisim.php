<?php require_once "config.php";//veritabani baglantisi ekler

if($_SESSION["username"]=="")
{
    header("location:Giris-yap.php");
}
if (isset($_POST["gonder"])) {

    $form_username = $_SESSION["username"];
    $form_message = $_POST["mesaj"];
       
        $musteri = mysqli_query($db, "SELECT * FROM musteri WHERE username='$form_username'");//musteri tablosunda kullanici adina gore kullaniciyi secer
        $musteribilgi = mysqli_fetch_assoc($musteri);//musteri bilgilerini dizi olarak degiskene atar
        mysqli_query($db, "INSERT INTO iletisim (musteri, mesaj) VALUES ('" . $musteribilgi['username'] . "', '" . $form_message . "')");//musteri mesajini musteri bilgileriyle beraber iletisim tablosuna kaydeder
        echo '<script> alert("Mesaj Gönderildi!");</script>';
        header("Refresh: 1; url=iletisim.php");
        exit;
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Randevular</title>
    <link rel="icon" type="image/x-icon" href="resimler/favicon.ico">
    <link rel='stylesheet' href='//code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css'>
    <link rel="stylesheet" href="css/adminpanel.css">
</head>

<body>
    <div class="yanpanel">
        <div class="yanpanel-baslik">
            <span class="logo"><i class="icon ion-scissors"></i></span>
            <span class="title">SIU Erkek Kuaforu</span>
        </div>
        <ul class="yanpanel-menu">
            <li class="menu">
            <a href="Randevular.php">
                <span class="menu-icon"><i class="icon ion-calendar"></i></span>
                <span class="menu-text">RANDEVULAR</span>
                </a>
            </li>
            <li class="menu">
                <a href="yenirandevu.php">
                <span class="menu-icon"><i class="icon ion-plus-circled"></i></span>
                <span class="menu-text">YENİ RANDEVU</span>
                </a>
            </li>
            <li class="menu aktif">
                <a href="iletisim.php">
                <span class="menu-icon"><i class="icon ion-android-mail"></i></span>
                <span class="menu-text">İLETİŞİM</span>
                </a>
            </li>
            
            
        </ul>
        <div class="yanpanel-alt">
            <span class="welcome">HOŞGELDİN !<hr><br><i class="icon ion-person"></i> <?php echo strtoupper($_SESSION["username"]); ?></span>
            <br><br><br>
            <form action="fonksiyonlar/cikis.php" method="post">
            <button type="submit" name="cikis"class="cikis"><i class="icon ion-log-out"></i><br>Çıkış Yap</button>
</form>
        </div>
    </div>
    <div class="icerik">
        <h1>İLETİŞİM</h1>
        <div class="rform">
    <form action="iletisim.php" method="POST">
        <h2>Mesajınızı Giriniz</h2>
        <hr> <br>
        <label for="text">Mesajınız : <input type="text" name="mesaj"><br>
        
        <button type="submit" name="gonder">GÖNDER</button>
    </form>
        </div>
</body>
</html>
