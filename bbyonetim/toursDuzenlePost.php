<?php
	

	$relative="./../";
	include_once($relative.'lib/dahil_et.php');
	
	
	/*print_r($_POST);
	 * 
	 * 
	 * Array ( [adi] => [kategori] => 1 [gidisTarih] => [donusTarih] => 
	 * [sure] => [ucret] => [parabirim] => [pansiyontipi] => [vize] => 0 
	 * [kapasite] => [havayolu] => 1 [ulkeSehir] => [ulasim] => [kisaaciklama] => 
	 * [genelaciklama] => [turprogrami] => 
	 * [fiyatdahil] => [fiyatdailolmayan] => [kosul_sart] => [vitrin] => 1 [banner] => 1 [submit] => Ekle )
	 */
	
	if (isset($_POST['submit'])){
	
		$tid=$_POST['tid'];
	
	$sql_insert="UPDATE turlar
	
	SET
	turAdi='".$_POST['adi']."',
	turDost='".urlSeoYap($_POST['adi'])."',
	anaKategori='".$_POST['kategori']."',
	gidisTarihi='".$_POST['gidisTarih']."',
	donusTarihi='".$_POST['donusTarih']."',
	sure='".$_POST['sure']."',
	ucret='".$_POST['ucret']."',
	paraBirim='".$_POST['parabirim']."',
	pansiyonTipi='".$_POST['pansiyontipi']."',
	vize='".$_POST['vize']."',
	kapasite='".$_POST['kapasite']."',
	havayoluId='".$_POST['havayolu']."',
	ulkeSehirSayisi='".$_POST['ulkeSehir']."',
	ulasim='".$_POST['ulasim']."',
	kisaAciklama='".$_POST['kisaaciklama']."',
	genelAciklama='".$_POST['genelaciklama']."',
	turProgrami='".$_POST['turprogrami']."',
	fiyataDahiller='".$_POST['fiyatdahil']."',
	fiyataDahilOlmayanlar='".$_POST['fiyatdailolmayan']."',
	kosulSart='".$_POST['kosul_sart']."',
	vitrinGoster='".$_POST['vitrin']."',
	bannerGoster='".$_POST['banner']."',
	aktif='".$_POST['yayin']."'
	WHERE id=".$tid."
	
	";
	
	
	
		if (mysql_query($sql_insert)){
			header("Location: bbtours.php?r=1");
		}else{
			header("Location: bbtours.php?r=0");
		}
	
	
	}