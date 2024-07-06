<?php require_once "config.php";//veritabani baglantisi ekler

if($_SESSION["username"]=="")
{
    header("location:Giris-yap.php");//giris yapilmamissa giris sayfasini acar
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
            <li class="menu aktif">
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
        <h1>RANDEVULAR</h1>
       
        <?php
        $form_username = $_SESSION["username"];
        $randevu=mysqli_query($db,"SELECT* FROM randevu WHERE musteri='$form_username'");//randevu tablosundan musteri idsine sahip olanlari secer
        $num= mysqli_num_rows($randevu);//randevu sayisi
        if($num==0){
            echo '<div class="randevuhata"><i class="icon ion-android-alert"></i>  Randevu Bulunamadı!</div>';
        }
        else {
            echo "<table>";
            echo "<tr><th>Müşteri</th><th>Randevu ID</th><th>Randevu Tarihi</th><th>Randevu Saati</th><th>İşlemler</th></tr>";
            while ($gelen = mysqli_fetch_array($randevu)) {//gelen randevulari dizi seklinde tanimlar ve donguyle tek tek yazar
                echo "<tr>";
                echo "<td>" . $gelen["musteri"] . "</td>";
                echo "<td>" . $gelen["id"] . "</td>";
                echo "<td>" . $gelen["date"] . "</td>";
                echo "<td>" . $gelen["time"] . "</td>";
                echo "<td class='islem-butonlari'>
                <form method='POST' action='fonksiyonlar/randevusil.php' style='display:inline; margin:0;'>
                    <input type='hidden' name='randevu_id' value='" . $gelen["id"] . "'>
                    <input type='submit' value='X' class='sil'>
                </form>
                <form method='POST' action='fonksiyonlar/randevuguncelle.php' style='display:inline; margin:0;'>
                    <input type='hidden' name='randevu_id' value='" . $gelen["id"] . "'>
                    <input type='submit' value='↻' class='guncelle'>
                </form>
              </td>";
                echo "</tr>";
            }
            echo "</table>";
            
        }
   
        ?>
        </div>
</body>
</html>
