<?php
function idToTimeInfo($timeId, $needed='startTime'){
	
	$timeInfo=mysql_fetch_assoc(sec('rez_times','*', "id='".$timeId."'"));
	
	return $timeInfo[$needed];	
}
function idToOfficeInfo($officeId, $needed='name'){
	$officeInfo=mysql_fetch_assoc(sec('rez_offices','*', "id='".$officeId."'"));
	return $officeInfo[$needed];
}
function idToEqInfo($equipmentId, $needed='name'){
	$EqInfo=mysql_fetch_assoc(sec('rez_equipments','*', "id='".$equipmentId."'"));
	return $EqInfo[$needed];
}
function startTimeToTimeId($startTime){

	$timeInfo=mysql_fetch_assoc(sec('rez_times','*', "startTime='".$startTime."'"));

	return $timeInfo['id'];
}

function endTimeToTimeId($endTime){

	$timeInfo=mysql_fetch_assoc(sec('rez_times','*', "endTime='".$endTime."'"));

	return $timeInfo['id'];
}
function ekranSaati($saat){
	$saat=substr($saat,0,-3);
	return $saat;
}

function tempRezId(){
	if (isset($_SESSION['tempRezId'])) {
		return $_SESSION['tempRezId'];
	}else{
		return false;
	}
}
function tempRezSonlandir(){
	unset($_SESSION['tempRezId']);
	return true;	
}
function politikaKabul(){
	$politikDurum=tempRezInfo('politikaKabul');
	if ($politikDurum==1){
		return true;
	}else{
		return false;
	}	
}
function tempRezInfo($requestInfo){	
	$requestedInfoResult=mysql_fetch_assoc(sec("rez_scheduletemp",$requestInfo, "id='".tempRezId()."'"));
	return $requestedInfoResult[$requestInfo];	
}
function rezInfo($requestInfo,$rezId){
	$requestedInfoResult=mysql_fetch_assoc(sec("rez_schedule",$requestInfo, "id='".$rezId."'"));
	return $requestedInfoResult[$requestInfo];
}
function eqInfo($requestInfo,$eqId){
	$requestedInfoResult=mysql_fetch_assoc(sec("rez_equipments",$requestInfo, "id='".$eqId."'"));
	return $requestedInfoResult[$requestInfo];
}
function officInfo($requestInfo,$ofId){
	$requestedInfoResult=mysql_fetch_assoc(sec("rez_offices",$requestInfo, "id='".$ofId."'"));
	return $requestedInfoResult[$requestInfo];
}
function officeTypeInfo($ofId, $needed='name'){
	$requestedInfoResult=mysql_fetch_assoc(sec("rez_officetypes",$needed, "id='".$ofId."'"));
	return $requestedInfoResult[$needed];
}
function numberCombo($name, $maxNumber){
	
	$comboHtml='	
								<select name="'.$name.'" id="'.$name.'" size="1" style="float:left; width: 70px;">
									<option value="0" selected="selected">Seçiniz</option>';
	for ($i = 1; $i <= $maxNumber; $i++) {
		$comboHtml.='<option value="'.$i.'">'.$i.'</option>';
	}
	$comboHtml.='							</select>
	';
	return $comboHtml;
}
function eqCodeToId($code){
	$eqId=mysql_fetch_assoc(sec(rez_equipments,'id',"code='".$code."'"));
	return $eqId['id'];
}
function derslikAdi($derslikId){
	$derslikAdi= mysql_fetch_assoc(sec('rez_offices', '*', "id=".$derslikId));
	return $derslikAdi['name'];
}
function eqName($eqId){
	$eqName= mysql_fetch_assoc(sec('rez_equipments', '*', "id=".$eqId));
	return $eqName['name'];
}
function kullanimAmaci($amacId){
	$kullanimAmaci=$amacId;
		$kullanimAmacIdE=explode(':;:', $kullanimAmaci);
		if (count($kullanimAmacIdE)>1){
			$kullanimAmaciId=$kullanimAmacIdE[0];
			$kullanimAmaciDiger=$kullanimAmacIdE[1];
		}else{
			$kullanimAmaciId=$kullanimAmaci;
		}
		
		if ($kullanimAmaciId==0){
			return "Diğer: ".$kullanimAmaciDiger;
		}else{
			$amacBul=sec('rez_purposeofuse', '*', "id=".$kullanimAmaciId);
			$amacName= mysql_fetch_assoc($amacBul);
			return $amacName['purpose'];
		}
}


function rezIstekPostaAdmine($kimeId){
	
	
	$kullaniciBilgi=mysql_fetch_assoc(sec('users','*',"id=".$kimeId));
	$kimAdi=$kullaniciBilgi['title'].' '.$kullaniciBilgi['firstName'].' '.$kullaniciBilgi['lastName'];
	
	$kime=$kullaniciBilgi['email'];
	
	
	$ePostaMetin='Yeni bir rezervasyon talebi alınmıştır. Onaylamak için aşağıdaki bağlantıyı takip ediniz.';
	$link=ayarAl('siteAdi');
	$mesaj =ePostaHTML($kimAdi, $ePostaMetin,'',$link);

	
	
	$mesajAlt =strip_tags($mesaj);
	
	
	//$headers ="From: =?UTF-8?B?".base64_encode($mesaj_nereden)."?= <". ''.ayarAl('mailAdresi').'>' . "\r\n";
	//$header_ = 'MIME-Version: 1.0' . "\r\n" . 'Content-type: text/html; charset=UTF-8' . "\r\n";
	
	require_once ("class.phpmailer.php"); 
	$mail = new PHPMailer(); 
	
	$mail->IsSMTP(); // Mailimizin SMTP ile g�nderilece�ini belirtiyoruz
	$mail->From     = "okm@mail.ege.edu.tr"; //G�nderen k�sm�nda yer alacak e-mail adresi
	$mail->Sender   = "okm@mail.ege.edu.tr";
	$mail->ReplyTo  = "okm@mail.ege.edu.tr";
	$mail->FromName = "ÖKM - TEAD";
	$mail->Host     = "mail.ege.edu.tr"; //SMTP server adresi
	$mail->SMTPAuth = true; //SMTP server'a kullan�c� ad� ile ba�lan�lca��n� belirtiyoruz
	$mail->Username = "okm@mail.ege.edu.tr"; //SMTP kullan�c� ad�
	$mail->Password    = "nryTp018"; //SMTP �ifre
	$mail->WordWrap = 50;
	$mail->IsHTML(true); //Mailimizin HTML format�nda haz�rlanaca��n� bildiriyoruz.
	$mail->Subject  = "Rezervasyon Talebi"; // Konu
	
	//Mailimizin g�vdesi: (HTML ile)
	//$body = "<b>Bu mail</b> bir deneme mailidir.<br /><br />SMTP server ile gonderilmistir.";
	
	// HTML okuyamayan mail okuyucularda g�r�necek d�z metin:
	//$textBody = "Bu mail bir deneme mailidir. SMTP server ile gonderilmistir.";
	
	//$mail->AddCustomHeader($header_);
	$mail->Body = $mesaj;
	$mail->AltBody = $mesajAlt;
	
	$mail->AddAddress($kime); // Mail g�nderilecek adresleri ekliyoruz.
	$mail->AddCC('okm@mail.ege.edu.tr');
	
	
	
	if ($mail->Send()) {
		$gondermeDurum='1';
	}
	else {
		$gondermeDurum='0';
	}
	
	$mail->ClearAddresses();
	$mail->ClearCCs();
	$mail->ClearAttachments();
	

	return $gondermeDurum;


}

