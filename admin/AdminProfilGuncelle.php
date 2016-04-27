<?php include 'header_view.php'; ?>
<section class="content-header">
	<h1>Yönetici Giriş Bilgilerini Güncelle</h1>
</section>
<section class="content">
	<div class="box">
		<div class="box-body">
			<form action="" method="post">
			<label>Şuanki Kullanıcı Adınız</label>
			<input type="text" name="oldUserName" class="form-control" style="width:30%">
			<br>
			<label>Şuanki Parolanız</label>
			<input type="password" name="oldPassword" class="form-control" style="width:30%">
			<br>
			<label>Yeni Kullanıcı Adınız</label>
			<input type="text" name="newUserName" class="form-control" style="width:30%">
			<br>
			<label>Yeni Parolanız</label>
			<input type="password" name="newPassword" class="form-control" style="width:30%">
			<br>
			<input type="submit" name="submit" value="Güncelle" class="btn btn-primary">
			</form>
			<?php
			if(isset($_POST["submit"]))
			{
				include 'admin_db.php';
				$oldkullanici_adi = $_POST["oldUserName"];
				$oldparola = $_POST["oldPassword"];
				$login = $baglanti->query("select * from admin where kullanici_adi='".$oldkullanici_adi."' and parola='".$oldparola."'");
				$sayac=0;
				foreach($login as $val)
				{
					$sayac++;
				}
				if($sayac==0)
				{
					echo "<font color='maroon'>Şuanki Kullanıcı Adı Veya Parolanızı Yanlış Girdiniz !</font>";
				}else{
					$newUserName = $_POST["newUserName"];
					$newPassword = $_POST["newPassword"];
					$update = $baglanti->exec("update admin set kullanici_adi='".$newUserName."',parola='".$newPassword."' where id=1");
					if($update)
					{
						echo "<font color='green'>Kullanıcı Adı Ve Şifreniz Güncellendi...</font>";
					}else{
						echo "<font color='maroon'>Bir Hata Oluştu Ve Kullanıcı Adı Ve Şifreniz Güncellenemedi !</font>";
					}
				}
			}
			?>
		</div>
	</div>
</section>	
<?php include 'footer_view.php'; ?>