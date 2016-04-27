<?php
	

	$relative="./../";
	include_once($relative.'lib/dahil_et.php');
	
	
	$tid=$_GET['tid'];
	
	
	$tourInfo=mysql_fetch_assoc(sec("turlar","*","id=".$tid));
	
	echo '';
	
	
	?>
	<html><head><meta charset="UTF-8"><script src="http://js.nicedit.com/nicEdit-latest.js" type="text/javascript"></script>
<script type="text/javascript">bkLib.onDomLoaded(nicEditors.allTextAreas);</script>
						</head><body>
	Tur Bilgisi Güncelle
	<form method="post" action="toursDuzenlePost.php">
	
		<p>Tur Adı: <input type="text" name="adi" value="<?php echo $tourInfo['turAdi']; ?>"></p>
		<p>Tur Kategori: 
			<select name="kategori">
				<option value="1">Balkan Turu</option>
				<option value="2">Yunan Turu</option>
				<option value="3">Diğer</option>
			</select>
		
		</p>
		<p>Gidiş Tarihi (Yıl-Ay-Gün örnek: 2014-08-05 şeklinde yazılmalıdır.) : <input type="text" name="gidisTarih" value="<?php echo $tourInfo['gidisTarihi']; ?>"></p>
		<p>Dönüş Tarihi (Yıl-Ay-Gün örnek: 2014-08-15 şeklinde yazılmalıdır.) : <input type="text" name="donusTarih" value="<?php echo $tourInfo['donusTarihi']; ?>"></p>
		<p>Süre (otomatik hesaplama için boş bırak): <input type="text" name="sure" value="<?php echo $tourInfo['sure']; ?>"></p>
		<p>Ücret (Örnek: 599): <input type="text" name="ucret" value="<?php echo $tourInfo['ucret']; ?>"></p>
		<p>Para birimi (örn: €): <input type="text" name="parabirim" value="<?php echo $tourInfo['paraBirim']; ?>"></p>
		<p>Pansiyon Tipi: <input type="text" name="pansiyontipi" value="<?php echo $tourInfo['pansiyonTipi']; ?>"></p>
		<p>Vize: <select name="vize">
				<option value="0">Gerekli Değil</option>
				<option value="1">Gerekli</option>
			</select></p>
		<p>Kapasite (Örnek: 40): <input type="text" name="kapasite" value="<?php echo $tourInfo['kapasite']; ?>"></p>
		<p>Havayolu:<select name="havayolu">
				<option value="1">THY</option>
				<option value="2">Pegasus</option>
				<option value="3">Feribot</option>
				<option value="4">KLM</option>
				<option value="5">AirFrance</option>
			</select></p>
		<p>Ülke Şehir Bilgisi (örnk: 6 Ülke, 9 Şehir): <input type="text" name="ulkeSehir" value="<?php echo $tourInfo['ulkeSehirSayisi']; ?>"></p>
		<p>Ulaşım: <textarea name="ulasim" rows="20" cols="80">
		 <?php echo $tourInfo['ulasim']; ?>
		
		</textarea></p>
<p>Kısa Açıklama: <textarea name="kisaaciklama" rows="20" cols="80">
		
		 <?php echo $tourInfo['kisaAciklama']; ?>
		</textarea></p>
		<p>Genel Aciklama: <textarea name="genelaciklama" rows="20" cols="80">
		 <?php echo $tourInfo['genelAciklama']; ?>
		
		</textarea></p>
		<p>Tur Programı: <textarea name="turprogrami" rows="20" cols="80">
		 <?php echo $tourInfo['turProgrami']; ?>
		
		</textarea></p>
		
	<p>Fiyata Dahiller: <textarea name="fiyatdahil" rows="20" cols="80">
		 <?php echo $tourInfo['fiyataDahiller']; ?>
		
		</textarea></p>
	<p>Fiyat Dahil Olmayan: <textarea name="fiyatdailolmayan" rows="20" cols="80">
		 <?php echo $tourInfo['fiyataDahilOlmayanlar']; ?>
		
		</textarea></p>
		<p>Koşul Şart: <textarea name="kosul sart" rows="20" cols="80">
		 <?php echo $tourInfo['kosulSart']; ?>
		
		</textarea></p>
		<p>Vitrin Göster: <select name="vitrin">
				<option value="1">Göster</option>
				<option value="0">Gösterme</option>
			</select></p>
		
		
		<p>Banner Göster: <select name="banner">
				<option value="1">Göster</option>
				<option value="0">Gösterme</option>
			</select></p>
		
		<p>Sitede Yayınlansın mı? <select name="yayin">
				<option value="1">Evet</option>
				<option value="0">Hayır</option>
			</select></p>
		<input type="hidden" name="tid" value="<?php echo $tid;?>" >
		<input type="submit" name="submit" value="Ekle">
	</form>
	
	
	
	
	<?php 

	
	
	echo '</body></html>';