function rezIstekPostaKullanici($rezIcerik){
	
	$kullaniciBilgi=mysql_fetch_assoc(sec('users','*',"id=".gk()));
	$kimAdi=$kullaniciBilgi['title'].' '.$kullaniciBilgi['firstName'].' '.$kullaniciBilgi['lastName'];

	$kime=$kullaniciBilgi['email'];


	$baslik ='Rezervasyon Talebiniz';
	
	$mesajIcerik='Yapmış olduğunuz rezervasyon ile ilgili bilgiler aşağıda sunulmuştur. <br>'.$rezIcerik;

	$mesaj =ePostaHTML($kimAdi, $mesajIcerik);

	
	
	
	$mesajAlt=strip_tags($mesaj);

	$mesaj_nereden='Öğrenme Kaynakları Merkezi';

//	$headers ="From: =?UTF-8?B?".base64_encode($mesaj_nereden)."?= <". ''.ayarAl('mailAdresi').'>' . "\r\n";

//	$header_ = 'MIME-Version: 1.0' . "\r\n" . 'Content-type: text/plain; charset=UTF-8' . "\r\n";


	/*if(mail($kime, '=?UTF-8?B?'.base64_encode($baslik).'?=', $mesaj, $header_ . $headers)){
		return true;
	}else{
		return false;
	}*/
	
	$mail2 = new PHPMailer();
	
	$mail2->IsSMTP(); // Mailimizin SMTP ile g�nderilece�ini belirtiyoruz
	$mail2->From     = "okm@mail.ege.edu.tr"; //G�nderen k�sm�nda yer alacak e-mail adresi
	$mail2->Sender   = "okm@mail.ege.edu.tr";
	$mail2->ReplyTo  = "okm@mail.ege.edu.tr";
	$mail2->FromName = "ÖKM - TEAD";
	$mail2->Host     = "mail.ege.edu.tr"; //SMTP server adresi
	$mail2->SMTPAuth = true; //SMTP server'a kullan�c� ad� ile ba�lan�lca��n� belirtiyoruz
	$mail2->Username = "okm@mail.ege.edu.tr"; //SMTP kullan�c� ad�
	$mail2->Password    = "nryTp018"; //SMTP �ifre
	$mail2->WordWrap = 50;
	$mail2->IsHTML(true); //Mailimizin HTML format�nda haz�rlanaca��n� bildiriyoruz.
	$mail2->Subject  = $baslik; // Konu
	
	//Mailimizin g�vdesi: (HTML ile)
	//$body = "<b>Bu mail</b> bir deneme mailidir.<br /><br />SMTP server ile gonderilmistir.";
	
	// HTML okuyamayan mail okuyucularda g�r�necek d�z metin:
	//$textBody = "Bu mail bir deneme mailidir. SMTP server ile gonderilmistir.";
	//$mail->AddCustomHeader($header_);
	$mail2->Body = $mesaj;
	$mail2->AltBody = $mesajAlt;
	
	$mail2->AddAddress($kime); // Mail g�nderilecek adresleri ekliyoruz.
	$mail2->AddCC('okm@mail.ege.edu.tr');

	
	if ($mail2->Send()) {
		$gondermeDurum='1';
	}else {
		$gondermeDurum='0';
	}
	
	$mail2->ClearAddresses();
	$mail2->ClearCCs();
	$mail2->ClearAttachments();
	
	return $gondermeDurum;
	
}

function adminOnayPostasi($kimeId, $epostaMetin){
	
	$kullaniciBilgi=mysql_fetch_assoc(sec('users','*',"id=".$kimeId));
	$kimAdi=$kullaniciBilgi['title'].' '.$kullaniciBilgi['firstName'].' '.$kullaniciBilgi['lastName'];
	
	$kime=$kullaniciBilgi['email'];
	
	require_once ("class.phpmailer.php");
	$mail = new PHPMailer();
	
	$mail->IsSMTP(); // Mailimizin SMTP ile g�nderilece�ini belirtiyoruz
	$mail->From     = "okm@mail.ege.edu.tr"; //G�nderen k�sm�nda yer alacak e-mail adresi
	$mail->Sender   = "okm@mail.ege.edu.tr";
	$mail->ReplyTo  = "okm@mail.ege.edu.tr";
	$mail->FromName = "ÖKM - TEAD";
	$mail->Host     = "mail.ege.edu.tr"; //SMTP server adresi
	$mail->SMTPAuth = true; //SMTP server'a kullan�c� ad� ile ba�lan�lca��n� belirtiyoruz
	$mail->Username = "okm@mail.ege.edu.tr"; //SMTP kullan�c� ad�
	$mail->Password    = "nryTp018"; //SMTP �ifre
	$mail->WordWrap = 50;
	$mail->IsHTML(true); //Mailimizin HTML format�nda haz�rlanaca��n� bildiriyoruz.
	$mail->Subject  = "Rezervasyon Onay"; // Konu
	
	//Mailimizin g�vdesi: (HTML ile)
	//$body = "<b>Bu mail</b> bir deneme mailidir.<br /><br />SMTP server ile gonderilmistir.";
	
	// HTML okuyamayan mail okuyucularda g�r�necek d�z metin:
	//$textBody = "Bu mail bir deneme mailidir. SMTP server ile gonderilmistir.";
	
	//$mail->AddCustomHeader($header_);
	
	if ($epostaMetin==''){
		$ekNot='';
	}else{
		$ekNot='Yönetici Notu: '.stripslashes($epostaMetin);
	}
	
	$mesaj=ePostaHTML($kimAdi, 'Rezervasyon talebiniz onaylanmıştır.', $ekNot);
	
	
	
	$mail->Body = $mesaj;
	$mail->AltBody = strip_tags($mesaj);
	
	$mail->AddAddress($kime); // Mail g�nderilecek adresleri ekliyoruz.
	$mail->AddCC('okm@mail.ege.edu.tr');
	
	if ($mail->Send()) {
		$gondermeDurum='1';
	}
	else {
		$gondermeDurum='0';
	}
	
	$mail->ClearAddresses();
	$mail->ClearCCs();
	$mail->ClearAttachments();
	
	return $gondermeDurum;
}


