<?php
if(empty($_GET['tid'])) 
{
	header("Location:TurListesi.php?islem=error");
}
include 'header_view.php';
$relative="./../";
include_once($relative.'lib/dahil_et.php');
?>
<script src="http://js.nicedit.com/nicEdit-latest.js" type="text/javascript"></script>
<script type="text/javascript">bkLib.onDomLoaded(nicEditors.allTextAreas);</script>
<section class="content-header">
	<h1>Vitrinde Gösterilecek Fotoğrafı Ekleyin</h1>
</section>
<section class="content">
	<div class="box">
		<div class="box-body">
		<form method="post" action="" enctype="multipart/form-data">

			<p>Vitrin Foto (112x133 pixel boyutu önerilir): <input type="file" name="file"></p>
			
			<input type="hidden" name="tid" value="<?php echo $_GET['tid']; ?>">
			
			<input type="submit" name="submit" value="Ekle">
		</form>
		<?php
		if (isset($_POST['submit'])){
	
	
	if (!file_exists ( '../tour-photos/t'.$_POST['tid'] )){
		if(mkdir('../tour-photos/t'.$_POST['tid'], 0777)){
			
		}else{
			echo 'no directory created';die;
		}
	}
	
	if (!file_exists ( '../tour-photos/t'.$_POST['tid'].'/v' )){
		mkdir('../tour-photos/t'.$_POST['tid'].'/v', 0777);
	}
	
	
	
	//var_dump( $_FILES);die;
	
	
	$temp = explode(".", $_FILES["file"]["name"]);
	$filename = pathinfo($_FILES['file']['name'], PATHINFO_FILENAME);
	
	$extension = end($temp);
	
	
	$dosyayolu='tour-photos/t'.$_POST['tid'].'/v/'.urlSeoYap($filename).'.'.$extension;
	
		move_uploaded_file($_FILES["file"]["tmp_name"], '../'.$dosyayolu);
		

	
	$sql_update="UPDATE turlar SET vitrinResimYol='".$dosyayolu."' WHERE id=".$_POST['tid'];
	
	
	if (mysql_query($sql_update)){
		header("Location:TurListesi.php?islem=success");
	}else{
		//echo mysql_error();
		header("Location:TurListesi.php?islem=error");
	}
	
	

}
		?>
		</div>
	</div>
</section>	
<?php include 'footer_view.php'; ?>