<?php

function dosyaAdiLinkYap($dosyaAdi){
	
	$sayfaBilgi=sec("pages","*","includePage='".$dosyaAdi."'");
	if(mysql_numrows($sayfaBilgi)>1){
		die("Birden çok aynı isimde dahil edilecek dosya bulundu.");
	}else{
		
		$ilgiliSayfa=mysql_fetch_assoc($sayfaBilgi);
		
		return linkVer($ilgiliSayfa['pageId']);
		
		
		
	}
}

function kullaniciAdi($kullaniciId){
	
	$kulAdi=mysql_fetch_assoc(sec("administrator","*","adminId=".$kullaniciId));
	
	return $kulAdi['adminName'];
	
	
}

function userInfo($userId, $needed='fullName'){
	
	$kullaniciBilgi=mysql_fetch_assoc(sec('users','*',"id=".$userId));
	
	if($needed=='fullName'){
		if ($kullaniciBilgi['userType']==3){
			$titleShown=$kullaniciBilgi['userName'];
		}else{
			$titleShown=$kullaniciBilgi['title'];
		}
		$returnInfo= $titleShown.' '.$kullaniciBilgi['firstName'].' '.$kullaniciBilgi['lastName'];
	}else{
		$returnInfo=$kullaniciBilgi[$needed];
	}
	
	return $returnInfo;	
}
function urlSeoYap ( $tmptitle ) {
 
          $returnstr = "";
 
          $turkcefrom = array("/Ğ/","/Ü/","/Ş/","/İ/","/Ö/","/Ç/","/ğ/","/ü/","/ş/","/ı/","/ö/","/ç/");
 
          $turkceto   = array("G","U","S","I","O","C","g","u","s","i","o","c");
 
      
 
          //$tmptitle = mb_convert_encoding("$tmptitle","ISO-8859-9");
 
      
 
          # Alfanumerik olmayan karekterleri boşluk yap
 
          $tmptitle = preg_replace("/[^0-9a-zA-ZÄzÜŞİÖÇğüşıöç]/"," ",$tmptitle);
        
            # Türkçe harfleri ingilizceye çevir
 
          $tmptitle = preg_replace($turkcefrom,$turkceto,$tmptitle);
 
      
            # Birden fazla olan boşlukları tek boşluk yap
 
         $tmptitle = preg_replace("/ +/"," ",$tmptitle);
 
      
            # Boşukları - işaretine çevir
 
          $tmptitle = preg_replace("/ /","-",$tmptitle);
 
      
 
          # Tüm beyaz karekterleri sil
 
          $tmptitle = preg_replace("/\s/","",$tmptitle);
 
      
 
          # Karekterleri küçült
        //    $tmptitle = strtolower($tmptitle);
       
 
          # Başta ve sonda - işareti kaldıysa yoket
            $tmptitle = preg_replace("/^-/","",$tmptitle);
 
          $tmptitle = preg_replace("/-$/","",$tmptitle);
 
      
 
          # Tarih'i biçimlendir.
 
          //$tmpdate = date("/Y/m/d/",$tmpdate);
 
      		#harfleri küçük yap
          $tmptitle=strtolower($tmptitle);
 
          $returnstr =  $tmptitle;
 
      
 
          return $returnstr;
 
      }
function urlIdBul($pageTitle){
	
	$xPage=sec("pages","*","friendlyName='".$pageTitle."'");
	if (mysql_num_rows($xPage)==0) {
		return false;
	}else{
		return mysql_fetch_assoc($xPage);
	}	
}
function replace_tr($text) {
$text = trim($text);
$search = array('Ç','ç','Ğ','ğ','ı','İ','Ö','ö','Ş','ş','Ü','ü');
$replace = array('C','c','G','g','i','I','O','o','S','s','U','u');
$new_text = str_replace($search,$replace,$text);
return $new_text;
}  