function rezIptalTalepAdminPosta($rezId){
	
	$rezInfoOff=rezInfo('officeId', $rezId);
	
	$kimeId=officInfo('adminId', $rezInfoOff);


	$kullaniciBilgi=mysql_fetch_assoc(sec('users','*',"id=".$kimeId));
	$kimAdi=$kullaniciBilgi['title'].' '.$kullaniciBilgi['firstName'].' '.$kullaniciBilgi['lastName'];

	$kime=$kullaniciBilgi['email'];


	$ePostaMetin='Yeni bir rezervasyon iptal talebi alınmıştır. Onaylamak için aşağıdaki bağlantıyı takip ediniz.';
	$link=ayarAl('siteAdi');
	$mesaj =ePostaHTML($kimAdi, $ePostaMetin,'',$link);



	$mesajAlt =strip_tags($mesaj);


	//$headers ="From: =?UTF-8?B?".base64_encode($mesaj_nereden)."?= <". ''.ayarAl('mailAdresi').'>' . "\r\n";
	//$header_ = 'MIME-Version: 1.0' . "\r\n" . 'Content-type: text/html; charset=UTF-8' . "\r\n";

	require_once ("class.phpmailer.php");
	$mail = new PHPMailer();

	$mail->IsSMTP(); // Mailimizin SMTP ile g�nderilece�ini belirtiyoruz
	$mail->From     = "okm@mail.ege.edu.tr"; //G�nderen k�sm�nda yer alacak e-mail adresi
	$mail->Sender   = "okm@mail.ege.edu.tr";
	$mail->ReplyTo  = "okm@mail.ege.edu.tr";
	$mail->FromName = "ÖKM - TEAD";
	$mail->Host     = "mail.ege.edu.tr"; //SMTP server adresi
	$mail->SMTPAuth = true; //SMTP server'a kullan�c� ad� ile ba�lan�lca��n� belirtiyoruz
	$mail->Username = "okm@mail.ege.edu.tr"; //SMTP kullan�c� ad�
	$mail->Password    = "nryTp018"; //SMTP �ifre
	$mail->WordWrap = 50;
	$mail->IsHTML(true); //Mailimizin HTML format�nda haz�rlanaca��n� bildiriyoruz.
	$mail->Subject  = "Rezervasyon İptal Talebi"; // Konu

	//Mailimizin g�vdesi: (HTML ile)
	//$body = "<b>Bu mail</b> bir deneme mailidir.<br /><br />SMTP server ile gonderilmistir.";

	// HTML okuyamayan mail okuyucularda g�r�necek d�z metin:
	//$textBody = "Bu mail bir deneme mailidir. SMTP server ile gonderilmistir.";

	//$mail->AddCustomHeader($header_);
	$mail->Body = $mesaj;
	$mail->AltBody = $mesajAlt;

	$mail->AddAddress($kime); // Mail g�nderilecek adresleri ekliyoruz.
	$mail->AddCC('okm@mail.ege.edu.tr');



	if ($mail->Send()) {
		$gondermeDurum='1';
	}
	else {
		$gondermeDurum='0';
	}

	$mail->ClearAddresses();
	$mail->ClearCCs();
	$mail->ClearAttachments();


	return $gondermeDurum;


}



function tempKalanSure(){
	if (tempRezId()){
		$kalanDakikaS=mysql_fetch_assoc(mysql_query("SELECT TIMEDIFF('00:30:00',TIMEDIFF(NOW(), userRequestStartDate)) as dak FROM rez_scheduletemp WHERE id=".tempRezId()));
		$kalanDakika=$kalanDakikaS['dak'];
		return substr($kalanDakika,3);		
	}else{
		return false;
	}
	
}

function userDateCheck($userdate){
	$tarihler=explode('-', $userdate);
	if (checkdate($tarihler[1], $tarihler[2], $tarihler[0])){
		return true;
	}else{
		return false;
	}
}
function isTempRezIdValid(){
	
	$gecerliRezSQL="SELECT * FROM rez_scheduletemp WHERE id='".tempRezId()."' AND  userRequestStartDate>(SELECT NOW() - INTERVAL 30 MINUTE)";
	$gecerliRezBilgi=mysql_query($gecerliRezSQL);
	if (mysql_num_rows($gecerliRezBilgi)==0){
		$error['Sure']='15 dakikalık sürede rezervasyonunuz tamamlanmadığından yeni bir rezervasyon kaydı oluşturmanız gerekmektedir.';
		tempRezSonlandir();
	}
}
function amacInfo($amac){
	$boyut=explode('&$&', $amac);
	if (count($boyut)==1){
		$textofPurpose=mysql_fetch_assoc(sec('rez_purposeofuse', '*', "id='".$boyut[0]."'"));
		return $textofPurpose['purpose'];
	}else{
		return $boyut[1];
	}
}

function tempZamanKontrol(){
	if (tempRezId()){
		$gecerliRezSQL="SELECT * FROM rez_scheduletemp WHERE id='".tempRezId()."' AND  userRequestStartDate>(SELECT NOW() - INTERVAL 30 MINUTE)";
		$gecerliRezBilgi=mysql_query($gecerliRezSQL);
		if (mysql_num_rows($gecerliRezBilgi)==0){
			$error['Sure']=ga(2);
			tempRezSonlandir();
			header('Location: rezervasyon');
			return false;
		}
	}else{
		header('Location: rezervasyon');
		return false;
	}
}

function tempYoneticiZamanKontrol(){
	if (tempRezId()){
		$gecerliRezSQL="SELECT * FROM rez_scheduletemp WHERE id='".tempRezId()."' AND  userRequestStartDate>(SELECT NOW() - INTERVAL 30 MINUTE)";
		$gecerliRezBilgi=mysql_query($gecerliRezSQL);
		if (mysql_num_rows($gecerliRezBilgi)==0){
			$error['Sure']=ga(2);
			tempRezSonlandir();
			return false;
		}else{
			return true;
		}
	}else{
		return true;
	}
}
function egitimBilgi($istenen, $egitimId){
		$requestedInfoResult=mysql_fetch_assoc(sec("rez_egitimadlari",$istenen, "id='".$egitimId."'"));
		return $requestedInfoResult[$istenen];
}
function availableOffices($startDate, $endDate, $startTime, $endTime, $mekanTur=0, $gkCheck=1, $temzRezIdCheck=1, $RezCheckPermanentId=0){
	
	if($mekanTur!='0'){
		$typeSql=" type='".$mekanTur."' AND ";
	}else{
		$typeSql='';
	}
	if($gkCheck=='1'){
		$gkSql=" userId<>'".gk()."' AND ";
	}else{
		$gkSql='';
	}
	if($temzRezIdCheck=='1'){
		$temzRezIdCheckSQL=" id<>".tempRezId()." AND ";
	}else{
		$temzRezIdCheckSQL='';
	}
	
	if($RezCheckPermanentId=='0'){
		$RezCheckPermanentSQL='';
	}else{
		$RezCheckPermanentSQL=" id<>".$RezCheckPermanentId." AND ";
	}
	
	$dateSeq="((date>='".$startDate."' AND endDate<='".$endDate."') 		OR (date<='".$startDate."' AND endDate>='".$startDate."') 		OR 	(date<='".$endDate."' AND endDate>='".$endDate."'))";
	$forbidDateSeq="((startDate>='".$startDate."' AND endDate<='".$endDate."') 		OR (startDate<='".$startDate."' AND endDate>='".$startDate."') 		OR 	(startDate<='".$endDate."' AND endDate>='".$endDate."'))";
	$timeSeq="((startTime>='".$startTime."' AND  endTime<='".$endTime."') 	OR (startTime<='".$startTime."' AND  endTime>='".$startTime."') OR  (startTime<='".$endTime."' AND  endTime>='".$endTime."'))";
	
	$rezAraSQL="
	SELECT * FROM rez_offices WHERE active=1 AND ".$typeSql." id NOT IN (
			SELECT officeId FROM rez_schedule WHERE ".$RezCheckPermanentSQL." ".$dateSeq." AND ".$timeSeq."
		)
	AND id NOT IN (
		SELECT officeId FROM rez_scheduletemp WHERE ".$temzRezIdCheckSQL." ".$gkSql." userRequestStartDate>(SELECT NOW() - INTERVAL 30 MINUTE) AND ".$dateSeq." AND ".$timeSeq."
		)
	AND id NOT IN (
		SELECT itemId FROM rez_forbiddendates WHERE forbidType=1 AND ".$forbidDateSeq." AND ".$timeSeq."
		)
	";
	$resultofQuery=mysql_query($rezAraSQL);
	return $resultofQuery;	
}


