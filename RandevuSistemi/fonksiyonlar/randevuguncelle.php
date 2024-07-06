<?php 
require_once "../config.php";//veritabani baglantisi ekler

if($_SESSION["username"]=="")//giris yapilmamissa giris sayfasina oto yonlendirme
{
    header("location:Giris-yap.php");
}
if(isset($_POST["randevu_id"]))
{
    $randevu_id = $_POST['randevu_id']; //gelen randevu id sini tanimlama
    $date = "";
    $time = "";
    $query = "SELECT * FROM randevu WHERE id = '$randevu_id' "; //randevu tablosunda gelen idye gore secer
    $result = $db->query($query); //sonuc degiskenine secilen randevuyu atar
    if ($result->num_rows == 1) {//eger bulduysa gerceklesecek islemler
        $row = $result->fetch_assoc();// fonksiyon SQL sorgusunda etkilenen satırı dizi şeklinde geri döndürür.
        $date = $row["date"]; // tarih ve zamani forma eklemek icin tanimladim
        $time = $row["time"];
    }
}

if (isset($_POST["guncelle"])) {
    $randevu_id = $_POST['randevu_id'];
    $new_date = $_POST["date"];
    $new_time = $_POST["time"];
    $intnew_time=(int)$new_time;
    if($intnew_time > 22 || $intnew_time < 8){
        echo '<script>alert("Şubemiz saat 08.00-22.00 saatleri arasında hizmet vermektedir!");</script>';
    }
    else {
    $update_query = "UPDATE randevu SET date = '$new_date', time = '$new_time'  WHERE id = ?";//randevu tablosunda id ye gore yeni tarih ve saat guncellemesi yapar
    if ($update_stmt = $db->prepare($update_query)) {/*prepare($update_query): Bu satır, belirtilen SQL sorgusunu hazırlar. Hazırlanan sorguyu çalıştırmadan önce, sorgudaki yer tutucuları (örneğin ? karakteri) belirli bir veri türüne bağlamak için kullanılacak parametreleri sorguya eklemek için kullanılır. Bu, sorgunun tekrar kullanılabilirliğini artırır ve SQL enjeksiyon saldırılarına karşı koruma sağlar. */
        $update_stmt->bind_param("s", $randevu_id);/*bind_param("s", $randevu_id): Bu satır, sorgudaki yer tutucuları belirli bir veri türüne bağlar. "s" parametresi, yer tutucuya bir dize (string) değeri geçirildiğini belirtir. $randevu_id, bu yer tutucuya geçirilen değerdir. Bu işlem, SQL sorgusunun güvenliğini artırır ve doğru veri türlerinin kullanılmasını sağlar. */
        if ($update_stmt->execute()) {/*execute(): Bu satır, hazırlanan ve parametreleri bağlanmış olan SQL sorgusunu çalıştırır. Bu yöntem, sorguyu veritabanına gönderir ve sorgunun başarılı bir şekilde çalıştırılıp çalıştırılmadığını kontrol eder. Başarılı bir şekilde çalıştırılırsa true değeri döner, aksi halde false döner. */
            echo '<script>alert("Randevu başarıyla güncellendi.");</script>';
            if($_SESSION["admingirdi"]== "1"){
                header("Location:../admin.php"); 
            }
           else{
            header("Location:../Randevular.php");// Kullanıcı yönlendirme, eğer oturum yöneticiyse admin sayfasına, değilse Randevular sayfasına yönlendirme yapılır
           }
        } else {
            echo '<script>alert("Randevu güncelleme başarısız.");</script>';
            if($_SESSION["admingirdi"]== "1"){
                header("Location:../admin.php"); 
            }
           else{
            header("Location:../Randevular.php");
           }
        }
        $update_stmt->close(); // Prepare işlemi sonlandırılır
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
    <link rel="icon" type="image/x-icon" href="../resimler/favicon.ico">
    <link rel='stylesheet' href='//code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css'>
    <link rel="stylesheet" href="../css/adminpanel.css">
</head>
<body>
    <div class="yanpanel">
    <div class="yanpanel-baslik">
            <span class="logo"><i class="icon ion-scissors"></i></span>
            <span class="title">SIU Erkek Kuaforu</span>
        </div>
        <ul class="yanpanel-menu">
            <li class="menu aktif">
            <a href="../Randevular.php">
                <span class="menu-icon"><i class="icon ion-calendar"></i></span>
                <span class="menu-text">RANDEVULAR</span>
                </a>
            </li>
            <li class="menu">
                <a href="../yenirandevu.php">
                <span class="menu-icon"><i class="icon ion-plus-circled"></i></span>
                <span class="menu-text">YENİ RANDEVU</span>
                </a>
            </li>
            <li class="menu">
                <a href="../iletisim.php">
                <span class="menu-icon"><i class="icon ion-android-mail"></i></span>
                <span class="menu-text">İLETİŞİM</span>
                </a>
            </li>
            
            
        </ul>
        <div class="yanpanel-alt">
            <span class="welcome">HOŞGELDİN !<hr><br><i class="icon ion-person"></i> <?php echo strtoupper($_SESSION["username"]); ?></span>
            <br><br><br>
            <form action="cikis.php" method="post">
            <button type="submit" name="cikis"class="cikis"><i class="icon ion-log-out"></i><br>Çıkış Yap</button>
</form>
        </div>
    </div>
    <div class="icerik">
        <h1>RANDEVU GÜNCELLE</h1>
        <div class="rform">
    <form action="randevuguncelle.php" method="POST">
        <h2>Randevu Bilgilerinizi Giriniz</h2>
        <hr> <br>
        <input type="hidden" name="randevu_id" value="<?php echo $randevu_id; ?>">
        <label for="Date">Tarih : <input type="date" value="<?php echo $date; ?>" name="date"><br>
        <label for="Time">Saat : <input type="time" value="<?php echo $time; ?>" name="time" step="1800"><br>
        <button type="submit" name="guncelle">Randevu Güncelle</button>
    </form>
    
</div>
    </div>
    
  
</body>
</html>
