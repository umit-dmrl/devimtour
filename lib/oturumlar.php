<?php
function gk(){	
	if (isset($_SESSION['kullaniciId'])) {
		return $_SESSION['kullaniciId'];
	}else{
		return false;
	}	
}

function userType(){
	
	$userTypeId=mysql_fetch_assoc(sec('users','*',"id='".gk()."'"));
	
	return $userTypeId['userType'];
	
}


?>