function howManyEqPermanentInSpecificTime($startDate, $endDate, $startTime, $endTime, $officeId, $eqId){
	$error='0';
	$dateSeq="((date>='".$startDate."' AND endDate<='".$endDate."') 		OR (date<='".$startDate."' AND endDate>='".$startDate."') 		OR 	(date<='".$endDate."' AND endDate>='".$endDate."'))";
	$forbidDateSeq="((startDate>='".$startDate."' AND endDate<='".$endDate."') 		OR (startDate<='".$startDate."' AND endDate>='".$startDate."') 		OR 	(startDate<='".$endDate."' AND endDate>='".$endDate."'))";
	$timeSeq="((startTime>='".$startTime."' AND  endTime<='".$endTime."') 	OR (startTime<='".$startTime."' AND  endTime>='".$startTime."') OR  (startTime<='".$endTime."' AND  endTime>='".$endTime."'))";
	
	$kaliciRez=mysql_query("SELECT * FROM rez_schedule WHERE ".$dateSeq." AND ".$timeSeq." AND officeId=".$officeId."");
	
	if (mysql_num_rows($kaliciRez)==1){
		$officeInfo=mysql_fetch_assoc($kaliciRez);
		$officeId1='k'.$officeInfo['id']; //kalıcı rezervasyon idsi
		
		$howManyEqS=mysql_fetch_assoc(sec('rez_scheduleeq',"*","equipmentId='".$eqId."' AND scheduleId='".$officeInfo['id']."'"));
		
		$inUsedEq=$howManyEqS['number'];
		
	}elseif(mysql_num_rows($kaliciRez)>1){
		$error='1';
	}else{
		$error='0';
		$inUsedEq='0';
	}
	
	if ($error==0){
		return $inUsedEq;
	}else{
		echo 'Malzeme seçiminde hata!';
		return;
	}
}

function howManyEqTemprorayInSpecificTime($startDate, $endDate, $startTime, $endTime, $officeId, $eqId){
	$error='0';
	$dateSeq="((date>='".$startDate."' AND endDate<='".$endDate."') 		OR (date<='".$startDate."' AND endDate>='".$startDate."') 		OR 	(date<='".$endDate."' AND endDate>='".$endDate."'))";
	$forbidDateSeq="((startDate>='".$startDate."' AND endDate<='".$endDate."') 		OR (startDate<='".$startDate."' AND endDate>='".$startDate."') 		OR 	(startDate<='".$endDate."' AND endDate>='".$endDate."'))";
	$timeSeq="((startTime>='".$startTime."' AND  endTime<='".$endTime."') 	OR (startTime<='".$startTime."' AND  endTime>='".$startTime."') OR  (startTime<='".$endTime."' AND  endTime>='".$endTime."'))";

	$kaliciRez=mysql_query("SELECT * FROM rez_scheduletemp WHERE userRequestStartDate>(SELECT NOW() - INTERVAL 30 MINUTE) AND ".$dateSeq." AND ".$timeSeq." AND officeId=".$officeId."");

	if (mysql_num_rows($kaliciRez)==1){
		$officeInfo=mysql_fetch_assoc($kaliciRez);
		$officeId1='k'.$officeInfo['id']; //kalıcı rezervasyon idsi

		$howManyEqS=mysql_fetch_assoc(sec('rez_scheduleeqtemp',"*","equipmentId='".$eqId."' AND scheduleTempId='".$officeInfo['id']."'"));

		$inUsedEq=$howManyEqS['number'];

	}elseif(mysql_num_rows($kaliciRez)>1){
		$error='1';
	}else{
		$error='0';
		$inUsedEq='0';
	}

	if ($error==0){
		return $inUsedEq;
	}else{
		//echo 'Malzeme seçiminde hata!';
		return 0;
	}
}


function isOfficeAvailable($startDate, $endDate, $startTime, $endTime, $officeId){
	
	//9: in temp
	//8: forbidden
	
	$dateSeq="((date>='".$startDate."' AND endDate<='".$endDate."') 		OR (date<='".$startDate."' AND endDate>='".$startDate."') 		OR 	(date<='".$endDate."' AND endDate>='".$endDate."'))";
	$forbidDateSeq="((startDate>='".$startDate."' AND endDate<='".$endDate."') 		OR (startDate<='".$startDate."' AND endDate>='".$startDate."') 		OR 	(startDate<='".$endDate."' AND endDate>='".$endDate."'))";
	$timeSeq="((startTime>='".$startTime."' AND  endTime<='".$endTime."') 	OR (startTime<='".$startTime."' AND  endTime>='".$startTime."') OR  (startTime<='".$endTime."' AND  endTime>='".$endTime."'))";
	
	
	$kaliciRez=mysql_query("SELECT * FROM rez_schedule WHERE ".$dateSeq." AND ".$timeSeq." AND officeId=".$officeId."");
	
	if (mysql_num_rows($kaliciRez)==1){
		$officeInfo=mysql_fetch_assoc($kaliciRez);
		$officeStatus1=$officeInfo['adminConfirm'];
	}elseif(mysql_num_rows($kaliciRez)>1){
		$officeStatus1=66;
	}else{
		$officeStatus1='0';
	}
	
	//if ($officeStatus=='0'){
		
		$kaliciRez=mysql_query("SELECT * FROM rez_scheduletemp WHERE userRequestStartDate>(SELECT NOW() - INTERVAL 30 MINUTE) AND ".$dateSeq." AND ".$timeSeq." AND officeId=".$officeId." ");
		
		if (mysql_num_rows($kaliciRez)>0){
			$officeStatus2='9';
		}else{
			$officeStatus2='0';
		}
		
		//if ($officeStatus=='0'){
			$kaliciRez=mysql_query("SELECT * FROM rez_forbiddendates WHERE forbidType=1 AND ".$forbidDateSeq." AND ".$timeSeq." AND itemId=".$officeId."");
			
			if (mysql_num_rows($kaliciRez)>0){
				$officeStatus3='8';
			}else{
				$officeStatus3='0';
			}
		//}
	//}

	
			
			if ($officeStatus1==0 && $officeStatus2==0 && $officeStatus3==0){
				$officeStatus=0;
			}elseif ($officeStatus1==0 && $officeStatus2==0 && $officeStatus3==8){
				$officeStatus=8;
			}elseif ($officeStatus1==0 && $officeStatus2==9 && $officeStatus3==0){
				$officeStatus=9;
			}elseif ($officeStatus1!=0 && $officeStatus2==0 && $officeStatus3==0){
				$officeStatus=$officeStatus1;
			}elseif ($officeStatus1!=0 && $officeStatus2!=0 && $officeStatus3==0){
				$officeStatus=66;
			}elseif ($officeStatus1!=0 && $officeStatus2==0 && $officeStatus3!=0){
				$officeStatus=66;
			}elseif ($officeStatus1==0 && $officeStatus2!=0 && $officeStatus3!=0){
				$officeStatus=66;
			}else{
				$officeStatus=66;
			}
			
			
	return $officeStatus;

}



