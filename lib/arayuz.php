<?php
 
 function vitrinUrunler($kategori='hepsi'){
 	
 	if ($kategori=='hepsi'){
 		$katSql='';
 	}else{
 		$katSql=' AND anaKategori='.$kategori;
 	}
 	
 	$vitrinUrunler_=sec("turlar","*","aktif='1' AND vitrinGoster='1' ".$katSql.' ORDER BY gidisTarihi ASC');

 ?>
 	<div class="tour-list">
 <?php 
 	while ($vitrinUrun=mysql_fetch_assoc($vitrinUrunler_)){
 		?>
					<a href="<?php echo siteAdi().'tur/'.$vitrinUrun['turDost'].'-'.$vitrinUrun['id']?>">
						<div class="tour-item">
							<div class="tour-title"><?php echo $vitrinUrun['turAdi']?></div>
							<div class="tour-image"><img src="<?php echo siteAdi().$vitrinUrun['vitrinResimYol']; ?>" width="112" height="133" /></div>
							<div class="tour-content">
								<div><?php if($vitrinUrun['sadeceGoster']!=1){echo tarih_turkce_tur($vitrinUrun['gidisTarihi'], $vitrinUrun['donusTarihi']);}?>
								</div>
								<div>
								<?php if($vitrinUrun['sadeceGoster']!=1){
										$tarihFarki=mysql_fetch_assoc(mysql_query("SELECT DATEDIFF(donusTarihi,gidisTarihi) as fark FROM turlar WHERE id=".$vitrinUrun['id']));
										$ustGun=$tarihFarki['fark']+1;
										echo $ustGun.' gün, '.$tarihFarki['fark'].' gece' ;}?>
								</div>
								<div><?php echo $vitrinUrun['pansiyonTipi'] ?></div>
								<?php 
									if ($vitrinUrun['ulkeSehirSayisi']!=''){
										echo '<div>'.$vitrinUrun['ulkeSehirSayisi'].'</div>';
									}
								
									?>
								<div class="tour-fee"><?php if($vitrinUrun['sadeceGoster']!=1){echo $vitrinUrun['ucret'].$vitrinUrun['paraBirim'];}?></div>
								<div class="tour-airline"><img src="<?php $anaKatName=mysql_fetch_assoc(sec('havayollari',"*","id=".$vitrinUrun['havayoluId'])); echo siteAdi().$anaKatName['logo']; ?>" /></div>
							</div>
						</div>
					</a> 		
 		<?php 
 	} 	
 	?>
 	</div> 
	<div class="clearer"></div>
 	<?php 
 }
 
 
 function mainNav(){
 	
 	$mainMenu_=sec("menu","*","menutype='mainNav' AND parent=0 AND published=1");
 	
 	?>
			<div class="mainnav">
				<ul id="cssdropdown">
					<?php 
					
						while ($mainMenu=mysql_fetch_assoc($mainMenu_)){
							
							echo '<li class="'.$mainMenu['cssClass'].' headlink"><a href="'.linkVer($mainMenu['id']).'">'.$mainMenu['name'.langSql()].'</a>';
							if (altMenuVarMi($mainMenu['id'])){
								
								$subMenu_=sec("menu","*","menutype='mainNav' AND parent='".$mainMenu['id']."' AND published=1");
								echo '<ul class="mainnav-sub">';
								while ($subMenu=mysql_fetch_assoc($subMenu_)){
									echo '<li><a href="'.linkVer($subMenu['id']).'">'.$subMenu['name'.langSql()].'</a></li>';
								}
								echo '</ul>';
								
							}else{
								echo '</li>';
							}
							
						}
					
					?>
				</ul>		
			</div> 	
 			<script>
				$(document).ready(function(){
					$('#cssdropdown li.headlink').hover(
						function() { $('ul', this).css('display', 'block'); },
						function() { $('ul', this).css('display', 'none'); });
				});
			</script>
 	
 	<?php 
}
 
 function balkanTuruPlanlar(){
 	
 	if (isset($_GET['cinCity'])){
	 	$cinCity=$_GET['cinCity'];
	 	$coutCity=$_GET['coutCity'];
 	}
 	?>
				<div class="quick-search-container">
					<div class="quick-search-title"><?php echo langTrans('balkanturuplanla');?></div>
					<div>
						<form name="tour-planner" id="tour-planner" action="Tur-Planla" target="">
							<select name="cinCity" class="tour-planner-select">
								<option value="0"><?php echo langTrans('girisYeri');?></option>
								<?php 
								$girisCikisSehirleri_=sec("turolustursehirler","*","girisCikisMi=1 AND aktif=1");
								while ($sehir=mysql_fetch_assoc($girisCikisSehirleri_)){
									if ($sehir['id']==$cinCity){
										$selectedHtml='selected="selected"';
									}else{
										$selectedHtml='';
									}
									?><option value="<?php echo $sehir['id'] ?>" <?php echo $selectedHtml?>><?php echo $sehir['adi'] ?></option><?php 
								}
								?>
							</select> 
							<br />
							<select name="coutCity"class="tour-planner-select">
								<option value="0"><?php echo langTrans('cikisYeri'); ?></option>
								<?php 
								$girisCikisSehirleri_=sec("turolustursehirler","*","girisCikisMi=1 AND aktif=1");
								while ($sehir=mysql_fetch_assoc($girisCikisSehirleri_)){
									if ($sehir['id']==$coutCity){
										$selectedHtml='selected="selected"';
									}else{
										$selectedHtml='';
									}
									?><option value="<?php echo $sehir['id'] ?>" <?php echo $selectedHtml?>><?php echo $sehir['adi'] ?></option><?php 
								}
								?>
							</select>
							<input type="submit" value="<?php echo langTrans('planla'); ?>" class="tour-planner-submit"/>
						</form>
					</div>
				</div> 	
 	
 	<?php 
 }
 
 function sehirAdi($sehirId){
 	$sehirAdi=mysql_fetch_assoc(sec("turolustursehirler","*","id=".$sehirId));
 	return $sehirAdi['adi'];
 }
 
 
 function ayarAl($ayarAnahtari){
 	
 	$siteAdi=mysql_fetch_assoc(sec("settings","*","settingName='".$ayarAnahtari."'"));
 	//echo mysql_error();
 	return $siteAdi['value'];
 	
 }

