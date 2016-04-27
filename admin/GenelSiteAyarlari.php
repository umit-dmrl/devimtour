<?php include 'header_view.php'; ?>
<section class="content-header">
	<h1>Genel Site Ayarları</h1>
</section>

<section class="content">
	<?php
if(isset($_GET["islem"]))
{	
	if($_GET["islem"]=="success")
	{
		echo "<div class='callout callout-info'>İşlemleriniz Başarıyla Gerçekleşti.</div>";
	}else if($_GET["islem"]=="error")
	{
		echo "<div class='callout callout-info'><font color='maroon'>Bir Hata Nedeniyle İşlem Başarısız Oldu !</font></div>";
	}else{
		//
	}
}
?>
	<div class="box">
		<div class="box-body">
			<?php
			include 'admin_db.php';
			$site_ayar = $baglanti->query("select * from site_ayarlari where id=1");
			$baslik=""; $aciklama=""; $anahtar_kelimeler=""; $iletisim="";
			foreach($site_ayar as $val)
			{
				$baslik = $val["baslik"];
				$aciklama=$val["aciklama"];
				$anahtar_kelimeler=$val["anahtar_kelimeler"];
				$iletisim=$val["iletisim"];
			}
			?>
			<form action="" method="post">
				<i class="fa fa-arrow-circle-right"></i> <label>Site Başlığı</label> (title)
				<input type="text" name="baslik" class="form-control" value="<?php echo $baslik; ?>" style="width:30%;" />
				<br>
				<i class="fa fa-arrow-circle-right"></i> <label>Site Açıklaması</label> (description)<br>
				<textarea name="aciklama" id="aciklama" cols="30" rows="5" class="form-control"><?php echo $aciklama; ?></textarea>
				<br>
				<i class="fa fa-arrow-circle-right"></i> <label>Anahtar Kelimeler</label> (seo için önerilir. kelimeleri (,) ile ayırınız. <i class="fa fa-arrow-right"></i> keywords)
				<input type="text" name="anahtar_kelimeler" class="form-control" value="<?php echo $anahtar_kelimeler; ?>" style="width:30%;" />
				<br>
				<i class="fa fa-arrow-circle-right"></i> <label>İletişim Bilgileri</label><br>
				<textarea name="iletisim" id="iletisim" cols="30" rows="5" class="form-control"><?php echo $iletisim; ?></textarea>
				<br>
				<input type="submit" name="btn" value="KAYDET" class="btn btn-primary" />
			</form>
			<?php
			if(isset($_POST["btn"]))
			{
				$up_baslik=$_POST["baslik"]; $up_aciklama=$_POST["aciklama"]; $up_anahtar_kelimeler=$_POST["anahtar_kelimeler"];
				$up_iletisim=$_POST["iletisim"];
				$update = $baglanti->exec("UPDATE site_ayarlari set baslik='".$up_baslik."',aciklama='".$up_aciklama."',anahtar_kelimeler='".$up_anahtar_kelimeler."',iletisim='".$up_iletisim."' where id=1");
				if($update)
				{
					header("Location:GenelSiteAyarlari.php?islem=success");
				}else{
					header("Location:GenelSiteAyarlari.php?islem=error");
				}
				$baglanti->NULL;
			}
			?>
		</div>
	</div>
</section>	