function officeRezId($startDate, $endDate, $startTime, $endTime, $officeId){

	//9: in temp
	//8: forbidden

	$dateSeq="((date>='".$startDate."' AND endDate<='".$endDate."') 		OR (date<='".$startDate."' AND endDate>='".$startDate."') 		OR 	(date<='".$endDate."' AND endDate>='".$endDate."'))";
	$forbidDateSeq="((startDate>='".$startDate."' AND endDate<='".$endDate."') 		OR (startDate<='".$startDate."' AND endDate>='".$startDate."') 		OR 	(startDate<='".$endDate."' AND endDate>='".$endDate."'))";
	$timeSeq="((startTime>='".$startTime."' AND  endTime<='".$endTime."') 	OR (startTime<='".$startTime."' AND  endTime>='".$startTime."') OR  (startTime<='".$endTime."' AND  endTime>='".$endTime."'))";


	$kaliciRez=mysql_query("SELECT * FROM rez_schedule WHERE ".$dateSeq." AND ".$timeSeq." AND officeId=".$officeId."");

	if (mysql_num_rows($kaliciRez)==1){
		$officeInfo=mysql_fetch_assoc($kaliciRez);
		$officeStatus1=$officeInfo['adminConfirm'];
		
		$officeId1='k'.$officeInfo['id']; //kalıcı rezervasyon idsi
	}elseif(mysql_num_rows($kaliciRez)>1){
		$officeStatus1=66;
	}else{
		$officeStatus1='0';
	}

	//if ($officeStatus=='0'){

	$kaliciRez=mysql_query("SELECT * FROM rez_scheduletemp WHERE userRequestStartDate>(SELECT NOW() - INTERVAL 30 MINUTE) AND ".$dateSeq." AND ".$timeSeq." AND officeId=".$officeId." ");

	if (mysql_num_rows($kaliciRez)>0){
		$officeStatus2='9';
		$officeId2S=mysql_fetch_assoc($kaliciRez);
		$officeId2='g'.$officeId2S['id']; //geçici rezervasyon idsi
	}else{
		$officeStatus2='0';
	}

	//if ($officeStatus=='0'){
	$kaliciRez=mysql_query("SELECT * FROM rez_forbiddendates WHERE forbidType=1 AND ".$forbidDateSeq." AND ".$timeSeq." AND itemId=".$officeId."");
		
	if (mysql_num_rows($kaliciRez)>0){
		$officeStatus3='8';
		$officeId3S=mysql_fetch_assoc($kaliciRez);
		$officeId3='y'.$officeId3S['id']; //yasaklı rezervasyon idsi
	}else{
		$officeStatus3='0';
	}
	//}
	//}


		
	if ($officeStatus1==0 && $officeStatus2==0 && $officeStatus3==0){
		$officeStatus=0;
		$officeRezId='';
	}elseif ($officeStatus1==0 && $officeStatus2==0 && $officeStatus3==8){
		$officeStatus=8;
		$officeRezId=$officeId3;
	}elseif ($officeStatus1==0 && $officeStatus2==9 && $officeStatus3==0){
		$officeStatus=9;
		$officeRezId=$officeId2;
	}elseif ($officeStatus1!=0 && $officeStatus2==0 && $officeStatus3==0){
		$officeStatus=$officeStatus1;
		$officeRezId=$officeId1;
	}elseif ($officeStatus1!=0 && $officeStatus2!=0 && $officeStatus3==0){
		$officeStatus=66;
		$officeRezId='';
	}elseif ($officeStatus1!=0 && $officeStatus2==0 && $officeStatus3!=0){
		$officeStatus=66;
		$officeRezId='';
	}elseif ($officeStatus1==0 && $officeStatus2!=0 && $officeStatus3!=0){
		$officeStatus=66;
		$officeRezId='';
	}else{
		$officeStatus=66;
		$officeRezId='';
	}
		
		
	return $officeRezId;

}


function forbidedEqNumber($startDate, $endDate, $startTime, $endTime, $eqId){
	
	$forbidDateSeq="((startDate>='".$startDate."' AND endDate<='".$endDate."') 		OR (startDate<='".$startDate."' AND endDate>='".$startDate."') 		OR 	(startDate<='".$endDate."' AND endDate>='".$endDate."'))";
	$timeSeq="((startTime>='".$startTime."' AND  endTime<='".$endTime."') 	OR (startTime<='".$startTime."' AND  endTime>='".$startTime."') OR  (startTime<='".$endTime."' AND  endTime>='".$endTime."'))";
	
	$numberSql=mysql_fetch_assoc(mysql_query("SELECT SUM(number) as number2 FROM rez_forbiddendates WHERE itemId='".$eqId."' AND forbidType=2 AND ".$forbidDateSeq." AND ".$timeSeq.""));
	
	return $numberSql['number2'];
	
}
function isAvailableEq($startDate, $endDate, $startTime, $endTime, $eqId, $number){
	
	
	if ($startDate==''){
		$istenenTarih=tempRezInfo('date');
		$sqlBaslamaTarih=$istenenTarih;
		$bitisTarih=tempRezInfo('endDate');
		$sqlBitisTarih=$bitisTarih;
		$baslamaZamanId=tempRezInfo('startTime');
		$sqlstartTime=$baslamaZamanId;
		$bitisZamanId=tempRezInfo('endTime');
		$sqlendTime=$bitisZamanId;
	}else{
		$istenenTarih=$startDate;
		$sqlBaslamaTarih=$istenenTarih;
		$bitisTarih=$endDate;
		$sqlBitisTarih=$bitisTarih;
		$baslamaZamanId=$startTime;
		$sqlstartTime=$baslamaZamanId;
		$bitisZamanId=$endTime;
		$sqlendTime=$bitisZamanId;
	}
	
	$requestedEqSql=mysql_fetch_assoc(sec('rez_equipments',"*","id=".$eqId));
	$totalNumberofEq=$requestedEqSql['number'];
	
	
	$islemdeOlan=inProgEqNum($eqId, $sqlBaslamaTarih, $sqlBitisTarih, $sqlstartTime, $sqlendTime);
	
	
	$kullanilanMalzeme=inUsedEqNumWithForbidden($eqId,  $sqlBaslamaTarih, $sqlBitisTarih, $sqlstartTime, $sqlendTime);
	
	$totalUsedEq=$islemdeOlan+$kullanilanMalzeme;
	if (($totalNumberofEq - ($totalUsedEq+$number))<0){
		return false;
	}else{
		return true;
	}
	
/*	
	$tempEqUsagesql="SELECT equipmentId,SUM(number) as toplam FROM rez_scheduleeqtemp WHERE equipmentId='".$eqId."' AND scheduleTempId IN (
	SELECT id FROM rez_scheduletemp WHERE id<>".tempRezId()." AND ".$dateSeq." AND  userRequestStartDate>(SELECT NOW() - INTERVAL 30 MINUTE) AND ".$timeSeq."
	)
	GROUP BY equipmentId
	";
	
	$geciciSorguSonuc=mysql_query($tempEqUsagesql);
		
	if (mysql_num_rows($geciciSorguSonuc)==0){
		$islemdeOlan=0;
	}else{
		$geciciOlanMalzemeSayisi=mysql_fetch_assoc($geciciSorguSonuc);
		$islemdeOlan=$geciciOlanMalzemeSayisi['toplam'];
	}
	
	$permanentEqUsagesql="SELECT equipmentId,SUM(number) as toplam2 FROM rez_scheduleeq WHERE equipmentId='".$eqId."' AND scheduleId IN (
	SELECT id FROM rez_schedule WHERE ".$dateSeq." AND  ".$timeSeq."
	)
	GROUP BY equipmentId
	";
		
	$forbidedEqNumber=forbidedEqNumber($startDate, $endDate, $startTime, $endTime, $eqId);
		
	$kaliciSorguSonuc=mysql_query($permanentEqUsagesql);
	
	if (mysql_num_rows($kaliciSorguSonuc)==0){
		$kullanilanMalzeme=0;
	}else{
		$kaliciOlanMalzemeSayisi=mysql_fetch_assoc($kaliciSorguSonuc);
		$kullanilanMalzeme=$kaliciOlanMalzemeSayisi['toplam2'];
	}
		
	$totalUsedEq=$islemdeOlan+$kullanilanMalzeme+$forbidedEqNumber;
	if (($totalNumberofEq - ($totalUsedEq+$number))<0){
		return false;
	}else{
		return true;
	}
*/	
}

