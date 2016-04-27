<?php
	

	$relative="./../";
	include_once($relative.'lib/dahil_et.php');
	
	
	$turlar_=sec("turlar","*","1 ORDER BY id DESC");
	
	echo '<html><head><meta charset="UTF-8"></head><body>';
	
	if (isset($_GET['r'])){
	if ($_GET['r']==1){
		echo '<h1>İşlem başarılı.</h1>';
	}elseif($_GET['r']==0){
		echo '<h1>İşlem başarısız.</h1>';
	}else{
		
	}
	}
	echo '<a href="toursEkler.php">Yeni Tur Ekle</a>';
	
	while ($tur=mysql_fetch_assoc($turlar_)){
		
		
		echo '<p>'.$tur['id'].': '.$tur['turAdi'].' ('.$tur['gidisTarihi'].' - '.$tur['donusTarihi'].') <a href="toursDuzenle.php?tid='.$tur['id'].'">Düzenle</a> <a href="toursVitrinFotoEkle.php?tid='.$tur['id'].'">Vitrin Foto Ekle</a> <a href="toursBannerFotoEkle.php?tid='.$tur['id'].'">Banner Foto Ekle</a> <a href="toursFotoEkle.php?tid='.$tur['id'].'">Galeri Foto Ekle</a>  <a href="bbtourssil.php?tid='.$tur['id'].'">Yayından Kaldır</a>'.'</p>';
		
		
		
		
	}
	
	
	echo '</body></html>';