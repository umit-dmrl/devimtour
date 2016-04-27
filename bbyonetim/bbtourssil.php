<?php
	

	$relative="./../";
	include_once($relative.'lib/dahil_et.php');
	
	
	//$turlar_=sec("turlar","*","1 ORDER BY gidisTarihi DESC");
	
	echo '<html><head><meta charset="UTF-8"></head><body>';
	
	
	
	if (mysql_query("UPDATE turlar SET aktif=0 WHERE id=".$_GET['tid'])){
		echo 'Yayından kaldırıldı.';
	}else{
		echo 'Hata';
	}
	
	echo '</body></html>';