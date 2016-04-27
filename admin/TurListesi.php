<?php include 'header_view.php'; ?>
<section class="content-header">
	<h1>Tur Listesi</h1>
</section>
<section class="content">
<?php
$relative="./../";
include_once($relative.'lib/dahil_et.php');
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
		<table border="1" width="100%" style="background-color:#f4f4f4; border:1px solid #ccc;">
				<tr>
					<td width="35%" style="padding:5px;"><b>Tur Adı</b></td>
					<td width="10%" align="center"><b>Pansiyon Türü</b></td>
					<td width="15%" align="center"><b>Gidiş-Dönüş</b></td>
					<td width="5%" align="center"><b>Yayın</b></td>
					<td width="6%" align="center"><b>Düzenle</b></td>
					<td width="6%" align="center"><b>Vitrin Foto</b></td>
					<td width="6%" align="center"><b>Banner Foto</b></td>
					<td width="6%" align="center"><b>Galeri Foto</b></td>
					<td width="6%" align="center"><b>Yayından Kaldır</b></td>
				</tr>
		</table>
		<table border="1" width="100%" style="background-color:#f4f4f4; border:1px solid #ccc;">
		<?php
		//
		
		
		$turlar_="";
		if(isset($_GET["filtre"]))
		{
			$filtre=$_GET["filtre"];
			if($filtre=="aktif_tur")
			{
				$turlar_=mysql_query("select * from turlar where aktif=1");
			}else if($filtre=="pasif_tur"){
				$turlar_=mysql_query("select * from turlar where aktif=0");
			}
		}else{
			$turlar_=sec("turlar","*","1 ORDER BY id DESC");
		}
		while ($tur=mysql_fetch_assoc($turlar_)){
			$id=$tur["id"];
			$adi=$tur["turAdi"];
			$pansiyon=$tur["pansiyonTipi"];
			$gidisTarihi=$tur["gidisTarihi"];
			$donusTarihi=$tur["donusTarihi"];
			$durum=$tur["aktif"];
			if($durum==1)
			{
				$durum="<font color='green'>Aktif</font>";
			}else{
				$durum="<font color='orange'>Pasif</font>";
			}
			echo "<tr>";
					echo "<td width='35%' style='padding:5px;'>$adi</td>
					<td width='10%' align='center'>$pansiyon</td>
					<td width='15%' align='center'><font size='1'>$gidisTarihi - $donusTarihi</font></td>
					<td width='5%' align='center'>$durum</td>
					<td width='6%' align='center'><a href='TurDuzenle.php?tid=$id'><i class='fa fa-pencil'> Düzenle</a></td>
					<td width='6%' align='center'><a href='VitrinFotoEkle.php?tid=$id'><i class='fa fa-picture-o'> Ekle</a></td>
					<td width='6%' align='center'><a href='BannerFotoEkle.php?tid=$id'><i class='fa fa-tv'> Ekle</a></td>
					<td width='6%' align='center'><a href='GaleriFotoEkle.php?tid=$id'><i class='fa fa-camera'> Ekle</a></td>
					<td width='6%' align='center'><a href='TurSil.php?tid=$id'><i class='fa fa-eraser'> Kaldır</a></td>
					";
			echo "</tr>";
		}
		?>
		</table>
		</div>
	</div>
</section>	
<?php include 'footer_view.php'; ?>