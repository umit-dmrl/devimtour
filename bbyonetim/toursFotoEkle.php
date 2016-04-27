<?php

$relative="./../";
include_once($relative.'lib/dahil_et.php');

?><html><head><meta charset="UTF-8"><script src="http://js.nicedit.com/nicEdit-latest.js" type="text/javascript"></script>
<script type="text/javascript">bkLib.onDomLoaded(nicEditors.allTextAreas);</script>
						</head><body>
						
						<?php 
						
						if (isset($_GET['r'])){
							if ($_GET['r']==1){
								echo '<h1>İşlem başarılı.</h1>';
							}elseif($_GET['r']==0){
								echo '<h1>İşlem başarısız.</h1>';
							}else{
						
							}
						}
						
						?>
						<h2><a href="bbtours.php">Anasayfa</a></h2>
	<form method="post" action="toursFotoEklePost.php" enctype="multipart/form-data">

		<p>Tur Galeri Foto (347x245 pixel boyutu önerilir): <input type="file" name="file"></p>
		
		<input type="hidden" name="tid" value="<?php echo $_GET['tid']?>">
		
		<input type="submit" name="submit" value="Ekle">
	</form>
</body></html>