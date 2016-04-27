<?php include 'header_view.php'; ?>
<section class="content-header">
	<h1>Yeni Kullanıcı Oluştur</h1>
</section>
<section class="content">
	<div class="box">
		<div class="box-body">
			<h4><font color='#3c8dbc'>Kullanıcının Giriş Bilgilerini Doldurunuz</font></h4>
			<form action="" method="post">
				<label>Kullanıcı Adı</label><br>
				<input type="text" name="username" class="form-control" style="width:30%;" />
				<br>
				<label>Parola</label>
				<input type="password" name="password" class="form-control" style="width:30%;" />
				<br>
				<label><input type="checkbox" name="onay" /> Kullanıcıyı Aktif Yap</label><br>
				<input type="submit" value="KAYDET" name="btn" class="btn btn-primary" />
			</form>
			<?php
			if(isset($_POST["btn"]))
			{
				include 'admin_db.php';
				$username=$_POST["username"]; $password=$_POST["password"]; $onay=0;
				if(isset($_POST["onay"]))
				{
					$onay=1;
				}else
				{
					$onay=0;
				}
				$sorgu=$baglanti->query("select * from admin where kullanici_adi='".$username."'");
				$sayac=0;
				foreach($sorgu as $val)
				{
					$sayac++;
				}
				if($sayac==0)
				{
					$kayit=$baglanti->exec("insert into admin (kullanici_adi,parola,yetki,durum) values ('".$username."','".$password."',0,$onay)");
					if($kayit)
					{
						echo "<font color='green'>Yeni Kullanıcı Oluşturuldu....</font>";
					}else{
						echo "<font color='maroon'>Hata ! Kayıt Eklenemedi.</font>";
					}
				}else{
					echo "<b>".$username."</b> <font color='maroon'>Kullanıcı Adı Zaten Kayıtlı !</font>";
				}
				
			}
			?>
		</div>
	</div>
</section>	