function inProgEqNum($eqId, $startDate='', $endDate='', $startTime='', $endTime='' ){
	
	if ($startDate==''){
		$istenenTarih=tempRezInfo('date');
		$sqlBaslamaTarih=$istenenTarih;
		$bitisTarih=tempRezInfo('endDate');
		$sqlBitisTarih=$bitisTarih;
		$baslamaZamanId=tempRezInfo('startTime');
		$sqlstartTime=$baslamaZamanId;
		$bitisZamanId=tempRezInfo('endTime');
		$sqlendTime=$bitisZamanId;
	}else{
		$istenenTarih=$startDate;
		$sqlBaslamaTarih=$istenenTarih;
		$bitisTarih=$endDate;
		$sqlBitisTarih=$bitisTarih;
		$baslamaZamanId=$startTime;
		$sqlstartTime=$baslamaZamanId;
		$bitisZamanId=$endTime;
		$sqlendTime=$bitisZamanId;
	}
	
	
	
	$scanStartDate=$sqlBaslamaTarih;
	$scanEndDate=$sqlBitisTarih;
	
	$theMaxNumberForEq=0;
	
	$dateDif=1;
	$differenceS=mysql_fetch_assoc(mysql_query("SELECT DATEDIFF('".$scanEndDate."','".$scanStartDate."') AS DiffDate"));
	$differenceDates=$differenceS['DiffDate']+1;
	
	while ($dateDif<=$differenceDates) {
		
		$rezTimes=sec('rez_times',"*","1 ORDER BY startTime ASC");
	
		while ($rezTime=mysql_fetch_assoc($rezTimes)){
				
				
			$officeS=sec('rez_offices','*', '1 ORDER BY type, name ASC');
				
			$eqNumbersinOffice=0;
	
			while ($office=mysql_fetch_assoc($officeS)){
					
				$usedEqNum=howManyEqTemprorayInSpecificTime($scanStartDate, $scanStartDate, $rezTime['startTime'], $rezTime['endTime'], $office['id'], $eqId);
	
				$eqNumbersinOffice=$eqNumbersinOffice+$usedEqNum;
	
			}
				
			$totalEqsInSpecificTime=$eqNumbersinOffice;
				
			if ($theMaxNumberForEq<$totalEqsInSpecificTime){
				$theMaxNumberForEq=$totalEqsInSpecificTime;
			}
				
		}
	
		$dateDif++;
		$theNextDayS=mysql_fetch_assoc(mysql_query("SELECT DATE_ADD('".$scanStartDate."', INTERVAL 1 DAY) as nextDay"));
		$scanStartDate=$theNextDayS['nextDay'];
	}
	
	
	
	/*table algortihm ends*/
	
	return $theMaxNumberForEq;
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	/*
	
	$dateSeq="((date>='".$sqlBaslamaTarih."' AND endDate<='".$sqlBitisTarih."') 		OR (date<='".$sqlBaslamaTarih."' AND endDate>='".$sqlBaslamaTarih."') 		OR 	(date<='".$sqlBitisTarih."' AND endDate>='".$sqlBitisTarih."'))";
	$forbidDateSeq="((startDate>='".$sqlBaslamaTarih."' AND endDate<='".$sqlBitisTarih."') 		OR (startDate<='".$sqlBaslamaTarih."' AND endDate>='".$sqlBaslamaTarih."') 		OR 	(startDate<='".$sqlBitisTarih."' AND endDate>='".$sqlBitisTarih."'))";
	$timeSeq="((startTime>='".$sqlstartTime."' AND  endTime<='".$sqlendTime."') 	OR (startTime<='".$sqlstartTime."' AND  endTime>='".$sqlstartTime."') OR  (startTime<='".$sqlendTime."' AND  endTime>='".$sqlendTime."'))";
	
	$tempEqUsagesql="SELECT equipmentId,SUM(number) as toplam FROM rez_scheduleeqtemp WHERE equipmentId='".$eqId."' AND scheduleTempId IN (
	SELECT id FROM rez_scheduletemp WHERE ".$dateSeq." AND  userRequestStartDate>(SELECT NOW() - INTERVAL 30 MINUTE) AND ".$timeSeq."
	)
	GROUP BY equipmentId
	";
	
	$geciciSorguSonuc=mysql_query($tempEqUsagesql);
	
	if (mysql_num_rows($geciciSorguSonuc)==0){
		$islemdeOlan=0;
	}else{
		$geciciOlanMalzemeSayisi=mysql_fetch_assoc($geciciSorguSonuc);
		$islemdeOlan=$geciciOlanMalzemeSayisi['toplam'];
	}
	
	return $islemdeOlan;
	*/
	
}