function tarih_duzenle($ekran_tarih){
	$ajax_tarih=$ekran_tarih;
	$ajax_tarih=str_replace('/','-',$ajax_tarih);
$ajax_tarih=str_replace('.','-',$ajax_tarih);
$tarih_duzen=explode('-',$ajax_tarih);

krsort($tarih_duzen);

$bakilacak_tarih=implode('-',$tarih_duzen);
return $bakilacak_tarih;
}
function tarih_turkce($ekran_tarih){
	
	$tarihAylar=array('','Ocak','Şubat','Mart','Nisan','Mayıs','Haziran','Temmuz','Ağustos','Eylül','Ekim','Kasım','Aralık');
	
	$donen_tarihGun=mysql_fetch_assoc(sec('settings',"DATE_FORMAT('".$ekran_tarih."','%d') as gun "));
	$donen_tarihAy=mysql_fetch_assoc(sec('settings',"DATE_FORMAT('".$ekran_tarih."','%c') as ay "));
	$donen_tarihYil=mysql_fetch_assoc(sec('settings',"DATE_FORMAT('".$ekran_tarih."','%Y') as yil "));
	
	$toplamTarih=$donen_tarihGun['gun'].' '.$tarihAylar[$donen_tarihAy['ay']].' '.$donen_tarihYil['yil'];
	
	/*$ajax_tarih=$ekran_tarih;

		$tarih_duzen=explode('-',$ajax_tarih);

		krsort($tarih_duzen);

	$bakilacak_tarih=implode('.',$tarih_duzen);
	*/
return $toplamTarih;

}
function tarih_turkce_tur($ekran_tarih, $bitisTarihi){

	$tarihAylar=array('','Ocak','Şubat','Mart','Nisan','Mayıs','Haziran','Temmuz','Ağustos','Eylül','Ekim','Kasım','Aralık');

	$donen_tarihGun=mysql_fetch_assoc(sec('settings',"DATE_FORMAT('".$ekran_tarih."','%d') as gun "));
	$donen_tarihAy=mysql_fetch_assoc(sec('settings',"DATE_FORMAT('".$ekran_tarih."','%c') as ay "));
	$donen_tarihYil=mysql_fetch_assoc(sec('settings',"DATE_FORMAT('".$ekran_tarih."','%Y') as yil "));
	
	$donen_tarihGun2=mysql_fetch_assoc(sec('settings',"DATE_FORMAT('".$bitisTarihi."','%d') as gun "));
	$donen_tarihAy2=mysql_fetch_assoc(sec('settings',"DATE_FORMAT('".$bitisTarihi."','%c') as ay "));
	$donen_tarihYil2=mysql_fetch_assoc(sec('settings',"DATE_FORMAT('".$bitisTarihi."','%Y') as yil "));
	
	
	if ($donen_tarihYil==$donen_tarihYil2){
		
		if ($donen_tarihAy==$donen_tarihAy2){
			$toplamTarih=$donen_tarihGun['gun'].'-'.$donen_tarihGun2['gun'].' '.$tarihAylar[$donen_tarihAy2['ay']].' '.$donen_tarihYil2['yil'];
		}else{
			$toplamTarih=$donen_tarihGun['gun'].' '.$tarihAylar[$donen_tarihAy['ay']].'-'.$donen_tarihGun2['gun'].' '.$tarihAylar[$donen_tarihAy2['ay']].' '.$donen_tarihYil2['yil'];
		}
		
		
	}else{
		$toplamTarih=$donen_tarihGun['gun'].' '.$tarihAylar[$donen_tarihAy['ay']].' '.$donen_tarihYil['yil']. '-'.$donen_tarihGun2['gun'].' '.$tarihAylar[$donen_tarihAy2['ay']].' '.$donen_tarihYil2['yil'];
	}
	

	

	/*$ajax_tarih=$ekran_tarih;

	$tarih_duzen=explode('-',$ajax_tarih);

	krsort($tarih_duzen);

	$bakilacak_tarih=implode('.',$tarih_duzen);
	*/
	return $toplamTarih;

}
function tarih_turkce2($ekran_tarih){

	$tarihAylar=array('','OCAK','ŞUBAT','MART','NİSAN','MAYIS','HAZİRAN','TEMMUZ','AĞUSTOS','EYLÜL','EKİM','KASIM','ARALIK');

	$donen_tarihGun=mysql_fetch_assoc(sec('settings',"DATE_FORMAT('".$ekran_tarih."','%d') as gun "));
	$donen_tarihAy=mysql_fetch_assoc(sec('settings',"DATE_FORMAT('".$ekran_tarih."','%m') as ay "));
	$donen_tarihYil=mysql_fetch_assoc(sec('settings',"DATE_FORMAT('".$ekran_tarih."','%Y') as yil "));

	$toplamTarih=$donen_tarihGun['gun'].'.'.$donen_tarihAy['ay'].'.'.$donen_tarihYil['yil'];
	return $toplamTarih;

}
function saatli_tarih_turkce($ekran_tarih){

	$tarihAylar=array('','OCAK','ŞUBAT','MART','NİSAN','MAYIS','HAZİRAN','TEMMUZ','AĞUSTOS','EYLÜL','EKİM','KASIM','ARALIK');

	$donen_tarihGun=mysql_fetch_assoc(sec('settings',"DATE_FORMAT('".$ekran_tarih."','%d') as gun "));
	$donen_tarihAy=mysql_fetch_assoc(sec('settings',"DATE_FORMAT('".$ekran_tarih."','%c') as ay "));
	$donen_tarihYil=mysql_fetch_assoc(sec('settings',"DATE_FORMAT('".$ekran_tarih."','%Y') as yil "));
	$donen_tarihSaat=mysql_fetch_assoc(sec('settings',"DATE_FORMAT('".$ekran_tarih."','%H:%i') as saat "));

	$toplamTarih=$donen_tarihGun['gun'].' '.$tarihAylar[$donen_tarihAy['ay']].' '.$donen_tarihYil['yil'].' '.$donen_tarihSaat['saat'];

	/*$ajax_tarih=$ekran_tarih;

	$tarih_duzen=explode('-',$ajax_tarih);

	krsort($tarih_duzen);

	$bakilacak_tarih=implode('.',$tarih_duzen);
	*/
	return $toplamTarih;

}
 