function printHead($title='Devim Tours',$bannerSite='false', $css='',$script=''){
	
/*	$istenenSayfaId=$GLOBALS['istenenSayfaAlias'];
	
	$sayfaOzellikler=mysql_fetch_assoc(sec('menu','*',"alias='".$istenenSayfaId."'"));
	$sayfaId=$sayfaOzellikler['id'];
	
	*/
	
	$googleCode="";
	
	if ($GLOBALS['istenenSayfaAlias']==''){
		$metalar['metaTanim']='Yenilenen yüzü ile Devim Tours size her konuda yarmıcı olabilir';
		$metalar['metaKelime']='Devim Tours, Balkan, Gezmek, Kaliteli Tatil';
		$metalar['metaTanim_en']='Devim Tours can help you in all matters.';
		$metalar['metaKelime_en']='Devim Tours, Excursion, Quality Vacation';
		$metalar['metaTanim_ba']='Devim Tours Vam nudi najnolje i najkvalitetnije usluge za odmor.';
		$metalar['metaKelime_ba']='Devim Tours, Balkan, Ekskurzije, Kavaliteni Odmor';
		$metalar['alias']='';
		$metalar['alias_en']='';
		$metalar['alias_ba']='';
	}else{
		$metalar=mysql_fetch_assoc(sec("menu","*","alias".langSql()."='".$GLOBALS['istenenSayfaAlias']."'"));
	}
	
	if (langSql()==''){
		$langHtml='tr';
	}else{
		$langHtml=substr(langSql(), 1);
	}
	
	if ($langHtml=='tr'){
		$secondLang='en';
		$thirdLang='ba';
		$secondLangAlias='_en';
		$thirdLangAlias='_ba';
	}elseif ($langHtml=='en'){
		$secondLang='tr';
		$thirdLang='ba';
		$secondLangAlias='';
		$thirdLangAlias='_ba';
	}elseif ($langHtml=='ba'){
		$secondLang='en';
		$thirdLang='tr';
		$secondLangAlias='_en';
		$thirdLangAlias='';
	}
	
	?>
<!DOCTYPE html>
<html lang="<?php echo $langHtml; ?>">
<head>
	<meta charset="utf-8" />
	<!--[if lt IE 9]><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
	<title><?php echo $title?></title>
	<meta name="description" content="<?php echo $metalar['metaTanim'.langSql()];?>" />
	<meta name="keywords" content="<?php echo $metalar['metaKelime'.langSql()];?>" />
	<link href="<?php echo siteAdi(); ?>css/style.css" rel="stylesheet">

	<link rel="stylesheet" href="<?php echo siteAdi(); ?>css/jquery-ui-1.10.4.custom.min.css">
	<link rel="stylesheet" href="<?php echo siteAdi(); ?>css/colorbox.css">
		
	<script type="text/javascript" src="<?php echo siteAdi(); ?>js/jquery-1.10.2.min.js"></script>
	<script type="text/javascript" src="<?php echo siteAdi(); ?>js/jssor.slider.mini.js"></script>
	<script src="<?php echo siteAdi(); ?>js/jquery-ui-1.10.3.custom.min.js"></script>
	<script type="text/javascript" src="<?php echo siteAdi(); ?>js/jquery.colorbox-min.js"></script>
	<script type="text/javascript" src="<?php echo siteAdi(); ?>js/jquery.zweatherfeed.min.js"></script>
	<script>
	  $(function() {
		    $( "#tabs" ).tabs();
		    var tabId = window.location.hash; // will look something like "#h-02"
		    $(tabId).click();
		    $(".sarajevo-citymap").colorbox({transition:"none", maxHeight: '90%', maxWidth: '90%'});
		    $(".mostar-citymap").colorbox({transition:"none", maxHeight: '90%', maxWidth: '90%'});
		    $(".travnik-citymap").colorbox({transition:"none", maxHeight: '90%', maxWidth: '90%'});
		    $('body').hide().show();
		  });
			$(document).ready(function () {
			  $('#weather-forecast').weatherfeed(['BKXX0004', 'BKXX0006', 'GRXX0033', 'GRXX0040', 'GRXX0042']);
			});
	</script>
	<link rel="shortcut icon" href="<?php echo siteAdi(); ?>img/favicon.ico" type="image/x-icon">
	<link rel="icon" href="<?php echo siteAdi(); ?>img/favicon.ico" type="image/x-icon">
	<link rel="alternate" hreflang="<?php echo $secondLang;?>" href="<?php echo siteAdi().$metalar['alias'.$secondLangAlias].'?lang='.$secondLang ?>" />
	<link rel="alternate" hreflang="<?php echo $thirdLang;?>" href="<?php echo siteAdi().$metalar['alias'.$thirdLangAlias].'?lang='.$thirdLang ?>" />
</head>

<body>
<div id="fb-root"></div>
	<script>(function(d, s, id) {
	  var js, fjs = d.getElementsByTagName(s)[0];
	  if (d.getElementById(id)) return;
	  js = d.createElement(s); js.id = id;
	  js.src = "//connect.facebook.net/en_GB/all.js#xfbml=1";
	  fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));</script>
<?php
/*
$GLOBALS['mikTime']= microtime(true);
//Your Script Content here


$GLOBALS['endTime']  = microtime(true);
$time = number_format(($GLOBALS['endTime'] - $GLOBALS['mikTime']), 2);

echo 'This page loaded in ', $time, ' seconds';
*/
?>
<div class="wrapper">

	<header class="header">
		<div class="lang">
			<ul>
			<?php 
			?>
				<li class="bornian"><a href="<?php echo siteAdi().aliasLangMenu($GLOBALS['sayfa'], '_ba', $GLOBALS['L']); ?>?lang=ba&<?php echo $GLOBALS['GETDegiskenler'];?>"><img src="<?php echo siteAdi(); ?>img/bosnian.png"/></a></li>
				<li class="english"><a href="<?php echo siteAdi().aliasLangMenu($GLOBALS['sayfa'], '_en', $GLOBALS['L']);; ?>?lang=en&<?php echo $GLOBALS['GETDegiskenler'];?>"><img src="<?php echo siteAdi(); ?>img/english.png"/></a></li>
				<li class="turkish"><a href="<?php echo siteAdi().aliasLangMenu($GLOBALS['sayfa'], '', $GLOBALS['L']);; ?>?lang=tr&<?php echo $GLOBALS['GETDegiskenler'];?>"><img src="<?php echo siteAdi(); ?>img/turkish.png"/></a></li>
			</ul>
		</div>
		<div class="top">
			<div class="firstHeader">
				<div class="logo">
					<a href="<?php echo siteAdi(); ?>"><img src="<?php echo siteAdi(); ?>img/devim-tours-logo.png" /></a>
				</div>
				<div class="two-rows"> 
					<div class="phone-number"><?php echo langTrans('telNo');?></div>
					<div class="top-menu">
						<ul>
							<?php 
								$balonMenu_=sec("menu","*","menutype='balonMenu' AND parent=0 AND published=1");
								while ($balonMenu=mysql_fetch_assoc($balonMenu_)){
							?>
							<li><a href="<?php echo siteAdi().$balonMenu['alias'.langSql()]; ?>"><?php echo $balonMenu['name'.langSql()]; ?></a></li>
							<?php }?>
						</ul>
					</div>
					<div class="slogan"><?php echo langTrans('slogan');?></div>
					<div class="text-nav">
						<ul>
							<?php 
								$balonMenu_=sec("menu","*","menutype='textMenu' AND parent=0 AND published=1");
								while ($balonMenu=mysql_fetch_assoc($balonMenu_)){
							?>
							<li><a href="<?php echo siteAdi().$balonMenu['alias'.langSql()]; ?>"><?php echo $balonMenu['name'.langSql()]; ?></a></li>
							<?php }?>
						</ul>
					</div>				
				</div>
				<div class="clearer"></div>
				<?php 
				if ($bannerSite=='true'){
					
				balkanTuruPlanlar() ?>
				<div class="bannerrotator">
				        <script>
					        jQuery(document).ready(function ($) {
					            //Reference http://www.jssor.com/developement/slider-with-slideshow.html
					            //Reference http://www.jssor.com/developement/tool-slideshow-transition-viewer.html
					
					            var _SlideshowTransitions = [
					            //Fade in R
					            {$Duration: 1200, $During: { $Left: [0.3, 0.7] }, $FlyDirection: 2, $Easing: { $Left: $JssorEasing$.$EaseInCubic, $Opacity: $JssorEasing$.$EaseLinear }, $ScaleHorizontal: 0.3, $Opacity: 2 }
					            //Fade out L
					            , { $Duration: 1200, $SlideOut: true, $FlyDirection: 1, $Easing: { $Left: $JssorEasing$.$EaseInCubic, $Opacity: $JssorEasing$.$EaseLinear }, $ScaleHorizontal: 0.3, $Opacity: 2 }
					            ];
					
					            var options = {
					                $AutoPlay: true,                                    //[Optional] Whether to auto play, to enable slideshow, this option must be set to true, default value is false
					                $AutoPlaySteps: 1,                                  //[Optional] Steps to go for each navigation request (this options applys only when slideshow disabled), the default value is 1
					                $AutoPlayInterval: 4000,                            //[Optional] Interval (in milliseconds) to go for next slide since the previous stopped if the slider is auto playing, default value is 3000
					                $PauseOnHover: 0,                               //[Optional] Whether to pause when mouse over if a slider is auto playing, 0 no pause, 1 pause for desktop, 2 pause for touch device, 3 pause for desktop and touch device, default value is 3
					
					                $ArrowKeyNavigation: true,   			            //[Optional] Allows keyboard (arrow key) navigation or not, default value is false
					                $SlideDuration: 500,                                //[Optional] Specifies default duration (swipe) for slide in milliseconds, default value is 500
					                $MinDragOffsetToSlide: 20,                          //[Optional] Minimum drag offset to trigger slide , default value is 20
					                //$SlideWidth: 600,                                 //[Optional] Width of every slide in pixels, default value is width of 'slides' container
					                //$SlideHeight: 300,                                //[Optional] Height of every slide in pixels, default value is height of 'slides' container
					                $SlideSpacing: 0, 					                //[Optional] Space between each slide in pixels, default value is 0
					                $DisplayPieces: 1,                                  //[Optional] Number of pieces to display (the slideshow would be disabled if the value is set to greater than 1), the default value is 1
					                $ParkingPosition: 0,                                //[Optional] The offset position to park slide (this options applys only when slideshow disabled), default value is 0.
					                $UISearchMode: 1,                                   //[Optional] The way (0 parellel, 1 recursive, default value is 1) to search UI components (slides container, loading screen, navigator container, direction navigator container, thumbnail navigator container etc).
					                $PlayOrientation: 1,                                //[Optional] Orientation to play slide (for auto play, navigation), 1 horizental, 2 vertical, default value is 1
					                $DragOrientation: 3,                                //[Optional] Orientation to drag slide, 0 no drag, 1 horizental, 2 vertical, 3 either, default value is 1 (Note that the $DragOrientation should be the same as $PlayOrientation when $DisplayPieces is greater than 1, or parking position is not 0)
					
					                $SlideshowOptions: {                                //[Optional] Options to specify and enable slideshow or not
					                    $Class: $JssorSlideshowRunner$,                 //[Required] Class to create instance of slideshow
					                    $Transitions: _SlideshowTransitions,            //[Required] An array of slideshow transitions to play slideshow
					                    $TransitionsOrder: 1,                           //[Optional] The way to choose transition to play slide, 1 Sequence, 0 Random
					                    $ShowLink: true                                    //[Optional] Whether to bring slide link on top of the slider when slideshow is running, default value is false
					                },
					
					                $NavigatorOptions: {                                //[Optional] Options to specify and enable navigator or not
					                    $Class: $JssorNavigator$,                       //[Required] Class to create navigator instance
					                    $ChanceToShow: 2,                               //[Required] 0 Never, 1 Mouse Over, 2 Always
					                    $Lanes: 1,                                      //[Optional] Specify lanes to arrange items, default value is 1
					                    $SpacingX: 10,                                   //[Optional] Horizontal space between each item in pixel, default value is 0
					                    $SpacingY: 10                                    //[Optional] Vertical space between each item in pixel, default value is 0
					                },
					
					                $DirectionNavigatorOptions: {
					                    $Class: $JssorDirectionNavigator$,              //[Requried] Class to create direction navigator instance
					                    $ChanceToShow: 2                                //[Required] 0 Never, 1 Mouse Over, 2 Always
					                },
					
					                $ThumbnailNavigatorOptions: {
					                    $Class: $JssorThumbnailNavigator$,              //[Required] Class to create thumbnail navigator instance
					                    $ChanceToShow: 2,                               //[Required] 0 Never, 1 Mouse Over, 2 Always
					                    $ActionMode: 0,                                 //[Optional] 0 None, 1 act by click, 2 act by mouse hover, 3 both, default value is 1
					                    $DisableDrag: true                              //[Optional] Disable drag or not, default value is false
					                }
					            };
					
					            var jssor_sliderb = new $JssorSlider$("sliderb_container", options);
					            //responsive code begin
					            //you can remove responsive code if you don't want the slider scales while window resizes
					            function ScaleSlider() {
					                var parentWidth = jssor_sliderb.$Elmt.parentNode.clientWidth;
					                if (parentWidth)
					                    jssor_sliderb.$SetScaleWidth(Math.min(parentWidth, 658));
					                else
					                    window.setTimeout(ScaleSlider, 30);
					            }
					
					            ScaleSlider();
					
					            if (!navigator.userAgent.match(/(iPhone|iPod|iPad|BlackBerry|IEMobile)/)) {
					                $(window).bind('resize', ScaleSlider);
					            }
					            //responsive code end
					        });
					    </script>
					    <!-- Jssor Slider Begin -->
					    <!-- You can move inline styles (except 'top', 'left', 'width' and 'height') to css file or css block. -->
					    <div id="sliderb_container" style="position: relative; width: 658px; height: 232px;">
					
					        <!-- Loading Screen -->
					        <div u="loading" style="position: absolute; top: 0px; left: 0px;">
					            <div style="filter: alpha(opacity=70); opacity:0.7; position: absolute; display: block;
					                background-color: #000; top: 0px; left: 0px;width: 100%;height:100%;">
					            </div>
					            <div style="position: absolute; display: block; background: url(<?php echo siteAdi();?>img/loading.gif) no-repeat center center;
					                top: 0px; left: 0px;width: 100%;height:100%;">
					            </div>
					        </div>
					
					        <!-- Slides Container -->
					        <div u="slides" style="cursor: move; position: absolute; right: 0px; bottom: 0px; width: 658px; height: 232px;
					            overflow: hidden;">
					            <?php 
					            
					            	$bannerUrunler_=sec("turlar","*","aktif='1' AND bannerGoster='1' ORDER BY gidisTarihi ASC");
					            	
					            	while ($bannerUrunler=mysql_fetch_assoc($bannerUrunler_)){
					            ?>					            
					            <div>
					                <img u=image src="<?php echo siteAdi().$bannerUrunler['bannerResimYol']; ?>" />
					                <div u="thumb"><?php echo $bannerUrunler['turAdi'];?> <br />  <strong><?php echo $bannerUrunler['ucret'].$bannerUrunler['paraBirim'];?></strong></div>
					            </div>
					            <?php }?>
					        </div>
					
					        <!-- ThumbnailNavigator Skin Begin -->
					        <div u="thumbnavigator" class="sliderb-T" style="position: absolute; top: 0px; right: 0px; height:232px; width:255px; background: url(img/sliderBack.png);">
					            <div style="position: absolute; display: block;
					                background: url(img/sliderBack.png); top: 0px; right: 0px; width: 100%; height: 100%;">
					            </div>
					            <!-- Thumbnail Item Skin Begin -->
					            <div u="slides" style="margin-top:80px;">
					                <div u="prototype" style="POSITION: absolute; WIDTH: 200px; HEIGHT: 100px; ">
					                    <thumbnailtemplate style="font-family: verdana; font-weight: normal; POSITION: absolute; WIDTH: 100%; HEIGHT: 100%; TOP: 0; LEFT: 0; color:#fff; line-height: 25px; font-size:16px; padding-left:10px;"></thumbnailtemplate>
					                </div>
					            </div>
					            <!-- Thumbnail Item Skin End -->
					        </div>
					        <!-- ThumbnailNavigator Skin End -->
					        
					        <!-- Navigator Skin Begin -->
					        <!-- jssor slider navigator skin 01 -->
					        <style>
					            /*
					            .jssorn01 div           (normal)
					            .jssorn01 div:hover     (normal mouseover)
					            .jssorn01 .av           (active)
					            .jssorn01 .av:hover     (active mouseover)
					            .jssorn01 .dn           (mousedown)
					            */
					            .jssorn01 div, .jssorn01 div:hover, .jssorn01 .av
					            {
					                overflow:hidden;
					                cursor: pointer;
					            }
					            .jssorn01 div { background-color: white; }
					            .jssorn01 div:hover, .jssorn01 .av:hover { background-color: #d3d3d3; }
					            .jssorn01 .av { background-color: #fff; }
					            .jssorn01 .dn, .jssorn01 .dn:hover { background-color: #555555; }
					        </style>
					        <!-- navigator container -->
					        <div u="navigator" class="jssorn01" style="position: absolute; top: 10px; right: 10px;">
					            <!-- navigator item prototype -->
					            <div u="prototype" style="POSITION: absolute; WIDTH: 12px; HEIGHT: 12px;"></div>
					        </div>
					        <!-- Navigator Skin End -->
					        
					        <!-- Direction Navigator Skin Begin -->
					        <style>
					            /* jssor slider direction navigator skin 05 css */
					            /*
					            .jssord05l              (normal)
					            .jssord05r              (normal)
					            .jssord05l:hover        (normal mouseover)
					            .jssord05r:hover        (normal mouseover)
					            .jssord05ldn            (mousedown)
					            .jssord05rdn            (mousedown)
					            */
					            .jssord05l, .jssord05r, .jssord05ldn, .jssord05rdn
					            {
					            	position: absolute;
					            	cursor: pointer;
					            	display: block;
					                background: url(img/d17.png) no-repeat;
					                overflow:hidden;
					            }
					            .jssord05l { background-position: -10px -40px; }
					            .jssord05r { background-position: -70px -40px; }
					            .jssord05l:hover { background-position: -130px -40px; }
					            .jssord05r:hover { background-position: -190px -40px; }
					            .jssord05ldn { background-position: -250px -40px; }
					            .jssord05rdn { background-position: -310px -40px; }
					        </style>
					        <!-- Arrow Left -->
					        <span u="arrowleft" class="jssord05l" style="width: 40px; height: 40px; top: 90px; left: 8px;">
					        </span>
					        <!-- Arrow Right -->
					        <span u="arrowright" class="jssord05r" style="width: 40px; height: 40px; top: 90px; right: 8px">
					        </span>
					        <!-- Direction Navigator Skin End -->
					        
					        <!-- Trigger -->
					    </div>
					    <!-- Jssor Slider End -->
				</div>
				<?php } ?>
			</div>
			<div class="clearer"></div>
			<?php  mainNav();?>
		</div>
	</header>	
	<div class="middle">
		<div class="container">
			<main class="content">	
	<?php 
}

function printLeftAside(){
	?>
			</main><!-- .content -->
		</div>

		<aside class="left-sidebar">
		
			<a href="<?php echo siteAdi()?>Balkanlar-Turlarlari"><img src="<?php echo siteAdi()?>img/<?php echo langTrans('enUygunFiyatlarlaBalkanTurlari_Img');?>" alt="<?php echo langTrans('enUygunFiyatlarlaBalkanTurlari');?>"/></a>
			<a href="<?php echo siteAdi()?>Yunan-Adalari-Turlarimiz"><img style="margin-top:10px;" src="<?php echo siteAdi()?>img/<?php echo langTrans('yunanFirsatlar_Img');?>" alt="<?php echo langTrans('yunanFirsatlar');?>"/></a>
			
			<div class="email-subscribe">
				<div class="email-subscribe-title"><?php echo langTrans('ebulten')?></div>
				<div class="email-subscribe-info"><?php echo langTrans('kampyaHaberdarOlun')?></div>
				<div class="email-subscribe-form">
					<form method="post" action="e-Posta-Liste-Kaydi">
						<input type="text" name="email" placeholder="<?php echo langTrans('epostaniz')?>" class="email-subscribe-input"/>
						<input type="submit" value="<?php echo langTrans('gonder')?>"  class="email-subscribe-submit"/>
					</form>
				</div>
			</div>
			<div>
				<a href="<?php echo siteAdi()?>files/Devim-Tours-Katalog.pdf" target="_blank"><img  style="margin-top:10px;" src="<?php echo siteAdi()?>img/<?php echo langTrans('balkanKatalog_Img')?>" alt="<?php echo langTrans('balkanKatalog')?>"/></a>
			</div>			
			<div class="twitter-feed">
				<a class="twitter-timeline" href="https://twitter.com/DevimTours" data-widget-id="426670431450316800"  lang="TR">Tweets by @DevimTours</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
			</div>
			<div class="social-buttons">
				<div class="facebook">
					<a href="<?php echo ayarAl('facebook')?>" target="_blank"><img src="<?php echo siteAdi()?>img/facebook.png" alt="Facebook"/></a>
					<a href="<?php echo ayarAl('twitter')?>" target="_blank"><img src="<?php echo siteAdi()?>img/twitter.png" alt="Twitter"/></a>
					<a href="<?php echo ayarAl('linkedin')?>" target="_blank"><img src="<?php echo siteAdi()?>img/linkedin.png" alt="Linkedin"/></a>
					<a href="<?php echo ayarAl('youtube')?>" target="_blank"><img src="<?php echo siteAdi()?>img/youtube.png" alt="Youtube"/></a>
					<a href="#"><img src="<?php echo siteAdi()?>img/rss.png" alt="RSS"/></a>
				</div>
			</div>
			<?php //WLB integration starts here?>
			
			<div class="left-side-city-maps">
				<div class="left-side-city-maps-title">Sarajevo <?php echo langTrans('citymap')?></div>
				<div class="left-side-city-maps-image"><a class="sarajevo-citymap" href="img/city-maps/sarajevo-city-map.jpg"><img src="<?php echo siteAdi()?>img/city-maps/sarajevo-city-map-small.png"></a></div>
			</div>
			<div class="left-side-city-maps">
				<div class="left-side-city-maps-title">Mostar <?php echo langTrans('citymap')?></div>
				<div class="left-side-city-maps-image"><a class="mostar-citymap" href="img/city-maps/mostar-city-map.jpg"><img src="<?php echo siteAdi()?>img/city-maps/mostar-city-map-small.png"></a></div>
			</div>
			<div class="left-side-city-maps">
				<div class="left-side-city-maps-title">Travnik <?php echo langTrans('citymap')?></div>
				<div class="left-side-city-maps-image"><a class="travnik-citymap" href="img/city-maps/travnik-city-map.jpg"><img src="<?php echo siteAdi()?>img/city-maps/travnik-city-map-small.png"></a></div>
			</div>
			<div class="left-side-city-maps">
				<div class="left-side-city-maps-title"><?php echo langTrans('photogallery')?></div>
				<div class="left-side-city-maps-image"><a href="<?php echo siteAdi()?><?php echo langTrans('photogalleryURL')?>"><img src="<?php echo siteAdi()?>img/foto-sol.png"></a></div>
			</div>
			<div class="left-side-city-maps">
				<div class="left-side-city-maps-title"><?php echo langTrans('videogallery')?></div>
				<div class="left-side-city-maps-image"><a href="<?php echo siteAdi()?><?php echo langTrans('videogalleryURL')?>"><img src="<?php echo siteAdi()?>img/video-sol.png"></a></div>
			</div>
			<div id="weather-forecast"></div>
			<?php //WLB integration starts here?>
			
		</aside><!-- .left-sidebar -->

	</div>	
	
	<?php 
}

function printFooter(){	
	
	
	?>
	<footer class="footer">
		<div class="footer-info-container">
			<div class="footer-address">
				<?php echo langTrans('footerAdres');?>
			</div>
			
			<div>
				<ul>
					<?php 
					$footer1=sec("menu","*","menutype='mainNav' AND published=1");
					$i=1;
					while ($footNav=mysql_fetch_assoc($footer1)){
						echo '<li><a href="'.linkVer($footNav['id']).'">'.$footNav['name'.langSql()].'</a></li>';	
						if ($i==14){
							echo '</ul></div><div><ul>';
						}
						$i++;
					}
					?>
					<li><a href="<?php echo siteAdi()?>Balkanlar-Turlarlari"><?php echo langTrans('balkanTurlari')?></a></li>
					<li><a href="<?php echo siteAdi()?>Yunan-Adalari-Turlarimiz"><?php echo langTrans('yunanTurlari')?></a></li>
					<li><a href="<?php echo siteAdi();?>files/Devim-Tours-Hizmet-Sozlesmesi.pdf"><?php echo langTrans('hizmetSozlesmesi')?></a></li>
				</ul>
			</div>
			<div style="text-aling: center;">
				<img src="<?php echo siteAdi()?>img/tursab.jpg" /><br><br>
				<img src="<?php echo siteAdi()?>img/ani-tur-tatil-keyfi.png" /><br><br>
				<img src="<?php echo siteAdi()?>img/tatilbudur_logo.png"/><br><br>
				<img src="<?php echo siteAdi()?>img/mikatur_logo.png" /><br><br>
				<img src="<?php echo siteAdi()?>img/logos/iata.png" />
			</div>
		</div>
		<div class="clearer"></div>
		<div id="airlines-logo-container-id" class="airlines-logo-container">
				<div id="airlines-line1" class="airline-band">
					<a href="#"><img src="<?php echo siteAdi()?>img/logos/thy.png" /></a>
					<a href="#"><img src="<?php echo siteAdi()?>img/logos/sunexpress.png" /></a>
					<a href="#"><img src="<?php echo siteAdi()?>img/logos/pegasus-airlines-flypgs.png" /></a>
					<a href="#"><img src="<?php echo siteAdi()?>img/logos/onuair.png" /></a>
					<a href="#"><img src="<?php echo siteAdi()?>img/logos/atlasjet-airlines.png" /></a>
					<a href="#"><img src="<?php echo siteAdi()?>img/logos/anadolu-jet.png" /></a>
				</div>
				<div id="airlines-line2" class="airline-band">
					<a href="#"><img src="<?php echo siteAdi()?>img/logos/lufthansa.png" /></a>
					<a href="#"><img src="<?php echo siteAdi()?>img/logos/british-airways.png" /></a>
					<a href="#"><img src="<?php echo siteAdi()?>img/logos/airfrance.png" /></a>
					<a href="#"><img src="<?php echo siteAdi()?>img/logos/austrian-air.png" /></a>
					<a href="#"><img src="<?php echo siteAdi()?>img/logos/bh-airlines.png" /></a>
					<a href="#"><img src="<?php echo siteAdi()?>img/logos/delta.png" /></a>
					
				</div>
				<div id="airlines-line3" class="airline-band">
					<a href="#"><img src="<?php echo siteAdi()?>img/logos/etihad.png" /></a>
					<a href="#"><img src="<?php echo siteAdi()?>img/logos/sixt-rent-a-car.png" /></a>
				</div>
		</div>
		<script>
					$( document ).ready(function() {
						var lastSlide=1;
						var other1=2;
						var other2=3;
						function airlinesAnimation(){
							$( '#airlines-line'+other1 ).hide();
							$( '#airlines-line'+other2 ).hide();
							$( '#airlines-line'+lastSlide ).show();
							
							
							//alert('.airlines-line'+lastSlide);
							lastSlide=lastSlide+1;
							if(lastSlide==2){
								other1=3;
								other2=1;
							}
							if(lastSlide==3){
								other1=1;
								other2=2;
							}
							if(lastSlide==4){
								lastSlide=1;
								other1=2;
								other2=3;
							}
							
						}
						//$( '.airlines-line1' ).show(3000,function(){$( '.airlines-line1' ).hide();$( '.airlines-line2' ).show();});
						//$( '.airlines-line2' ).hide();
						//$( '.airlines-line3' ).hide();
						
						timerId=setInterval(function() {airlinesAnimation(); }, 3000);
						$( "#airlines-logo-container-id" )
						  .mouseenter(function() {
							  clearInterval(timerId);
						  })
						  .mouseleave(function() {
							  timerId=setInterval(function() {airlinesAnimation(); }, 3000);
						  });
						
					});
				</script>
		<div class="clearer"></div>
		<div class="footer-info-bottom">
			<p><?php echo langTrans('devimSorumluDegil')?></p>
			<p><?php echo langTrans('copyright')?></p>
		</div>
		
	</footer><!-- .footer -->

</div><!-- .wrapper -->
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-47517855-1', 'devimtours.com');
  ga('send', 'pageview');

</script>
</body>
</html>
	
	<?php 
	
	
	
	
	
}
function iliskiliMenu(){
	$sayfaOzellik=aliasdanIcerikOzellikleri($GLOBALS['istenenSayfaAlias']);
	
	$iliskiliMenu= '			       <div class="box">
			      	<nav class="ym-vlist">
					  <h6 class="ym-vtitle" style="margin:0px;">'.$sayfaOzellik['sayfabaslik'].'</h6>
					  '.siteMenu2($GLOBALS['istenenSayfaAlias']).'
					</nav>
			      </div>';
	return $iliskiliMenu;
}
function printBasicContent(){
	$sayfaOzellik=aliasdanIcerikOzellikleri($GLOBALS['istenenSayfaAlias']);
	echo 
	'
			<div class="ym-grid linearize-level-1">
			  <div class="ym-g25 ym-gl">
			    <div class="ym-cbox">

'.iliskiliMenu().'
'.loginBox().'
			      '.duyuruBox().'
			    </div>
			  </div>
			  <div class="ym-g75 ym-gr">
			    <div class="ym-cbox">
			       <h3>'.$sayfaOzellik['sayfabaslik'].'</h3>
			       <div class="box" style="border-radius:0px 0px 10px 10px; min-height:450px;">
			       
			       	'.$sayfaOzellik['sayfaicerik'];
			       		
			if ($sayfaOzellik['sonradahilsayfa']!=''){
				
				include 'inc/'.$sayfaOzellik['sonradahilsayfa'];
			}
	
	
			       echo '
			       </div>
			    </div>
			  </div>
			</div>
	
	';
	
	
	
	
	
}
function loginBox(){
	
	
	if (gk()){
		
		$kullaniciBilgi=mysql_fetch_assoc(sec('users','*',"id=".gk()));
		if ($kullaniciBilgi['picturePath']!=''){
			$imgShow='<img src="'.$kullaniciBilgi['picturePath'].'" width="180" alt="'.$kullaniciBilgi['firstName'].' '.$kullaniciBilgi['lastName'].'" class="center">';
		}else{
			$imgShow='';
		}
		$loginHtml='			      <div class="box2">
		'.$imgShow.'
		Hoşgeldiniz '.$kullaniciBilgi['title'].' '.$kullaniciBilgi['firstName'].' '.$kullaniciBilgi['lastName'].'
		<br>
			<a href="cikis" >Güvenli Çıkış</a><br />
			<a href="Rezervasyonlarim" >Rezervasyonlarım</a><br />
			<a href="Profil-Duzenle" >Profil Düzenle</a>
		
			      </div>';	

		
		//////yetki menüsüne başla
		
		
		$kullaniciMenu=sec("menu","*","id IN (SELECT menuId FROM userrolls WHERE userType IN (SELECT userType FROM users WHERE id='".gk()."'))");
		
		if (mysql_num_rows($kullaniciMenu)>0){
			
			
			$sayfaOzellik=aliasdanIcerikOzellikleri($GLOBALS['istenenSayfaAlias']);
			/*
			
			$loginHtml.= '			       <div class="box">
			<nav class="ym-vlist">
			<h6 class="ym-vtitle" style="margin:0px;">Yetkili olduğunuz işlemler</h6>
			<ul>
			';
			while ($rol=mysql_fetch_assoc($kullaniciMenu)){
				
				
				$loginHtml.='<li><a href="'.menuLinkVer($rol['alias']).'">'.$rol['name'].'</a></li>';
				
				
			}
			
			$loginHtml.='</ul>
		
			</nav>
			</div>
			
			';
			
			*/
			
			
			///////////
			
			$alias= $GLOBALS['istenenSayfaAlias'];
			$linkDerinlik_= substr(get_path_alias(aliasdanMenuId($alias)),0,-1);
			
			$parentIds[]=0;
			
			if ($linkDerinlik_==''){
			
				if ($alias=='') {
					$linkDerinlik[]='';
				}else{
					$linkDerinlik[]=$alias;
					$parentIds[]=aliasdanMenuId($alias);
				}
			
			}else{
				$linkDerinlik=explode('/',$linkDerinlik_);
				$linkDerinlik[]=$alias;
			
				for ($i=0;$i<count($linkDerinlik);$i++){
					$j=$i+1;
					$parentIds[]=aliasdanMenuId($linkDerinlik[$i]);
				}
			}
			
			if ($linkDerinlik[0]=='') {
				$derinlik=0;
			}else{
				$derinlik=count($linkDerinlik);
			}
			
			
			$menuHtml=aliasdanYetkiliAltMenu($alias,$linkDerinlik,$parentIds,0);
			
			
			///////////
			
			$loginHtml.= '			       <div class="box">
			<nav class="ym-vlist">
			<h6 class="ym-vtitle" style="margin:0px;">Yetkili olduğunuz işlemler</h6>
			
			'.$menuHtml;
		
				
			$loginHtml.='
			
			</nav>
			</div>
				
			';
			
			//$loginHtml=siteMenu2($GLOBALS['istenenSayfaAlias']);
			
		}
		
		////// yeki menü son
		
		
//		echo session_cache_expire();
//print_r (session_get_cookie_params());
		
		
	}else{
	$loginHtml='			    
							<form class="ym-form ym-columnar" id="form1" method="post" action="giris">
							 	<div class="ym-fbox-text">
								  	<label for="email">e-Posta</label>
								  	<input type="text" name="email" id="email" size="20" required="required" autocomplete="off"/>
								</div>
								<div class="ym-fbox-text">
	  								<label for="password">Şifre</label>
								  	<input type="password" name="password" id="password" size="20" required="required" autocomplete="off"/>
								</div>
								<div class="ym-fbox-button center">
									<input id="inputsubmit1" class="save" type="submit" name="inputsubmit1" value="Giriş">
									
									<a href="https://sorubank.med.ege.edu.tr/password_reminder" class="ym-button" target="_blank">Hatırlat</a>
								</div>
							</form>	
			     ';
	}
	
	
	return $loginHtml;
}
function rezBox(){
	
	$rezMaddeleri=sec('menu','*',"menutype='Rezervasyon' ORDER BY ordering");
	$rezLi='';
	while($rezMad=mysql_fetch_assoc($rezMaddeleri)){
		if (11!=$rezMad['id']){
		if ( $GLOBALS['istenenSayfaAlias']==$rezMad['alias']){
			$rezLi.='<li><strong><span style="color: #66AB16">'.$rezMad['name'].'</span></strong></li>';
		}else{
			$rezLi.='<li>'.$rezMad['name'].'</li>';
			//$rezLi.='<li><a href="'.$rezMad['alias'].'">'.$rezMad['name'].'</a></li>';
		}
		}
	}
	if (tempRezId()){
		tempZamanKontrol();
		$kalanSure='<div id="kalanSure">Kalan Süreniz: '.tempKalanSure().'</div>';
	}else{
		$kalanSure='';
	}
	
	$rezHtml='
				   <div class="box">
				   		'.$kalanSure.'
			      	<nav class="ym-vlist">
					  <h6 class="ym-vtitle">Rezervasyon Adımları</h6>
					  <ol>
'.$rezLi.'
					  </ol>
					</nav>
			      </div>
	
	';
	
	
	return $rezHtml;
	
	
}

function duyuruBox(){
	$duyuruHtml='<div class="box2">
			      	<h6 style="margin:0px;">Duyurular</h6>
			      	<ul>
			      		<li style="color:red">Web sitesi içerik geliştirme çalışmaları halen devam etmektedir.</li>
			      		<li>ÖKM Web Sitesi kullanıma açılmıştır.</li>
			      	</ul>
			      </div>';
	return $duyuruHtml;
}
function giveMeParentMenu($menuType='mainmenu',$alias=''){
	
	$linkDerinlik_= substr(get_path_alias(aliasdanMenuId($alias)),0,-1);
	
	$linkDerinlik=explode('/',$linkDerinlik_);
	
	$derinlik=count($linkDerinlik);
	
	$menuHtml='
	<ul>';
	
	$anaMenuSolTaraf=mysql_query("SELECT * FROM menu WHERE menutype='".$menuType."' AND published=1 AND parent=0 ORDER BY ordering");
	$menuHtml.='<li><a href="Anasayfa">Anasayfa</a></li>';
	while ($menuMadde=mysql_fetch_assoc($anaMenuSolTaraf)) {
			
			
		if ($alias==$menuMadde['alias']) {
			$aktif=' class="active"';
		}else{
			$aktif='';
		}
	
			

			$menuHtml.= '<li'.$aktif.'><a href="'.menuLinkVer($menuMadde['alias']).'" title="">'.$menuMadde['name'].'</a></li>';
			
	}
	
	$menuHtml.='			</ul>
	
	';
	
	return $menuHtml;
	
}
function giveMeMenu($menuType='mainmenu',$alias='', $parent='0'){
	
	
	
	$linkDerinlik_= substr(get_path_alias(aliasdanMenuId($alias)),0,-1);
	
	$linkDerinlik=explode('/',$linkDerinlik_);
	
	$derinlik=count($linkDerinlik);
	
	$menuHtml='
	<ul>';
	
	$anaMenuSolTaraf=mysql_query("SELECT * FROM menu WHERE menutype='".$menuType."' AND published=1 AND parent=".$parent." ORDER BY ordering");
	
	while ($menuMadde=mysql_fetch_assoc($anaMenuSolTaraf)) {
			
			
		if ($alias==$menuMadde['alias']) {
			$aktif=' class="active"';
		}else{
			$aktif='';
		}
	
			
		if ($alias==$menuMadde['alias']) {
	
	
	
				
			$altMenu=sec('menu','*'," menutype='mainmenu' AND published=1 AND parent=".aliasdanMenuId($alias));
				
			if (mysql_num_rows($altMenu)>0) {
	
				$menuHtml.= '<li'.'><a href="'.menuLinkVer($menuMadde['alias']).'" title="">'.$menuMadde['name'].'</a>';
					
				$menuHtml.='<ul>';
	
					
				while ($altMenuMad=mysql_fetch_assoc($altMenu)) {
					$menuHtml.= '<li'.$aktif.'><a href="'.menuLinkVer($altMenuMad['alias']).'" title="">'.$altMenuMad['name'].'</a></li>';
				}
	
					
				$menuHtml.='</ul>';
	
				$menuHtml.='</li>';
					
					
			}else{
				$menuHtml.= '<li'.$aktif.'><a href="'.menuLinkVer($menuMadde['alias']).'" title="">'.$menuMadde['name'].'</a></li>';
			}
		}else{
			$menuHtml.= '<li'.$aktif.'><a href="'.menuLinkVer($menuMadde['alias']).'" title="">'.$menuMadde['name'].'</a></li>';
		}
			
	}
		
	$menuHtml.='			</ul>
	
	';
	
	return $menuHtml;
}


function siteMenu($alias=''){
	
	
	
	$linkDerinlik_= substr(get_path_alias(aliasdanMenuId($alias)),0,-1);
	
	$linkDerinlik=explode('/',$linkDerinlik_);
	
	$derinlik=count($linkDerinlik);
	
	
	
	/*
	echo $derinlik;
	print_r($linkDerinlik); ///3 Array ( [0] => menu1 [1] => menu4 [2] => ) 
	return ;
	*/
	
		
	$menuHtml='
	<div id="menu">
			<ul>';

				$anaMenuSolTaraf=mysql_query("SELECT * FROM menu WHERE menutype='mainmenu' AND published=1 AND parent=0 ORDER BY ordering");
				
				while ($menuMadde=mysql_fetch_assoc($anaMenuSolTaraf)) {
					
					
					if ($alias==$menuMadde['alias'.langSql()]) {
						$aktif=' class="active"';
					}else{
						$aktif='';
					}
								
					if(in_array($menuMadde['alias'.langSql()],$linkDerinlik)){
						
						
						for ($i=1; $i<=$derinlik;$i++){

							
						}
						
					}else{
						
					}
					
					
					if ($alias==$menuMadde['alias'.langSql()]) {
						
						
				
			
							$altMenu=sec('menu','*'," menutype='mainmenu' AND published=1 AND parent=".aliasdanMenuId($alias));
							
							if (mysql_num_rows($altMenu)>0) {
								
								$menuHtml.= '<li'.'><a href="'.menuLinkVer($menuMadde['alias'.langSql()]).'" title="">'.$menuMadde['name'.langSql()].'</a>';
									
									$menuHtml.='<ul>';
										
									
									while ($altMenuMad=mysql_fetch_assoc($altMenu)) {
										$menuHtml.= '<li'.$aktif.'><a href="'.menuLinkVer($altMenuMad['alias'.langSql()]).'" title="">'.$altMenuMad['name'.langSql()].'</a></li>';	
									}					
						
									
									$menuHtml.='</ul>';
								
								$menuHtml.='</li>';		
															
			
							}else{
								$menuHtml.= '<li'.$aktif.'><a href="'.menuLinkVer($menuMadde['alias'.langSql()]).'" title="">'.$menuMadde['name'.langSql()].'</a></li>';		
							}
					}else{
						$menuHtml.= '<li'.$aktif.'><a href="'.menuLinkVer($menuMadde['alias'.langSql()]).'" title="">'.$menuMadde['name'.langSql()].'</a></li>';		
					}
					
				}
			
$menuHtml.='			</ul>
		</div>
	';

echo $menuHtml;

}

function siteMenu2($alias=''){
	
	$linkDerinlik_= substr(get_path_alias(aliasdanMenuId($alias)),0,-1);
	
	//echo '----'.$linkDerinlik_.'----';
	
	$parentIds[]=0;
	
	if ($linkDerinlik_==''){
		
		if ($alias=='') {
			$linkDerinlik[]='';	
		}else{
			$linkDerinlik[]=$alias;
			$parentIds[]=aliasdanMenuId($alias);
		}
		
	}else{
		$linkDerinlik=explode('/',$linkDerinlik_);
		$linkDerinlik[]=$alias;
		
		for ($i=0;$i<count($linkDerinlik);$i++){
			$j=$i+1;
			$parentIds[]=aliasdanMenuId($linkDerinlik[$i]);
		}
	}

	if ($linkDerinlik[0]=='') {
		$derinlik=0;
	}else{
		$derinlik=count($linkDerinlik);	
	}
	
	//echo $derinlik;

	//echo $alias;
	//print_r($parentIds);
	//print_r($linkDerinlik);
	//Array ( [0] => 0 [1] => 1 [2] => 9 [3] => 12 ) 
	//Array ( [0] => menu1 [1] => menu4 [2] => menu4-2 ) 
	
		$menuHtml='
		
				';
	

	
	
	$menuHtml.=aliasdanAltMenu($alias,$linkDerinlik,$parentIds,1);
	
	
	
	
	
		$menuHtml.='			';

return $menuHtml;	
	
	
	
	
}
function aliasdanAltMenu($alias,$linkDerinlik,$parentIds,$parent=0,$level=14){
	
	$menuHtml='			
	<ul class="siteMenu">
	';
	
	
			$anaMenuSolTaraf=mysql_query("SELECT * FROM menu WHERE menutype='mainmenu' AND published=1 AND parent=".$parentIds[$parent]." ORDER BY ordering");
				//echo  "SELECT * FROM menu WHERE menutype='mainmenu' AND published=1 AND parent=".$parentIds[$parent]." ORDER BY ordering";
				while ($menuMadde=mysql_fetch_assoc($anaMenuSolTaraf)) {
					
					
				//	print_r($menuMadde);
				//	echo $alias;
					//echo $menuMadde['alias'].'<br>';
					if ($alias==$menuMadde['alias'.langSql()]) {
						$aktif=' style="	background: #EBEEF3; text-decoration: none; font-weight: bold; color: #385B88;"';
					}else{
						$aktif='';
					}					
					
					
					
					if (in_array($menuMadde['alias'.langSql()],$linkDerinlik) || $alias==$menuMadde['alias'.langSql()]) {
						
						
						
						$menuHtml.= '<li><a '.$aktif.' href="'.menuLinkVer($menuMadde['alias'.langSql()]).'" title="" >'.$menuMadde['name'.langSql()].'</a>';			
						$menuHtml.=aliasdanAltMenu($alias,$linkDerinlik,$parentIds,$parent+1,$level+5);
						$menuHtml.='</li>
						';
						
						
					}else{
						$menuHtml.= '<li'.$aktif.'><a href="'.menuLinkVer($menuMadde['alias'.langSql()]).'" title="" style="">'.$menuMadde['name'.langSql()].'</a></li>
						';			
					}
					
					
					
					
				}
	
	$menuHtml.='	
	</ul>
	';
	
	return $menuHtml;
	
}

function aliasdanYetkiliAltMenu($alias,$linkDerinlik,$parentIds,$parent=0,$level=14){

	$menuHtml='
	<ul class="siteMenu">
	';


	$anaMenuSolTaraf=mysql_query("SELECT * FROM menu WHERE menutype='YetkiMenu' AND published=1 AND parent=".$parentIds[$parent]." AND id IN (SELECT kategoriid FROM icerikler WHERE icerikid IN (SELECT menuId FROM userrolls WHERE userType IN (SELECT userType FROM users WHERE id='".gk()."'))) ORDER BY ordering");
	//echo  "SELECT * FROM menu WHERE menutype='mainmenu' AND published=1 AND parent=".$parentIds[$parent]." ORDER BY ordering";
	while ($menuMadde=mysql_fetch_assoc($anaMenuSolTaraf)) {
			
			
		//	print_r($menuMadde);
		//	echo $alias;
		//echo $menuMadde['alias'].'<br>';
		if ($alias==$menuMadde['alias'.langSql()]) {
			$aktif=' style="	background: #EBEEF3; text-decoration: none; font-weight: bold; color: #385B88;"';
		}else{
			$aktif='';
		}
			
			
			
		if (in_array($menuMadde['alias'.langSql()],$linkDerinlik) || $alias==$menuMadde['alias'.langSql()]) {



			$menuHtml.= '<li><a '.$aktif.' href="'.menuLinkVer($menuMadde['alias'.langSql()]).'" title="" >'.$menuMadde['name'.langSql()].'</a>';
			$menuHtml.=aliasdanYetkiliAltMenu($alias,$linkDerinlik,$parentIds,$parent+1,$level+5);
			$menuHtml.='</li>
			';


		}else{
			$menuHtml.= '<li'.$aktif.'><a href="'.menuLinkVer($menuMadde['alias'.langSql()]).'" title="" style="">'.$menuMadde['name'.langSql()].'</a></li>
			';
		}
			
			
			
			
	}

	$menuHtml.='
	</ul>
	';

	return $menuHtml;

}
function altMenuVarMi($menuId){
	
	if(mysql_num_rows(sec("menu","*","parent=".$menuId))==0){
		return false;
	}else{
		return true;
	}
	
	
}
function ustMenuVarMi($alias){
	
	$ustPageId_=mysql_fetch_assoc(sec("menu","*","alias='".$alias."'"));
	if($ustPageId_['parent']==0){
		return false;
	}else{
		return true;
	}
	
	
}
function ustMenuId ($pageId){
	
	$ustPageId_=mysql_fetch_assoc(sec("menu","*","id=".$pageId));
	if($ustPageId_['parent']==0){
		return false;
	}else{
		return $ustPageId_['parent'];
	}
	
	
}

function siteMenuNoSublink(){
	
}

function seoAdiAl ($pageId){
	
	$ustPageId_=mysql_fetch_assoc(sec("menu","*","id=".$pageId));

		/*if ($ustPageId_['alias']=='') {
			$seolanmis=urlSeoYap($ustPageId_['name']);
			$sqlPageInsert='UPDATE pages 
						SET
						friendlyName="'.$seolanmis.'"
						WHERE pageId='.$ustPageId_['pageId'].'
					';	
			mysql_query($sqlPageInsert);
		}*/
		
		return $ustPageId_['alias'.langSql()];
	
	
	
}

function linkVer($pageId){
	
	
	
	if (linkVarmi($pageId)) {
		$linkEklenti=linkVarmi($pageId);
		
	}else{
		
		
		$linkEklenti=ayarAl('siteAdi');
		$link_=mysql_fetch_assoc(sec("menu","*","id=".$pageId));
		
		if (substr($link_['alias'.langSql()],0,1)=='#'){
			$linkEklenti='JavaScript:void(0);';
		}else{
			if (ustMenuVarMi($pageId)) {
				$linkEklenti.=seoAdiAl(ustMenuId($pageId)).'/';
				$linkEklenti.=seoAdiAl($pageId).'';
			}else{
				$linkEklenti.=seoAdiAl($pageId).'';
			}
						
		}

		
	}
	return $linkEklenti;
}

function menuLinkVer($alias){
	
	
	if (linkVarmi($alias)) {
		$linkEklenti=linkVarmi($alias);
		
	}else{
		
	
		$linkEklenti=ayarAl('siteAdi');
		$link_=mysql_fetch_assoc(sec("menu","*","alias".langSql()."='".$alias."'"));
		
		
		//$linkEklenti.=get_path_alias(aliasdanMenuId($alias));
		$linkEklenti.=$alias.'';
		
		/*
		if (ustMenuVarMi($pageId)) {
			$linkEklenti.=seoAdiAl(ustMenuId($pageId)).'/';
			$linkEklenti.=seoAdiAl($pageId).'.html';
		}else{
			$linkEklenti.=seoAdiAl($pageId).'.html';
		}
		*/
		
	}
	return $linkEklenti;
}

function icerikLinkVer($alias){
	
	

		
	
		$linkEklenti=ayarAl('siteAdi');
		
		
		
		
		$linkEklenti.=$alias.'.html';
		
		/*
		if (ustMenuVarMi($pageId)) {
			$linkEklenti.=seoAdiAl(ustMenuId($pageId)).'/';
			$linkEklenti.=seoAdiAl($pageId).'.html';
		}else{
			$linkEklenti.=seoAdiAl($pageId).'.html';
		}
		*/
		
	
	return $linkEklenti;
}
function linkVarmi($alias){
		$ustPageId_=mysql_fetch_assoc(sec("menu","*","alias".langSql()."='".$alias."'"));

		if ($ustPageId_['link']=='') {
			return false;
		}else{
			return $ustPageId_['link'];	
		}
}

function foot(){
	echo'
</body>
</html>';
}

function ekranMesaji($mesaj,$type='info'){
	echo '<p class="box '.$type.' center">
			'.$mesaj.'			
		</p>';
}
function ekranMetni($mesaj){
	echo '<p class="">
	'.$mesaj.'
	</p>';
}
function ga($id){
	return $GLOBALS['em['.$id.']'];
}
function ekranMesajiDie($mesaj="Bir sorun oluştu",$errorFlag="error"){
	
	if ($mesaj=='Bir sorun oluştu'){
		$mesaj=langTrans("somethingwentwrong");
	}
	
	
	printHead('Devim Tours Error');
	

	
	ekranMesaji($mesaj, $errorFlag);
	
	printLeftAside();
	printFooter();
	die;
	
}
function aliasLangMenu($alias, $toLang, $fromLang){
	if ($alias==''){
		return '';
	}else{
		$alias_=mysql_fetch_assoc(sec("menu","*","alias".$fromLang."='".$alias."'"));
		return $alias_['alias'.$toLang];
	}	
}
function langSql(){
	return $GLOBALS['L'];
}



/****************************WLB INtegration****************************/
function video_gallery(){
	?>
				<div class="video-container">
					<div class="mainpage-video-title">Bosnia <?php echo langTrans('videogallery')?></div>
					<div class="mainpage-video-items-container">
						<?php 
							$videos_=sec("galleryitems","*","galleryId=10 AND active=1 ORDER BY RAND() LIMIT 3");
							
							while ($video=mysql_fetch_assoc($videos_)){
						
						?>
						<div class="mainpage-video-item">
							<div><a href="<?php echo langTrans('videogalleryURL')?>?id=<?php echo $video['id'];?>" title="<?php echo $video['label'];?>"><img src="<?php echo $video['thumbPath'];?>" width="172" height="116"></a></div>
							<div><a href="<?php echo langTrans('videogalleryURL')?>?id=<?php echo $video['id'];?>" title="<?php echo $video['label'];?>"><?php echo $video['label'];?></a></div>
						</div>
						<?php }?>
					</div>
				</div>
				<div class="clearer"></div>	
	
	<?php 
}
function image_gallery(){
	?>
				<div class="imageGallery-container">
					<div class="mainpage-gallery-title">Bosnia <?php echo langTrans('photogallery')?></div>
					<div class="mainpage-gallery-items">
						<div class="mainpage-video-items-container">
							<?php
							$galleries_=sec("gallery","*","active=1 AND type=1 ORDER BY RAND() LIMIT 3");
								
							while ($gallery=mysql_fetch_assoc($galleries_)){
							
							?>
							<div class="mainpage-video-item">
								<div><a href="<?php echo langTrans('photogalleryViewURL'); ?>?id=<?php echo $gallery['id'];?>" title="<?php echo $gallery['name'];?>"><img src="<?php echo $gallery['displayPicture'];?>" width="172" height="116"></a></div>
								<div><a href="<?php echo langTrans('photogalleryViewURL'); ?>?id=<?php echo $gallery['id'];?>" title="<?php echo $gallery['name'];?>"><?php echo $gallery['name'];?></a></div>
							</div>
							<?php 
							}
							?>
						</div>
					</div>
				</div>
				<div class="clearer"></div>	
	
	<?php 
}