function inUsedEqNumWithForbidden($eqId, $startDate='', $endDate='', $startTime='', $endTime='' ){

	if ($startDate==''){
		$istenenTarih=tempRezInfo('date');
		$sqlBaslamaTarih=$istenenTarih;
		$bitisTarih=tempRezInfo('endDate');
		$sqlBitisTarih=$bitisTarih;
		$baslamaZamanId=tempRezInfo('startTime');
		$sqlstartTime=$baslamaZamanId;
		$bitisZamanId=tempRezInfo('endTime');
		$sqlendTime=$bitisZamanId;
	}else{
		$istenenTarih=$startDate;
		$sqlBaslamaTarih=$istenenTarih;
		$bitisTarih=$endDate;
		$sqlBitisTarih=$bitisTarih;
		$baslamaZamanId=$startTime;
		$sqlstartTime=$baslamaZamanId;
		$bitisZamanId=$endTime;
		$sqlendTime=$bitisZamanId;
	}
/*
	$dateSeq="((date>='".$sqlBaslamaTarih."' AND endDate<='".$sqlBitisTarih."') OR (date<='".$sqlBaslamaTarih."' AND endDate>='".$sqlBaslamaTarih."') 		OR 	(date<='".$sqlBitisTarih."' AND endDate>='".$sqlBitisTarih."'))";
	$forbidDateSeq="((startDate>='".$sqlBaslamaTarih."' AND endDate<='".$sqlBitisTarih."') 		OR (startDate<='".$sqlBaslamaTarih."' AND endDate>='".$sqlBaslamaTarih."') 		OR 	(startDate<='".$sqlBitisTarih."' AND endDate>='".$sqlBitisTarih."'))";
	$timeSeq="((startTime>='".$sqlstartTime."' AND  endTime<='".$sqlendTime."') 	OR (startTime<='".$sqlstartTime."' AND  endTime>='".$sqlstartTime."') OR  (startTime<='".$sqlendTime."' AND  endTime>='".$sqlendTime."'))";

	$permanentEqUsagesql="SELECT equipmentId,SUM(number) as toplam2 FROM rez_scheduleeq WHERE equipmentId='".$eqId."' AND scheduleId IN (
	SELECT id FROM rez_schedule WHERE ".$dateSeq." AND  ".$timeSeq."
	)
	GROUP BY equipmentId
	";
*/	
	/*the new counintg from table alg.*/
		
	$scanStartDate=$sqlBaslamaTarih;
	$scanEndDate=$sqlBitisTarih;
	
	$theMaxNumberForEq=0;
	
	
	$dateDif=1;
	$differenceS=mysql_fetch_assoc(mysql_query("SELECT DATEDIFF('".$scanEndDate."','".$scanStartDate."') AS DiffDate"));
	$differenceDates=$differenceS['DiffDate']+1;
	
	while ($dateDif<=$differenceDates) {
	
		$rezTimes=sec('rez_times',"*","1 ORDER BY startTime ASC");
		
		while ($rezTime=mysql_fetch_assoc($rezTimes)){
			
			
			$officeS=sec('rez_offices','*', '1 ORDER BY type, name ASC');
			
			$eqNumbersinOffice=0;

			while ($office=mysql_fetch_assoc($officeS)){
			
				$usedEqNum=howManyEqPermanentInSpecificTime($scanStartDate, $scanStartDate, $rezTime['startTime'], $rezTime['endTime'], $office['id'], $eqId);
				
				$eqNumbersinOffice=$eqNumbersinOffice+$usedEqNum;
				
			}
			
			/*add forbidden eqs*/
			
			$forbidedEqForSpecifictime=forbidedEqNumber($scanStartDate, $scanStartDate, $rezTime['startTime'], $rezTime['endTime'], $eqId);
			
			/*ends add forbidden eqs*/
			
			$totalEqsInSpecificTime=$eqNumbersinOffice+$forbidedEqForSpecifictime;
			
			if ($theMaxNumberForEq<$totalEqsInSpecificTime){
				$theMaxNumberForEq=$totalEqsInSpecificTime;
			}
			
		}
		
		$dateDif++;
		$theNextDayS=mysql_fetch_assoc(mysql_query("SELECT DATE_ADD('".$scanStartDate."', INTERVAL 1 DAY) as nextDay"));
		$scanStartDate=$theNextDayS['nextDay'];
	}
	
	
	
	/*table algortihm ends*/
	
	
	
	return $theMaxNumberForEq;
	
	
	
	
	
/*	
	//Proper eq listing start OLD ALGORTIHMMMMMMMM
	
	$scanStartDate=$sqlBaslamaTarih;
	$scanEndDate=$sqlBitisTarih;
	
	
	while ($scanStartDate<=$scanEndDate) {
	
		$scanDateSeq="date<='".$scanStartDate."' AND endDate>='".$scanStartDate."'";
	
		$scanRelatedDateSql="SELECT id,startTime,endTime FROM rez_schedule WHERE 
		".$scanDateSeq." AND
		".$timeSeq." AND
		id IN (SELECT scheduleId FROM rez_scheduleeq WHERE equipmentId='".$eqId."')
		ORDER BY startTime, endTime-startTime ASC";
							
		$resultsForCurrentDate=mysql_query($scanRelatedDateSql);
		
		$i=0;
		while ($pushArray=mysql_fetch_assoc($resultsForCurrentDate)){
			$resultsForCurrentDateArray[$i]['id']=$pushArray['id'];
			$resultsForCurrentDateArray[$i]['startTime']=$pushArray['startTime'];
			$resultsForCurrentDateArray[$i]['endTime']=$pushArray['endTime'];
			$resultsForCurrentDateArray[$i]['eqNumb']=numberOfEqInUse($eqId, $pushArray['id']);
			
			$relatedScheduleIds[$pushArray['id']]=$pushArray['id'];
			$i++;
		}
		
		$minStartTime=$relatedScheduleIds[0]; //get the minimum startTime;
		
		$scheduleIdsWithComma=implode(',', $relatedScheduleIds);
		
		
		//below line is going to find max number eq with minumum starttime to reduce total number...
		$findFirstStarter=mysql_fetch_assoc(mysql_query("SELECT s.id, s.startTime, s.endTime, e.number FROM rez_schedule s, rez_scheduleeq e WHERE s.startTime>='".$resultsForCurrentDateArray[0]['startTime']."' AND s.endTime<='".$resultsForCurrentDateArray[0]['endTime']."' AND s.id=e.scheduleId AND e.equipmentId='".$eqId."' AND s.id IN (".$scheduleIdsWithComma.") ORDER BY e.number DESC, s.startTime ASC"));
		
		$j=0;
		
		$lines[$j]['id']=$findFirstStarter['id'];
		$lines[$j]['startTime']=$findFirstStarter['startTime'];
		$lines[$j]['endTime']=$findFirstStarter['endTime'];
		$lines[$i]['eqNumb']=$findFirstStarter['number'];
		
		unset($relatedScheduleIds[$findFirstStarter['id']]);
		$scheduleIdsWithComma=implode(',', $relatedScheduleIds);
		
		$searchEndTime=$findFirstStarter['endTime'];
		$nextScheduleAvailable=true;
		
		
		while ($nextScheduleAvailable==true) {
		
			$findNextSchedule=mysql_query("SELECT s.id, s.startTime, s.endTime, e.number FROM rez_schedule s, rez_scheduleeq e WHERE s.startTime>='".$searchEndTime."' AND s.id=e.scheduleId AND e.equipmentId='".$eqId."' 
					AND s.id IN (".$scheduleIdsWithComma.") ORDER BY e.number DESC, s.startTime ASC");
			$calculateNextScheduleNum=mysql_num_rows($findNextSchedule);
			
			if ($calculateNextScheduleNum==0){
				//there is no more next schedule for this line
				$nextScheduleAvailable=false;
			}else{
				//go on sequencing
				$nextScheduleAvailable=true;
				$j++;
	
				$nextScheduleInfo=mysql_fetch_assoc($findNextSchedule);
				
				$lines[$j]['id']=$nextScheduleInfo['id'];
				$lines[$j]['startTime']=$nextScheduleInfo['startTime'];
				$lines[$j]['endTime']=$nextScheduleInfo['endTime'];
				$lines[$i]['eqNumb']=$nextScheduleInfo['number'];
				
				
				unset($relatedScheduleIds[$nextScheduleInfo['id']]);
				$scheduleIdsWithComma=implode(',', $relatedScheduleIds);
				$searchEndTime=$nextScheduleInfo['endTime'];
				
			}
		}
		
		
		
	
	
	
	
		//gather next date from date range!!!!
	
	
	}
	
	
	//proper eq lsiting end
	
	
	*/
	
	
	
	
	
	
	
	
/* eski algoritma
	$forbidedEqNumber=forbidedEqNumber($sqlBaslamaTarih, $sqlBitisTarih, $sqlstartTime, $sqlendTime, $eqId);

	$kaliciSorguSonuc=mysql_query($permanentEqUsagesql);
	if (mysql_num_rows($kaliciSorguSonuc)==0){
		$kullanilanMalzeme=0;
	}else{
		$kaliciOlanMalzemeSayisi=mysql_fetch_assoc($kaliciSorguSonuc);
		$kullanilanMalzeme=$kaliciOlanMalzemeSayisi['toplam2'];
	}

	$kullanilanMalzeme=$kullanilanMalzeme+$forbidedEqNumber;


	return $kullanilanMalzeme;
*/
}


