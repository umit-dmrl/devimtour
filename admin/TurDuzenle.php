<?php 
$relative="./../";
include_once($relative.'lib/dahil_et.php');
if(empty($_GET["tid"]))
{
	header("Location:TurListesi.php?islem=error");
}else{
$tid = $_GET["tid"];
$tourInfo=mysql_fetch_assoc(sec("turlar","*","id=".$tid));
}
include 'header_view.php';

 ?>
 <script src="http://js.nicedit.com/nicEdit-latest.js" type="text/javascript"></script>
<script type="text/javascript">bkLib.onDomLoaded(nicEditors.allTextAreas);</script>
<section class="content-header">
	<h1>Yeni Bir Tur Ekleyin</h1>
</section>
<section class="content">
	<div class="box">
		<div class="box-body">
		<form method="post" action="">
	
		<p><label>Tur Adı </label><input type="text" name="adi" class="form form-control" style="width:30%;" value="<?php echo $tourInfo['turAdi']; ?>" ></p>
		<p><label>Tur Kategori </label>
			<select name="kategori" class="form-control" style="width:15%; cursor:pointer;">
				<option value="1">Balkan Turu</option>
				<option value="2">Yunan Turu</option>
				<option value="3">Diğer</option>
			</select>
		
		</p>
		<div class="form-group">
                    <label>Gidiş Tarihi (Yıl-Ay-Gün örnek: 2014-08-05 şeklinde yazılmalıdır.)</label>
                    <div class="input-group">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input type="text" value="<?php echo $tourInfo['gidisTarihi']; ?>" name="gidisTarih" style="width:15%;" class="form-control" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask="">
                    </div><!-- /.input group -->
        </div>
		<div class="form-group">
                    <label>Dönüş Tarihi (Yıl-Ay-Gün örnek: 2014-08-15 şeklinde yazılmalıdır.)</label>
                    <div class="input-group">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input type="text" name="donusTarih" value="<?php echo $tourInfo['donusTarihi']; ?>" style="width:15%;" class="form-control" data-inputmask="'alias': 'dd/mm/yyyy'" data-mask="">
                    </div><!-- /.input group -->
        </div>
		<p><label>Süre (otomatik hesaplama için boş bırak)</label><br>
		<input type="text" value="<?php echo $tourInfo['sure']; ?>" name="sure" style="width:15%;" class="form-control"></p>
		<p><label>Ücret (Örnek: 599)</label><br><input type="text" value="<?php echo $tourInfo['ucret']; ?>" name="ucret" style="width:15%;" class="form-control"></p>
		<p><label>Para birimi (örn: €)</label><br> <input type="text" value="<?php echo $tourInfo['paraBirim']; ?>" name="parabirim" style="width:5%;" class="form-control"></p>
		<p><label>Pansiyon Tipi</label><br> <input type="text" value="<?php echo $tourInfo['pansiyonTipi']; ?>" style="width:15%;" class="form-control" name="pansiyontipi"></p>
		<p><label>Vize</label><br><select name="vize" style="width:15%;" class="form-control">
				<option value="0">Gerekli Değil</option>
				<option value="1">Gerekli</option>
			</select></p>
		<p><label>Kapasite (Örnek: 40)</label><br> <input type="text" value="<?php echo $tourInfo['kapasite']; ?>" name="kapasite" style="width:5%;" class="form-control"></p>
		<p><label>Havayolu</label><br><select name="havayolu" style="width:15%;" class="form-control">
				<option value="1">THY</option>
				<option value="2">Pegasus</option>
				<option value="3">Feribot</option>
				<option value="4">KLM</option>
				<option value="5">AirFrance</option>
			</select></p>
		<p><label>Ülke Şehir Bilgisi (örnk: 6 Ülke, 9 Şehir)</label><br> <input type="text" value="<?php echo $tourInfo['ulkeSehirSayisi']; ?>" name="ulkeSehir" style="width:30%;" class="form-control"></p>
		<p><label>Ulaşım</label><br> <textarea name="ulasim" rows="5" cols="80"  style="width:100%;" class="form-control">
		<?php echo $tourInfo['ulasim']; ?>
		
		</textarea></p>
<p><label>Kısa Açıklama</label><br> <textarea name="kisaaciklama" rows="5" cols="80" style="width:100%;" class="form-control">
		<?php echo $tourInfo['kisaAciklama']; ?>
		
		</textarea></p>
		<p><label>Genel Aciklama</label><br> <textarea name="genelaciklama" rows="5" cols="80"  style="width:100%;" class="form-control">
		<?php echo $tourInfo['genelAciklama']; ?>
		
		</textarea></p>
		<p><label>Tur Programı</label><br> <textarea name="turprogrami" rows="5" cols="80"  style="width:100%;" class="form-control">
		<?php echo $tourInfo['turProgrami']; ?>
		
		</textarea></p>
		
	<p><label>Fiyata Dahiller</label><br> <textarea name="fiyatdahil" rows="5" cols="80"  style="width:100%;" class="form-control">
		<?php echo $tourInfo['fiyataDahiller']; ?>
		
		</textarea></p>
	<p><label>Fiyat Dahil Olmayan</label><br> <textarea name="fiyatdailolmayan" rows="5" cols="80"  style="width:100%;" class="form-control">
		<?php echo $tourInfo['fiyataDahilOlmayanlar']; ?>
		
		</textarea></p>
		<p><label>Koşul Şart</label><br> <textarea name="kosul sart" rows="5" cols="80"  style="width:100%;" class="form-control">
		<?php echo $tourInfo['kosulSart']; ?>
		
		</textarea></p>
		<p><label>Vitrin Göster</label><br> <select name="vitrin"  style="width:15%;" class="form-control">
				<option value="1">Göster</option>
				<option value="0">Gösterme</option>
			</select></p>
		
		
		<p><label>Banner Göster</label><br> <select name="banner" style="width:15%;" class="form-control">
				<option value="1">Göster</option>
				<option value="0">Gösterme</option>
			</select></p>
		
		<p><label>Sitede Yayınlansın mı?</label><br> <select name="yayin" style="width:15%;" class="form-control">
				<option value="1">Evet</option>
				<option value="0">Hayır</option>
			</select></p>
		<input type="hidden" name="tid" value="<?php echo $tid;?>" >
		<input type="submit" name="submit" value="GÜNCELLE" class="btn btn-primary">
	</form>
	<?php
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
			header("Location:TurListesi.php?islem=success");
		}else{
			header("Location:TurListesi.php?islem=error");
		}
	
	
	}
	?>
		</div>
	</div>
</section>	
<?php include 'footer_view.php'; ?>