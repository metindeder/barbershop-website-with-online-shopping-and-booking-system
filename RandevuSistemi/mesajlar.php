<?php
require_once "config.php";//veritabani baglantisi ekler



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
            <a href="admin.php">
                <span class="menu-icon"><i class="icon ion-calendar"></i></span>
                <span class="menu-text">RANDEVULAR</span>
                </a>
            </li>
            <li class="menu aktif">
            <a href="mesajlar.php">
                <span class="menu-icon"><i class="icon ion-android-mail"></i></span>
                <span class="menu-text">MESAJLAR</span>
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
        <h1>MESAJLAR</h1>
       <?php
       if($_SESSION["admingirdi"]== "1"){//admin girisi yapilmissa calisir
        $giris=mysqli_query($db,"SELECT* FROM iletisim ");//iletisim tablosundan secim yapar 
        $tel=mysqli_query($db,"SELECT* FROM musteri ");// telefon verisi almak icin musteri tablosundan secim yapar
        $telefon=mysqli_fetch_array($tel);//gelen verileri dizi seklinde tanimlar
        if(!$giris ){
            echo '<br>Hata:' .
            mysqli_error($db);
            }
            $num= mysqli_num_rows($giris);
            if($num==0){
                echo '<div class="randevuhata"><i class="icon ion-android-alert"></i>  Mesaj Bulunamadı!</div>';
            }
            else {
            echo "<table>";
            echo "<tr><th>Müşteri</th><th>Telefon</th><th>Mesaj ID</th><th>Mesaj</th><th>İşlem</th></tr>";
            while ($gelen = mysqli_fetch_array($giris)) {//gelen bilgileri dizi olarak tanimlar ve donguyle teker teker yazar
                echo "<tr>";
                echo "<td>" . $gelen["musteri"] . "</td>";
                echo "<td>" . $telefon["no"] . "</td>";
                echo "<td>" . $gelen["id"] . "</td>";
                echo "<td>" . $gelen["mesaj"] . "</td>";
                echo "<td class='islem-butonlari'><form method='POST' action='fonksiyonlar/mesajsil.php' style='margin:0;'>
                          <input type='hidden' name='mesaj_id' value='" . $gelen["id"] . "'>
                          <input type='submit' value='Sil' class='sil' >
                      </form></td>";
                echo "</tr>";
            }
            echo "</table>";
        }
       }
        ?>
    </div>
</body>
</html>