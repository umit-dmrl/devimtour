<?php include 'header_view.php'; ?>
<?php
include 'admin_db.php';
if(empty($_GET["id"]))
{
	header("Location:AdminKullaniciListele.php?islem=error");
}
?>
<section class="content-header">
	<h1>Yeni Kullanıcı Oluştur</h1>
</section>
<section class="content">
	<div class="box">
		<div class="box-body">
		<?php
		$id=$_GET["id"];
		$user_sorgula=$baglanti->query("select * from admin where id=".$id);
		$i=0;
		$kullanici_adi="";
		$parola="";
		$onay_html="";
		foreach($user_sorgula as $val)
		{
			$kullanici_adi=$val["kullanici_adi"];
			$parola=$val["parola"];
			if($val["durum"]==1)
			{
				$onay_html='<font color="green">Şu an için aktif</font><br><label><input type="checkbox" checked="checked" name="onay" /> Kullanıcıyı Aktif Yap</label>';
			}else{
				$onay_html='<font color="orange">Şu an için pasif</font><br><label><input type="checkbox" name="onay" /> Kullanıcıyı Aktif Yap</label>';
			}
			$i++;
		}
		if($i==0)
		{
			header("Location:AdminKullaniciListele.php?islem=error");
		}
		?>
			
			<h4><font color='#3c8dbc'>Güncelleme için en az bir alana yeni veri ekleyin.</font></h4>
			<form action="" method="post">
				<label>Kullanıcı Adı</label><br>
				<input type="text" name="user" class="form-control" value="<?php echo $kullanici_adi; ?>" style="width:30%;" />
				<br>
				<label>Parola</label>
				<input type="password"  value="<?php echo $parola; ?>" name="parola" class="form-control" style="width:30%;" />
				<br>
				<?php echo $onay_html; ?><br>
				<input type="submit" value="KAYDET" name="btn" class="btn btn-primary" />
			</form>
			<?php
			if(isset($_POST["btn"]))
			{
				$id=$_GET["id"];
				$username=$_POST["user"]; $password=$_POST["parola"]; $onay=0;
				if(isset($_POST["onay"]))
				{
					$onay=1;
				}else
				{
					$onay=0;
				}
				$update=$baglanti->exec("update admin set kullanici_adi='".$username."',parola='".$password."',durum=$onay where id=$id"." and yetki=0");
				if($update)
				{
					header("Location:AdminKullaniciListele.php?islem=success");
				}else{
					header("Location:AdminKullaniciListele.php?islem=error");
					//echo "update admin set kullanici_adi='".$username."',parola='".$password."',durum=$onay where id=$id"." and yetki=0";
				}
				
			}
			?>
		</div>
	</div>
</section>	