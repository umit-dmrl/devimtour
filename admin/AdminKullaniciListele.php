<?php include 'header_view.php'; ?>
<section class="content-header">
	<h1>Kullanıcı Listesi</h1>
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
		<table border="1" width="50%" style="background-color:#f4f4f4; border:1px solid #ccc;">
				<tr>
					<td width="40%" style="padding:5px;"><b>Kullanıc Adı</b></td>
					<td width="15%" align="center"><b>Admin Türü</b></td>
					<td width="25%" align="center"><b>Yetki Düzenle / Admin Sil</b></td>
				</tr>
			</table>
			<table border="1" width="50%" style="background-color:#f4f4f4; border:1px solid #ccc;">
		<?php
		include 'admin_db.php';
		$kullanicilar = $baglanti->query("select * from admin where yetki != 1");
		$say=0;
		foreach($kullanicilar as $val)
		{
			$user_id = $val["id"];
			$username=$val["kullanici_adi"];
			$yetki="";
			if($val["yetki"]==1)
			{
				$yetki="Yüksek Yönetici";
			}else{
				$yetki="Normal";
			}
			if($say%2==0)
			{
				$renk = "#fff";
			}else{
				$renk = "#f4f4f4";
			}
				echo "<tr bgcolor='".$renk."'>";
				echo "<td width='40%' style='padding:5px;'>".$username."</td>
					<td width='15%' align='center'>".$yetki."</td>
					<td width='25%' align='center'><a href='KullaniciDuzenle.php?id=".$user_id."' title='Düzenle' style='margin-right:10px;'><i class='fa fa-pencil'></i></a> <a href='KullaniciSil.php?id=".$user_id."' title='Sil'><i class='fa fa-remove'></i></a></td>";
				echo "</tr>";
			$say++;
		}
		?>
		</table>
		</div>
	</div>
</section>	