function ifade_kontrol($ifade){
	$ifade=trim($ifade);
	$ifade=mysql_real_escape_string($ifade);
	$ifade=strip_tags($ifade);
	
	return $ifade;
}


function sec($tablo,$sutun='*',$kosul='1'){
	$ifade="SELECT ".$sutun." FROM ".$tablo." WHERE ".$kosul;
	$sonuc=mysql_query($ifade);
	return $sonuc;
}

function dosya_temizle($yol){
	$temiz=str_replace('../','',$yol);
	return $temiz;
}

function son_no($tablo,$sutun){
	$maks='MAX('.$sutun.') as son_numara';
	$son_no=sec($tablo,$maks);
	$son_no=mysql_fetch_assoc($son_no);
	if($son_no['son_numara']==0){
		$son_no['son_numara']=1;
	}else{
		$son_no['son_numara']++;
	}
	return $son_no['son_numara'];
}


function f_isim($no){
	
	$f_isim=sec('personel',"CONCAT(isim,' ',soyisim) as f ",'no='.$no);
	$f_isim=mysql_fetch_assoc($f_isim);
	return $f_isim['f'];
}



function ajaxturkishreplace($newphrase) {
$newphrase = str_replace("Ãœ","Ü",$newphrase);
$newphrase = str_replace("Å&#158;","Ş",$newphrase);
$newphrase = str_replace("Ä&#158;","Ğ",$newphrase);
$newphrase = str_replace("Ã‡","Ç",$newphrase);
$newphrase = str_replace("Ä°","İ",$newphrase);
$newphrase = str_replace("Ã–","Ö",$newphrase);
$newphrase = str_replace("Ã¼","ü",$newphrase);
$newphrase = str_replace("ÅŸ","ş",$newphrase);
$newphrase = str_replace("Ã§","ç",$newphrase);
$newphrase = str_replace("Ä±","ı",$newphrase);
$newphrase = str_replace("Ã¶","ö",$newphrase);
$newphrase = str_replace("ÄŸ","ğ",$newphrase);

return $newphrase;
}


function eposta_kontrol($eposta){
	
	$regex = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/';
	if(preg_match($regex, $eposta)) {
		return $eposta;
	}else{
		return false;
	}	
}


function adminMailleri(){
	
	$adminler=sec("administrator", "*", "kullaniciGrup=1");
	
	$mailAdresleri='';
	while ($amail=mysql_fetch_assoc($adminler)) {
		$mailAdresleri.=$amail['email'].', ';
	}
	return $mailAdresleri;
}

	function aliasdanMenuId($alias){
		
		$ilgiliSayfa=mysql_fetch_assoc(sec('menu','*',"alias='".$alias."'"));
		
		return $ilgiliSayfa['id'];		
		
	}
	
	
	// $node is the name of the node we want the path of
	
function get_path($nodeid) {
   // look up the parent of this node
   $result = mysql_query("SELECT parent FROM menu ".
                          "WHERE id='".$nodeid."'");
   $row = mysql_fetch_array($result);

   // save the path in this array
   $path = array();

   // only continue if this $node isn't the root node
   // (that's the node with no parent)
   if ($row['parent']!=0) {
       // the last part of the path to $node, is the name
       // of the parent of $node
       $path[] = $row['parent'];

       // we should add the path to the parent of this node
       // to the path
       $path = array_merge(get_path($row['parent']), $path);
   }

   // return the path
   return $path;
} 

function get_path_alias($nodeid) {

		$siraDizi=get_path($nodeid);
		$linkHtml='';
		
		foreach ($siraDizi as $key => $value){
			
			$ilgiliAlias=mysql_fetch_assoc(sec('menu','alias','id='.$value));
			$linkHtml.=$ilgiliAlias['alias'].'/';
			
		}
		return $linkHtml;
} 


function get_pathMenuName($nodeid) {
	// look up the parent of this node
	$result = mysql_query("SELECT parent FROM menu ".
			"WHERE id='".$nodeid."'");
	$row = mysql_fetch_array($result);

	// save the path in this array
	$path = array();

	// only continue if this $node isn't the root node
	// (that's the node with no parent)
	if ($row['parent']!=0) {
		// the last part of the path to $node, is the name
		// of the parent of $node
		$path[] = $row['parent'];

		// we should add the path to the parent of this node
		// to the path
		$path = array_merge(get_pathMenuName($row['parent']), $path);
	}

	// return the path
	return $path;
}


