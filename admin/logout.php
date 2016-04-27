<?php include 'header_view.php'; ?>
<section class="content-header">
	<h1>Çıkış Yapmak İstediğinize Emin misiniz?</h1>
</section>
<section class="content">
	<div class="box">
		<div class="box-body">
		<form action="" method="post">
		<input type="submit" name="btnSubmit" value="Çıkış Yap" />
		</form>
		<?php
		if(isset($_POST["btnSubmit"]))
		{
			session_start();
			session_destroy();
			header("Location:adminLogin_view.php");
		}
		?>
		</div>
	</div>
</section>	
<?php include 'footer_view.php'; ?>