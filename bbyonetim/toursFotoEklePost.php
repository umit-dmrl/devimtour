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
	
	if (!file_exists ( '../tour-photos/t'.$_POST['tid'].'/n' )){
		mkdir('../tour-photos/t'.$_POST['tid'].'/n', 0777);
	}
	
	/*if (!file_exists ( '../tour-photos/t'.$_POST['tid'].'/t' )){
		mkdir('../tour-photos/t'.$_POST['tid'].'/t', 0777);
	}*/
	
	
	//var_dump( $_FILES);die;
	
	
	$temp = explode(".", $_FILES["file"]["name"]);
	$filename = pathinfo($_FILES['file']['name'], PATHINFO_FILENAME);
	
	$extension = end($temp);
	
	
	$dosyayolu='tour-photos/t'.$_POST['tid'].'/n/'.urlSeoYap($filename).'.'.$extension;
	
		move_uploaded_file($_FILES["file"]["tmp_name"], '../'.$dosyayolu);
		

	
	$sql_update="INSERT INTO  turresimler SET turId='".$_POST['tid']."', resimYol='".$dosyayolu."', thumbYol='".$dosyayolu."'";
	
	
	if (mysql_query($sql_update)){
		header("Location: toursFotoEkle.php?r=1&tid=".$_POST['tid']);
	}else{
		//echo mysql_error();
		header("Location: toursFotoEkle.php?r=0&tid=".$_POST['tid']);
	}
	
	

}