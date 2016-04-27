<?php
//Bu kısmı sitenin veritabanına göre düzenle
try{
	$baglanti = new PDO("mysql:host=localhost;dbname=devimtours","root","");
}
catch(PDOException $e)
{
	echo "Bağlantı hatası ! <br> Hata Nedeni : <br>".$e;
}

?>