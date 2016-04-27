<?php include 'header_view.php'; ?>
<?php
if(empty($_GET["id"]))
{
	header("Location:AdminKullaniciListele.php?islem=error");
}
?>
<section class="content-header">
	<h1>Kullanıcıyı Silmek İstiyor musunuz?</h1>
</section>
<section class="content">
	<div class="box">
		<div class="box-body">
		<?php
		include 'admin_db.php';
		$id=$_GET["id"];
		$user_sorgula=$baglanti->query("select * from admin where id=".$id." and yetki=0");
		$i=0;
		foreach($user_sorgula as $val)
		{
			$i++;
		}
		if($i==0)
		{
			header("Location:AdminKullaniciListele.php?islem=error");
		}
		?>
		<form action="" method="post">
		<label>Kullanıcıyı Silmek İstiyor musunuz?</label><br>
		<input type="submit" value="Sil" name="btn" class="btn btn-primary" />
		</form>
		<?php
		if(isset($_POST["btn"]))
		{
			$id=$_GET["id"];
			$sil=$baglanti->exec("delete from admin where id=$id and yetki=0");
			if($sil)
			{
				header("Location:AdminKullaniciListele.php?islem=success");
			}else{
				header("Location:AdminKullaniciListele.php?islem=error");
			}
		}
		?>
		</div>
	</div>
</section>	