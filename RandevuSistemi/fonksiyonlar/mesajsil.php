<?php
require_once "../config.php";//veritabani baglantisi ekler

if(isset($_POST["mesaj_id"]))
{
    $mesaj_id = $_POST['mesaj_id'];
    $query = "DELETE FROM iletisim WHERE id = '$mesaj_id'";//iletisim tablosundan id si gonderilen mesaji siler
    if (mysqli_query($db, $query)) {
        echo '<script> alert("Mesaj başarıyla silindi.);</script>';
    } else {
        echo '<script> alert("Mesaj silinirken bir hata oluştu:'. mysqli_error($db);
        echo '");</script>';
    }
    if($_SESSION["admingirdi"]== "1"){//admin veya kullaniciya gore yonlendirme
        header("Location:../mesajlar.php"); 
    }
   else{
    header("Location:../iletisim.php");
   }
    
}
?>
