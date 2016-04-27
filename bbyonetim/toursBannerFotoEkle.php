<?php

$relative="./../";
include_once($relative.'lib/dahil_et.php');

?><html><head><meta charset="UTF-8"><script src="http://js.nicedit.com/nicEdit-latest.js" type="text/javascript"></script>
<script type="text/javascript">bkLib.onDomLoaded(nicEditors.allTextAreas);</script>
						</head><body>
	<form method="post" action="toursBannerFotoEklePost.php" enctype="multipart/form-data">

		<p>Banner Foto (658x232 pixel boyutu önerilir): <input type="file" name="file"></p>
		
		<input type="hidden" name="tid" value="<?php echo $_GET['tid'];?>">
		
		<input type="submit" name="submit" value="Ekle">
	</form>
</body></html>