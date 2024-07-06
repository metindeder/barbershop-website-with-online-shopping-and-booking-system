<?php
require_once "../config.php";//veritabani baglantisi ekler


if(isset($_POST["randevu_id"]))
{
    $randevu_id = $_POST['randevu_id'];
    $query = "DELETE FROM randevu WHERE id = '$randevu_id'"; //randevu tablosundan idye gore silme islemi yapar
    if (mysqli_query($db, $query)) {//$db veri tabaninda query islemini calistirir
        echo '<script> alert("Randevu başarıyla silindi.);</script>';
    } else {
        echo '<script> alert("Randevu silinirken bir hata oluştu:'. mysqli_error($db);//sonda hata sebebini verir
        echo '");</script>';
    }
    if($_SESSION["admingirdi"]== "1"){
        header("Location:../admin.php"); 
    }
   else{
    header("Location:../Randevular.php");
   }
    
}
?>
