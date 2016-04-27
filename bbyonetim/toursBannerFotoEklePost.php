<?php

$relative="./../";
include_once($relative.'lib/dahil_et.php');



if (isset($_POST['submit'])){
	
	
	if (!file_exists ( '../tour-photos/t'.$_POST['tid'] )){
		if(mkdir('../tour-photos/t'.$_POST['tid'], 0777)){
			
		}else{
			echo 'no directory created';die;
		}
	}
	
	if (!file_exists ( '../tour-photos/t'.$_POST['tid'].'/b' )){
		mkdir('../tour-photos/t'.$_POST['tid'].'/b', 0777);
	}
	
	
	
	//var_dump( $_FILES);die;
	
	
	$temp = explode(".", $_FILES["file"]["name"]);
	$filename = pathinfo($_FILES['file']['name'], PATHINFO_FILENAME);
	
	$extension = end($temp);
	
	
	$dosyayolu='tour-photos/t'.$_POST['tid'].'/b/'.urlSeoYap($filename).'.'.$extension;
	
		move_uploaded_file($_FILES["file"]["tmp_name"], '../'.$dosyayolu);
		

	
	$sql_update="UPDATE turlar SET bannerResimYol='".$dosyayolu."' WHERE id=".$_POST['tid'];
	
	
	if (mysql_query($sql_update)){
		header("Location: bbtours.php?r=1");
	}else{
		//echo mysql_error();
		header("Location: bbtours.php?r=0");
	}
	
	

}