function get_path_name($nodeid) {

	$siraDizi=get_pathMenuName($nodeid);
	$linkHtml='';

	foreach ($siraDizi as $key => $value){
			
		$ilgiliAlias=mysql_fetch_assoc(sec('menu','name, alias','id='.$value));
		$linkHtml.='<a href="'.menuLinkVer($ilgiliAlias['alias']).'" >'.$ilgiliAlias['name'].'</a> / ';
			
	}
	
	$result = mysql_query("SELECT name FROM menu ".
			"WHERE id='".$nodeid."'");
	$row = mysql_fetch_array($result);
	
	$linkHtml.=$row['name'];
	return $linkHtml;
}


function get_pathOfContent($nodeid) {//notused
	// look up the parent of this node
	$result = mysql_query("SELECT parent FROM icerikler ".
			"WHERE id='".$nodeid."'");
	$row = mysql_fetch_array($result);

	// save the path in this array
	$path = array();

	// only continue if this $node isn't the root node
	// (that's the node with no parent)
	if ($row['parent']!=0) {
		// the last part of the path to $node, is the name
		// of the parent of $node
		$path[] = $row['parent'];

		// we should add the path to the parent of this node
		// to the path
		$path = array_merge(get_path($row['parent']), $path);
	}

	// return the path
	return $path;
}

function get_path_aliasOfcontent($nodeid) { //notused

	$siraDizi=get_pathOfContent($nodeid);

	$linkHtml='';

	foreach ($siraDizi as $key => $value){
			
			
		$ilgiliAlias=mysql_fetch_assoc(sec('menu','alias','id='.$value));
		$linkHtml.=$ilgiliAlias['alias'].'/';
			
			
			
	}


	return $linkHtml;

}


function buNeki($alias){
	
	$aliasTur=mysql_fetch_assoc(sec('icerikler','*',"dostid='".$alias."'"));
	
	return $aliasTur['iceriktur'];
	
	
}

function aliasdanIcerikOzellikleri($alias){
	$aliasTur=mysql_fetch_assoc(sec('icerikler','*',"dostid='".$alias."'"));
	
	return $aliasTur;
}
function icerikTurInc($icerikTurId){
	$icerikTurOzellikleri=mysql_fetch_assoc(sec('icerikturleri','*',"iceriktur='".$icerikTurId."'"));
	
	if ($icerikTurOzellikleri['incpage']=='') {
		return false;
	}else{
		return $icerikTurOzellikleri['incpage'];
	}
}

function menu_mu($alias){
	
	$Menumu=mysql_num_rows(sec('menu','*',"alias='".$alias."'"));
	
	if ($Menumu>0) {
		return true;
	}else{
		return false;
	}
	
	
}


function sifreHatirlat($email){

	
	
		return false; ///bu kullanılmıyor
		
	
		$kullanici=mysql_fetch_assoc(sec("administrator","*","userName='".$email."' AND aktif=1"));
		
		$kullaniciId=$kullanici['adminId'];
		
		$sifre=substr(md5(rand()),8,6);
		
		$sifreMd5=md5($sifre);
		
		
		$updateUser='
			UPDATE administrator
			SET
			adminPass="'.$sifreMd5.'"
			
			where adminId="'.$kullaniciId.'" ';
		
		
				if (mysql_query($updateUser)) {
						
							$kime=$kullanici['email'];
						
							$baslik ='Su Okulu Şifre Hatırlatma e-postası';
							
							$mesaj ='Sayın Kullanıcı; '."\r\n\r\n";
							
							$mesaj.='Su okulu giriş bilgileriniz aşağıda belirtilmiştir. 
							
							' . "\r\n" . "\r\n".'
							'.ayarAl('siteAdi'). "\r\n".'
							Kullanıcı Adı: '.$kullanici['userName']. "\r\n".'
							Şifre: '.$sifre. "\r\n".'
							';
							
							$mesaj_nereden='Su Okulu';
						
							$headers ="From: =?UTF-8?B?".base64_encode($mesaj_nereden)."?= <". ''.ayarAl('mailAdresi').'>' . "\r\n";
							
							$header_ = 'MIME-Version: 1.0' . "\r\n" . 'Content-type: text/plain; charset=UTF-8' . "\r\n";
						
							
							if(mail($kime, '=?UTF-8?B?'.base64_encode($baslik).'?=', $mesaj, $header_ . $headers)){
						
								return true;
							}else{
								
								return false;
							}	
				}else{
					return false;
				}
		
		
		
		
}

function sifreSifrele($duzSifre){
	$sifreliSifre=sha1(md5(md5($duzSifre)));
	return $sifreliSifre;
}
function siteAdi(){
	return ayarAl('siteAdi');
}


