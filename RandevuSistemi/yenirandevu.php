<?php require_once "config.php";//veritabani baglantisi ekler

if($_SESSION["username"]=="")
{
    header("location:Giris-yap.php");//giris yapilmamissa giris sayfasini acar
}
if (isset($_POST["ekle"])) {

    $form_username = $_SESSION["username"];//gelen bilgileri tanimlar
    $form_date = date('Y-m-d', strtotime($_POST["date"]));
    $form_time = $_POST["time"];
    $bugun = date('Y-m-d');
    $intform_time=(int)$form_time;
    if ($form_date < $bugun) { //saat ve tarih kontrolleri
        echo '<script>alert("Geçmiş bir tarih seçemezsiniz!");</script>';
    } 
    else if($intform_time > 22 || $intform_time < 8){
        echo '<script>alert("Şubemiz saat 08.00-22.00 saatleri arasında hizmet vermektedir!");</script>';
    }
    else {
    // Müşteri bilgilerini al
    $musteri = mysqli_query($db, "SELECT * FROM musteri WHERE username='$form_username'");

    $num1 = mysqli_num_rows($musteri);//gelen veri sayisi

    if ($num1 > 0) {
        $musteribilgi = mysqli_fetch_assoc($musteri);

        // Aynı tarih ve saatte bir randevu olup olmadığını kontrol et
        $check_randevu = mysqli_query($db, "SELECT * FROM randevu WHERE date='$form_date' AND time='$form_time'");
        $num2 = mysqli_num_rows($check_randevu);

        if ($num2 > 0) {
            // Aynı tarihte ve saatte randevu varsa hata mesajı göster
           echo '<script>alert("Bu tarihte ve saatte zaten bir randevu var!");</script>';
        } else {
            // Randevu yoksa yeni randevu oluştur
            mysqli_query($db, "INSERT INTO randevu (musteri, date, time) VALUES ('" . $musteribilgi['username'] . "', '" . $form_date . "', '" . $form_time . "')");//randevu tablosuna veri ekler
            echo '<script> alert("Randevunuz Oluşturuldu!");</script>';
            header("Location: randevular.php");
            exit;
        }
    } else {
        echo '<script> alert("Kullanıcı bulunamadı!");</script>';
    }
}
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
<style>


     
    </style>
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
            <li class="menu aktif">
                <a href="yenirandevu.php">
                <span class="menu-icon"><i class="icon ion-plus-circled"></i></span>
                <span class="menu-text">YENİ RANDEVU</span>
                </a>
            </li>
            <li class="menu">
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
        <h1>YENİ RANDEVU</h1>
        <div class="rform">
    <form action="yenirandevu.php" method="POST">
        <h2>Randevu Bilgilerinizi Giriniz</h2>
        <hr> <br>
        <label for="Date">Tarih : <input type="date" name="date"><br>
        <label for="Time">Saat : <input type="time" name="time" step="1800"><br>
        <button type="submit" name="ekle">Randevu Al</button>
    </form>
    
</div>
    </div>
    
  
</body>
</html>
