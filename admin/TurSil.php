<?php 
include 'header_view.php'; 
if(empty($_GET['tid']))
{
	header("Location:TurListesi.php?islem=error");
}
$relative="./../";
include_once($relative.'lib/dahil_et.php');
?>
<section class="content-header">
	<h1>Hoşgeldin <?php echo $_SESSION["username"]; ?></h1>
</section>
<section class="content">
	<div class="box">
		<div class="box-body">
		<label>Kaldırma İşlemini Yapmak İstiyor musunuz?</label>
		<form action="" method="post">
		<input type="submit" name="submit" class="btn btn-primary" value="Kaldır">
		</form>
		<?php
		if(isset($_POST["submit"]))
		{
			if (mysql_query("UPDATE turlar SET aktif=0 WHERE id=".$_GET['tid'])){
				header("Location:TurListesi.php?islem=success");
			}else{
				echo 'Bir Hata Nediyle Silme İşlemi Yapılamadı !';
			}
		}
		?>
		</div>
	</div>
</section>	
<?php include 'footer_view.php'; ?>