function TotalEqNum($eqId ){

	$toplamMalzemeSQL=mysql_fetch_assoc(sec("rez_equipments","*","id=".$eqId));
 	return $toplamMalzemeSQL['number'];
	 
}
function numberOfEqInUse($eqId, $scheduleId){
	
	$numberOfEqSql=sec("rez_scheduleeq","*","scheduleId='".$scheduleId."' AND equipmentId='".$eqId."'");
	
	if(mysql_num_rows($numberOfEqSql)>1){
		return false;
	}elseif (mysql_num_rows($numberOfEqSql)==0){
		return false;
	}else{
		$resultOfNumb=mysql_fetch_assoc($numberOfEqSql);
		return $resultOfNumb['number'];
	}	
}

function leftSelectEqNum($eqId, $startDate='', $endDate='', $startTime='', $endTime='' ){
	
	$toplamMalzeme=TotalEqNum($eqId);
	$kullanilanMalzeme=inUsedEqNumWithForbidden($eqId, $startDate='', $endDate='', $startTime='', $endTime='');
	$islemdeOlan=inProgEqNum($eqId, $startDate='', $endDate='', $startTime='', $endTime='');
	
	$secilebilirMalzeme=$toplamMalzeme - ($kullanilanMalzeme + $islemdeOlan);
	
	return $secilebilirMalzeme;
}
function kalipforeqNOTUSINGGGGGGG($eqId, $startDate='', $endDate='', $startTime='', $endTime='' ){

	if ($startDate==''){
		$istenenTarih=tempRezInfo('date');
		$sqlBaslamaTarih=$istenenTarih;
		$bitisTarih=tempRezInfo('endDate');
		$sqlBitisTarih=$bitisTarih;
		$baslamaZamanId=tempRezInfo('startTime');
		$sqlstartTime=$baslamaZamanId;
		$bitisZamanId=tempRezInfo('endTime');
		$sqlendTime=$bitisZamanId;
	}else{
		$istenenTarih=$startDate;
		$sqlBaslamaTarih=$istenenTarih;
		$bitisTarih=$endDate;
		$sqlBitisTarih=$bitisTarih;
		$baslamaZamanId=$startTime;
		$sqlstartTime=$baslamaZamanId;
		$bitisZamanId=$endTime;
		$sqlendTime=$bitisZamanId;
	}

	$dateSeq="((date>='".$sqlBaslamaTarih."' AND endDate<='".$sqlBitisTarih."') 		OR (date<='".$sqlBaslamaTarih."' AND endDate>='".$sqlBaslamaTarih."') 		OR 	(date<='".$sqlBitisTarih."' AND endDate>='".$sqlBitisTarih."'))";
	$forbidDateSeq="((startDate>='".$sqlBaslamaTarih."' AND endDate<='".$sqlBitisTarih."') 		OR (startDate<='".$sqlBaslamaTarih."' AND endDate>='".$sqlBaslamaTarih."') 		OR 	(startDate<='".$sqlBitisTarih."' AND endDate>='".$sqlBitisTarih."'))";
	$timeSeq="((startTime>='".$sqlstartTime."' AND  endTime<='".$sqlendTime."') 	OR (startTime<='".$sqlstartTime."' AND  endTime>='".$sqlstartTime."') OR  (startTime<='".$sqlendTime."' AND  endTime>='".$sqlendTime."'))";

	$tempEqUsagesql="SELECT equipmentId,SUM(number) as toplam FROM rez_scheduleeqtemp WHERE equipmentId='".$eqId."' AND scheduleTempId IN (
	SELECT id FROM rez_scheduletemp WHERE ".$dateSeq." AND  userRequestStartDate>(SELECT NOW() - INTERVAL 30 MINUTE) AND ".$timeSeq."
	)
	GROUP BY equipmentId
	";
	$geciciSorguSonuc=mysql_query($tempEqUsagesql);

	if (mysql_num_rows($geciciSorguSonuc)==0){
		$islemdeOlan=0;
	}else{
		$geciciOlanMalzemeSayisi=mysql_fetch_assoc($geciciSorguSonuc);
		$islemdeOlan=$geciciOlanMalzemeSayisi['toplam'];
	}


	$resultofStatus['inProgS']=$islemdeOlan;

	$permanentEqUsagesql="SELECT equipmentId,SUM(number) as toplam2 FROM rez_scheduleeq WHERE equipmentId='".$eqId."' AND scheduleId IN (
	SELECT id FROM rez_schedule WHERE ".$dateSeq." AND  ".$timeSeq."
	)
	GROUP BY equipmentId
	";

	$forbidedEqNumber=forbidedEqNumber($sqlBaslamaTarih, $sqlBitisTarih, $sqlstartTime, $sqlendTime, $eqId);


	$kaliciSorguSonuc=mysql_query($permanentEqUsagesql);
	if (mysql_num_rows($kaliciSorguSonuc)==0){
		$kullanilanMalzeme=0;
	}else{
		$kaliciOlanMalzemeSayisi=mysql_fetch_assoc($kaliciSorguSonuc);
		$kullanilanMalzeme=$kaliciOlanMalzemeSayisi['toplam2'];
	}



	$kullanilanMalzeme=$kullanilanMalzeme+$forbidedEqNumber;

	$resultofStatus['inUsedS']=$kullanilanMalzeme;

	//	echo $tempEqUsagesql;

	$toplamMalzemeSQL=mysql_fetch_assoc(sec("rez_equipments","*","id=".$eqId));
	$toplamMalzeme=$toplamMalzemeSQL['number'];

	$resultofStatus['inTotalS']=$toplamMalzeme;

	$secilebilirMalzeme=$toplamMalzeme - ($kullanilanMalzeme + $islemdeOlan);

	$resultofStatus['SelectS']=$secilebilirMalzeme;


	echo json_encode($resultofStatus);
}

function rezDates($scheduleId){
	
	$rezInfo=mysql_fetch_assoc(sec("rez_schedule","*","id='".$scheduleId."'"));
	
	if ($rezInfo['date']==$rezInfo['endDate']){
		$rezDate=tarih_turkce2($rezInfo['date']);
	}else{
		$rezDate=tarih_turkce2($rezInfo['date']).'-'.tarih_turkce2($rezInfo['endDate']);
	}
	return $rezDate;
	
}
function rezTimes($scheduleId){

	$rezInfo=mysql_fetch_assoc(sec("rez_schedule","*","id='".$scheduleId."'"));

	if ($rezInfo['startTime']=='00:00:01'){
		$rezTime='Tüm Gün';
		
	}else{
		$rezTime=ekranSaati($rezInfo['startTime']).'-'.ekranSaati($rezInfo['endTime']);
		
	}
	return $rezTime;

}

function forbiddenDateCheckForDay($sqlBaslamaTarih, $sqlBitisTarih, $sqlstartTime, $sqlendTime){
	
	$forbidDateSeq="((startDate>='".$sqlBaslamaTarih."' AND endDate<='".$sqlBitisTarih."') 		OR (startDate<='".$sqlBaslamaTarih."' AND endDate>='".$sqlBaslamaTarih."') 		OR 	(startDate<='".$sqlBitisTarih."' AND endDate>='".$sqlBitisTarih."'))";
	$timeSeq="((startTime>='".$sqlstartTime."' AND  endTime<='".$sqlendTime."') 	OR (startTime<='".$sqlstartTime."' AND  endTime>='".$sqlstartTime."') OR  (startTime<='".$sqlendTime."' AND  endTime>='".$sqlendTime."'))";
	
	$kaliciRez=mysql_query("SELECT * FROM rez_forbiddendates WHERE forbidType=3 AND ".$forbidDateSeq." AND ".$timeSeq."");
	
	if (mysql_num_rows($kaliciRez)>0){
		return false;
	}else{
		return true;
	}
	
}

?>