function yetkiKontrol(){
	$istenenSayfa= $GLOBALS['istenenSayfaAlias'];
	
	$userTypeS=mysql_fetch_assoc(sec("users","*","id=".gk()));
	$userType=$userTypeS['userType'];
	
	
	$icerikId=aliasdanIcerikOzellikleri($istenenSayfa);
	
	
	$rolVarmi=mysql_num_rows(sec('userrolls',"*","userType='".$userType."' AND menuId=".$icerikId['icerikid']));
	
	
	if ($rolVarmi>0){
		
	}else{
		
		printHead('');
		
		printHeader($istenenSayfa);
		
		ekranMesaji('Yetki dışı erişim',"error");
		
		printFooter();
		die;
	}
	
	
}
function is_digits($dene) {
	return !preg_match ("/[^0-9]/", $dene);
}
function postaTurOlustu($isim, $soyisim, $email, $tourLink){

	if (trim($isim)=='' && trim($soyisim)==''){
		$kimAdi='İlgili';
	}else{
		$kimAdi=$isim.' '.$soyisim;
	}
	
	
	

	$kime=$email;


	$baslik ='Tur Bilgileriniz';

	$mesajIcerik='Sizin için hazırlamış olduğumuz tur programına aşağıdaki linkten ulaşabilirsiniz.';

	$mesaj =ePostaHTML($kimAdi, $mesajIcerik,'', $tourLink);


	$mesajAlt=strip_tags($mesaj);

	$mesaj_nereden='Devim Tours';

	//	$headers ="From: =?UTF-8?B?".base64_encode($mesaj_nereden)."?= <". ''.ayarAl('mailAdresi').'>' . "\r\n";

	//	$header_ = 'MIME-Version: 1.0' . "\r\n" . 'Content-type: text/plain; charset=UTF-8' . "\r\n";


	/*if(mail($kime, '=?UTF-8?B?'.base64_encode($baslik).'?=', $mesaj, $header_ . $headers)){
		return true;
	}else{
	return false;
	}*/
	require "PHPMailer-master/PHPMailerAutoload.php";
	$mail2 = new PHPMailer();

	$mail2->IsSMTP(); // Mailimizin SMTP ile g�nderilece�ini belirtiyoruz
	$mail2->From     = "info@devimtours.com"; //G�nderen k�sm�nda yer alacak e-mail adresi
	//$mail2->Sender   = "info@devimtours.ba";
	//$mail2->ReplyTo  = "info@devimtours.ba";
	$mail2->addReplyTo("info@devimtours.com","Devim Tours");
	$mail2->FromName = "Devim Tours";
	$mail2->Host     = "p3plcpnl0096.prod.phx3.secureserver.net"; //SMTP server adresi
	$mail2->Port       = 465;
	$mail2->SMTPAuth = true; //SMTP server'a kullan�c� ad� ile ba�lan�lca��n� belirtiyoruz
	$mail2->SMTPSecure = "ssl";
	//$mail2->SMTPDebug  = 1;
	$mail2->Username = "info@devimtours.com"; //SMTP kullan�c� ad�
	$mail2->Password    = "WTGC2395781dfgdfg"; //SMTP �ifre
	$mail2->WordWrap = 50;
	$mail2->isHTML(true); //Mailimizin HTML format�nda haz�rlanaca��n� bildiriyoruz.
	$mail2->Subject  = $baslik; // Konu

	//Mailimizin g�vdesi: (HTML ile)
	//$body = "<b>Bu mail</b> bir deneme mailidir.<br /><br />SMTP server ile gonderilmistir.";

	// HTML okuyamayan mail okuyucularda g�r�necek d�z metin:
	//$textBody = "Bu mail bir deneme mailidir. SMTP server ile gonderilmistir.";
	//$mail->AddCustomHeader($header_);
	$mail2->Body = $mesaj;
//	$mail2->AltBody = $mesajAlt;

	$mail2->AddAddress($kime, $isim.' '.$soyisim); // Mail g�nderilecek adresleri ekliyoruz.
//	$mail2->AddCC('yusufyyilmaz@gmail.com');


	if ($mail2->Send()) {
		$gondermeDurum='1'; 
	}else {
		$gondermeDurum='0';
	}
/*
	$mail2->ClearAddresses();
	$mail2->ClearCCs();
	$mail2->ClearAttachments();
*/
	return $gondermeDurum;

}
function postaTurRezOlustuUser($isim, $soyisim, $email){


	$kimAdi=$isim.' '.$soyisim;

	$kime=$email;


	$baslik ='Devim Tours Rezervasyon Bilgileriniz';

	$mesajIcerik='Rezervasyon isteğiniz bize ulaştı. Gerekli bilgilendirme müşteri temsilcimiz tarafından size telefon ile bildirilecektir.';

	$mesaj =ePostaHTML($kimAdi, $mesajIcerik,'');


	$mesajAlt=strip_tags($mesaj);

	$mesaj_nereden='Devim Tours';

	//	$headers ="From: =?UTF-8?B?".base64_encode($mesaj_nereden)."?= <". ''.ayarAl('mailAdresi').'>' . "\r\n";

	//	$header_ = 'MIME-Version: 1.0' . "\r\n" . 'Content-type: text/plain; charset=UTF-8' . "\r\n";


	/*if(mail($kime, '=?UTF-8?B?'.base64_encode($baslik).'?=', $mesaj, $header_ . $headers)){
		return true;
	}else{
	return false;
	}*/
	require "PHPMailer-master/PHPMailerAutoload.php";
	$mail2 = new PHPMailer();

	$mail2->IsSMTP(); // Mailimizin SMTP ile g�nderilece�ini belirtiyoruz
	$mail2->From     = "info@devimtours.com"; //G�nderen k�sm�nda yer alacak e-mail adresi
	//$mail2->Sender   = "info@devimtours.ba";
	//$mail2->ReplyTo  = "info@devimtours.ba";
	$mail2->addReplyTo("info@devimtours.com","Devim Tours");
	$mail2->FromName = "Devim Tours";
	$mail2->Host     = "p3plcpnl0096.prod.phx3.secureserver.net"; //SMTP server adresi
	$mail2->Port       = 465;
	$mail2->SMTPAuth = true; //SMTP server'a kullan�c� ad� ile ba�lan�lca��n� belirtiyoruz
	$mail2->SMTPSecure = "ssl";
	//$mail2->SMTPDebug  = 1;
	$mail2->Username = "info@devimtours.com"; //SMTP kullan�c� ad�
	$mail2->Password    = "WTGC2395781dfgdfg"; //SMTP �ifre
	$mail2->WordWrap = 50;
	$mail2->isHTML(true); //Mailimizin HTML format�nda haz�rlanaca��n� bildiriyoruz.
	$mail2->Subject  = $baslik; // Konu

	//Mailimizin g�vdesi: (HTML ile)
	//$body = "<b>Bu mail</b> bir deneme mailidir.<br /><br />SMTP server ile gonderilmistir.";

	// HTML okuyamayan mail okuyucularda g�r�necek d�z metin:
	//$textBody = "Bu mail bir deneme mailidir. SMTP server ile gonderilmistir.";
	//$mail->AddCustomHeader($header_);
	$mail2->Body = $mesaj;
	//	$mail2->AltBody = $mesajAlt;

	$mail2->AddAddress($kime, $isim.' '.$soyisim); // Mail g�nderilecek adresleri ekliyoruz.
	//	$mail2->AddCC('yusufyyilmaz@gmail.com');
	$mail2->AddBCC('info@devimtours.com',"Devim Tours");

	if ($mail2->Send()) {
		$gondermeDurum='1';
	}else {
		$gondermeDurum='0';
	}
	/*
	 $mail2->ClearAddresses();
	$mail2->ClearCCs();
	$mail2->ClearAttachments();
	*/
	return $gondermeDurum;

}
function contactFormDoneEmail($isim, $soyisim, $email){


	$kimAdi=$isim.' '.$soyisim;

	$kime=$email;


	$baslik ='Iletisim';

	$mesajIcerik='İsteğiniz bize ulaşmıştır. En kısa zamanda tarafınıza dönüş yapılacaktır.';

	$mesaj =ePostaHTML($kimAdi, $mesajIcerik,'');


	$mesajAlt=strip_tags($mesaj);

	$mesaj_nereden='Devim Tours';

	//	$headers ="From: =?UTF-8?B?".base64_encode($mesaj_nereden)."?= <". ''.ayarAl('mailAdresi').'>' . "\r\n";

	//	$header_ = 'MIME-Version: 1.0' . "\r\n" . 'Content-type: text/plain; charset=UTF-8' . "\r\n";


	/*if(mail($kime, '=?UTF-8?B?'.base64_encode($baslik).'?=', $mesaj, $header_ . $headers)){
		return true;
	}else{
	return false;
	}*/
	require "PHPMailer-master/PHPMailerAutoload.php";
	$mail2 = new PHPMailer();

	$mail2->IsSMTP(); // Mailimizin SMTP ile g�nderilece�ini belirtiyoruz
	$mail2->From     = "info@devimtours.com"; //G�nderen k�sm�nda yer alacak e-mail adresi
	//$mail2->Sender   = "info@devimtours.ba";
	//$mail2->ReplyTo  = "info@devimtours.ba";
	$mail2->addReplyTo("info@devimtours.com","Devim Tours");
	$mail2->FromName = "Devim Tours";
	$mail2->Host     = "p3plcpnl0096.prod.phx3.secureserver.net"; //SMTP server adresi
	$mail2->Port       = 465;
	$mail2->SMTPAuth = true; //SMTP server'a kullan�c� ad� ile ba�lan�lca��n� belirtiyoruz
	$mail2->SMTPSecure = "ssl";
	//$mail2->SMTPDebug  = 1;
	$mail2->Username = "info@devimtours.com"; //SMTP kullan�c� ad�
	$mail2->Password    = "WTGC2395781dfgdfg"; //SMTP �ifre
	$mail2->WordWrap = 50;
	$mail2->isHTML(true); //Mailimizin HTML format�nda haz�rlanaca��n� bildiriyoruz.
	$mail2->Subject  = $baslik; // Konu

	//Mailimizin g�vdesi: (HTML ile)
	//$body = "<b>Bu mail</b> bir deneme mailidir.<br /><br />SMTP server ile gonderilmistir.";

	// HTML okuyamayan mail okuyucularda g�r�necek d�z metin:
	//$textBody = "Bu mail bir deneme mailidir. SMTP server ile gonderilmistir.";
	//$mail->AddCustomHeader($header_);
	$mail2->Body = $mesaj;
	//	$mail2->AltBody = $mesajAlt;

	$mail2->AddAddress($kime, $isim.' '.$soyisim); // Mail g�nderilecek adresleri ekliyoruz.
	//	$mail2->AddCC('yusufyyilmaz@gmail.com');
	$mail2->AddBCC('info@devimtours.com',"Devim Tours");

	if ($mail2->Send()) {
		$gondermeDurum='1';
	}else {
		$gondermeDurum='0';
	}
	/*
	 $mail2->ClearAddresses();
	$mail2->ClearCCs();
	$mail2->ClearAttachments();
	*/
	return $gondermeDurum;

}
function ePostaHTML($kisiBilgi,$ePostaMetin,$ekNot='',$link=''){
	
	
	$unvanliKisi='<p>Sayın '.$kisiBilgi.',</p>';
	$ePostaMetin='<p>'.$ePostaMetin.'</p>' ;	
	
	if ($ekNot!=''){
	$ekNot='<tr>
													      <td>
													      	<table width="500" align="center" bgcolor="D3EEF1">
													      		<tr>
													      			<td>&nbsp;</td>
													      		</tr>
													      		<tr>
													      			<td>
																        <div style="font-family: \'Lucida Grande\',sans-serif; font-size: 13px; font-weight: normal; color: #333333;">
																        <p>
																             '.$ekNot.'
																          </p>
																        </div>
																     </td>
																</tr>
																<tr>
													      			<td>&nbsp;</td>
													      		</tr>
													        </table>
													      </td>
													    </tr>
													    <tr>
													      			<td>&nbsp;</td>
													    </tr>';
	}
	if ($link!=''){
		
		$link='<tr>
													      <td>
																        <div style="width: 548px; font-family: \'Lucida Grande\',sans-serif; font-size: 13px; font-weight: normal; color: #333333;">
																        <p>
																            <a href="'.$link.'">'.$link.'</a>
																          </p>
																        </div>
													      </td>
													    </tr>';
		
	}
$postaHTML=
'<html>
<head>
   <meta content="text/html; charset=utf-8" http-equiv="Content-Type">
</head>
<body>
  <br>
  <table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tbody>
      <tr>
        <td align="center">
          <table style="background-color: rgb(229, 229, 229); border: 1px solid rgb(204, 204, 204);" border="0" cellpadding="0" cellspacing="25" width="580">
            <tbody>
              <tr>
                <td>
                  <table border="0" cellpadding="0" cellspacing="0" width="580">
                    <tbody>
                      <tr>
                        <td style="height: 68px;" align="left" valign="bottom">
                          <img src="'.siteAdi().'img/email/header.jpg" height="76" width="580">
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <table border="0" cellpadding="0" cellspacing="0" width="556">
                            <tbody>
                              <tr>
                                <td>
                                  <table border="0" cellpadding="0" cellspacing="0" width="556">
                                    <tbody>
                                      <tr>
                                        <td>
                                          <table style="background-color: rgb(255, 255, 255);" border="0" cellpadding="0" cellspacing="16" height="130" width="580">
                                            <tbody>
                                              <tr>
                                                <td style="font-size: 16px; color: #333; font-family: \'Helvetica\',sans-serif;" align="left" valign="top" width="580">
													  <table style="background-color: rgb(255, 255, 255);line-height:16px" border="0" cellpadding="0" cellspacing="0" height="130" width="548">
													    <tr>
													      <td>
													        <div style="width: 548px; font-family: \'Lucida Grande\',sans-serif; font-size: 13px; font-weight: normal; color: #333333;">
													          '.$unvanliKisi.'
													          '.$ePostaMetin.'         
													        </div>
													      </td>
													    </tr>
													    '.$ekNot.'
													    '.$link.'
													    <tr>
													      <td>
													        <div style="width: 548px; font-family: \'Lucida Grande\',sans-serif; font-size: 13px; font-weight: normal; color: #333333;">
													        <p>
													            Bilgilerinize sunarız.
													          </p>
													        </div>
													      </td>
													    </tr>
													    <tr>
													      <td>
													        <div style="width: 548px; font-family: \'Lucida Grande\',sans-serif; font-size: 13px; font-weight: normal; color: #333333;">
													      	<p>
													             Devim Tours
													          </p>
													        </div>
													      </td>
													    </tr>
													  </table>
                                                </td>
                                              </tr>
                                            </tbody>
                                          </table>
                                        </td>
                                      </tr>
                                      <tr>
                                        <td>
                                          <table border="0" cellpadding="0" cellspacing="0" width="580">
                                            <tbody>
                                              <tr>
                                                <td>
                                                  <img src="'.siteAdi().'img/email/footer.jpg" alt="" height="31" width="580">
                                                </td>
                                              </tr>
                                              <tr>
                                                <td>
                                                  <p style="margin-left: 7px; font-size: 12px; margin-top: 4px; color: rgb(136, 136, 136); text-align:center;">
                                                    Devim Tours
                                                    <br>
                                                    <a style="color:#777777" href="'.siteAdi().'"><img src="'.siteAdi().'img/email/w.png" alt="Web Sitesi" title="Web Sitesi"/></a>
                                                    <a style="color:#777777" href="callto:'.ayarAl('telNo').'"><img src="'.siteAdi().'img/email/p.png" alt="Telefon" title="Telefon"/></a>
                                                    <a style="color:#777777" href="mailto:'.ayarAl('mailAdresi').'"><img src="'.siteAdi().'img/email/e.png" alt="e-Posta" title="e-Posta"/></a>
                                                    <a style="color:#777777" href="'.ayarAl('facebook').'"><img src="'.siteAdi().'img/email/f.png" alt="Facebook" title="Facebook"/></a>
                                                    <a style="color:#777777" href="'.ayarAl('twitter').'"><img src="'.siteAdi().'img/email/t.png" alt="Twitter" title="Twitter"/></a>
                                                    <a style="color:#777777" href="'.ayarAl('youtube').'"><img src="'.siteAdi().'img/email/y.png" alt="Youtube" title="Youtube"/></a>
                                                    <a style="color:#777777" href="'.ayarAl('linkedin').'"><img src="'.siteAdi().'img/email/v.png" alt="Vimeo" title="Vimeo"/></a>
                                                  </p>
                                                </td>
                                              </tr>
                                            </tbody>
                                          </table>
                                        </td>
                                      </tr>
                                    </tbody>
                                  </table>
                                </td>
                              </tr>
                            </tbody>
                          </table>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </td>
              </tr>
            </tbody>
          </table>
        </td>
      </tr>
    </tbody>
  </table>
</body>
</html>';

return $postaHTML;
}
function alphaID($in, $to_num = false, $pad_up = false, $pass_key = null)
{
	$out   =   '';
	$index = 'abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$base  = strlen($index);

	if ($pass_key !== null) {
		// Although this function's purpose is to just make the
		// ID short - and not so much secure,
		// with this patch by Simon Franz (http://blog.snaky.org/)
		// you can optionally supply a password to make it harder
		// to calculate the corresponding numeric ID

		for ($n = 0; $n < strlen($index); $n++) {
			$i[] = substr($index, $n, 1);
		}

		$pass_hash = hash('sha256',$pass_key);
		$pass_hash = (strlen($pass_hash) < strlen($index) ? hash('sha512', $pass_key) : $pass_hash);

		for ($n = 0; $n < strlen($index); $n++) {
			$p[] =  substr($pass_hash, $n, 1);
		}

		array_multisort($p, SORT_DESC, $i);
		$index = implode($i);
	}

	if ($to_num) {
		// Digital number  <<--  alphabet letter code
		$len = strlen($in) - 1;

		for ($t = $len; $t >= 0; $t--) {
			$bcp = bcpow($base, $len - $t);
			$out = $out + strpos($index, substr($in, $t, 1)) * $bcp;
		}

		if (is_numeric($pad_up)) {
			$pad_up--;

			if ($pad_up > 0) {
				$out -= pow($base, $pad_up);
			}
		}
	} else {
		// Digital number  -->>  alphabet letter code
		if (is_numeric($pad_up)) {
			$pad_up--;

			if ($pad_up > 0) {
				$in += pow($base, $pad_up);
			}
		}

		for ($t = ($in != 0 ? floor(log($in, $base)) : 0); $t >= 0; $t--) {
			$bcp = bcpow($base, $t);
			$a   = floor($in / $bcp) % $base;
			$out = $out . substr($index, $a, 1);
			$in  = $in - ($a * $bcp);
		}
	}

	return $out;
}

function linkVerTur($turId){
	
	$turBilgileri=mysql_fetch_assoc(sec("turlar","*","id='".$turId."' "));
	return siteAdi().'tur/'.$turBilgileri['turDost'].'-'.$turBilgileri['id'];
}

?>