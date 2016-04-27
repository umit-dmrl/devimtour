<?php
function baglan(){
	
  $sunucu="localhost";
  /*$kullanici="deVimUsr";
  $sifre='95afTraweBrupC8A';*/
  $kullanici="root";
  $sifre="";
  $veritabani="devimtours";
 
  $baglanti=mysql_connect($sunucu,$kullanici,$sifre) or die ("veri tabanına bağlantıda sorun var");
  mysql_select_db($veritabani,$baglanti) or die("veritabanına şu anda ulaşamıyoruz lütfen sonra tekrar deneyiniz");
  mysql_query("SET names UTF8");
  mysql_query("SET time_zone = '+03:00'");
  
  return  $baglanti;
}
?>
