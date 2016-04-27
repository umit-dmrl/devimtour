<?php
	

	$relative="./../";
	include_once($relative.'lib/dahil_et.php');
	
	
	
	
	echo '';
	
	
	?>
	<html><head><meta charset="UTF-8"><script src="http://js.nicedit.com/nicEdit-latest.js" type="text/javascript"></script>
<script type="text/javascript">bkLib.onDomLoaded(nicEditors.allTextAreas);</script>
						</head><body>
	Yeni Tur Ekle
	<form method="post" action="tourseklerPost.php">
	
		<p>Tur Adı: <input type="text" name="adi"></p>
		<p>Tur Kategori: 
			<select name="kategori">
				<option value="1">Balkan Turu</option>
				<option value="2">Yunan Turu</option>
				<option value="3">Diğer</option>
			</select>
		
		</p>
		<p>Gidiş Tarihi (Yıl-Ay-Gün örnek: 2014-08-05 şeklinde yazılmalıdır.) : <input type="text" name="gidisTarih"></p>
		<p>Dönüş Tarihi (Yıl-Ay-Gün örnek: 2014-08-15 şeklinde yazılmalıdır.) : <input type="text" name="donusTarih"></p>
		<p>Süre (otomatik hesaplama için boş bırak): <input type="text" name="sure"></p>
		<p>Ücret (Örnek: 599): <input type="text" name="ucret"></p>
		<p>Para birimi (örn: €): <input type="text" name="parabirim"></p>
		<p>Pansiyon Tipi: <input type="text" name="pansiyontipi"></p>
		<p>Vize: <select name="vize">
				<option value="0">Gerekli Değil</option>
				<option value="1">Gerekli</option>
			</select></p>
		<p>Kapasite (Örnek: 40): <input type="text" name="kapasite"></p>
		<p>Havayolu:<select name="havayolu">
				<option value="1">THY</option>
				<option value="2">Pegasus</option>
				<option value="3">Feribot</option>
				<option value="4">KLM</option>
				<option value="5">AirFrance</option>
			</select></p>
		<p>Ülke Şehir Bilgisi (örnk: 6 Ülke, 9 Şehir): <input type="text" name="ulkeSehir"></p>
		<p>Ulaşım: <textarea name="ulasim" rows="20" cols="80">
		
		
		</textarea></p>
<p>Kısa Açıklama: <textarea name="kisaaciklama" rows="20" cols="80">
		
		
		</textarea></p>
		<p>Genel Aciklama: <textarea name="genelaciklama" rows="20" cols="80">
		
		
		</textarea></p>
		<p>Tur Programı: <textarea name="turprogrami" rows="20" cols="80">
		
		
		</textarea></p>
		
	<p>Fiyata Dahiller: <textarea name="fiyatdahil" rows="20" cols="80">
		
		
		</textarea></p>
	<p>Fiyat Dahil Olmayan: <textarea name="fiyatdailolmayan" rows="20" cols="80">
		
		
		</textarea></p>
		<p>Koşul Şart: <textarea name="kosul sart" rows="20" cols="80">
		
		
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
		
		<input type="submit" name="submit" value="Ekle">
	</form>
	
	
	
	
	<?php 

	
	
	echo '</body></html>';