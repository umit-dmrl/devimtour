<?php include 'header_view.php'; ?>
<section class="content-header">
	<h1>Hoşgeldin <?php echo $_SESSION["username"]; ?></h1>
</section>
<section class="content">
	<div class="box">
		<div class="box-body">
			<h3><font color='#3c8dbc'>Tur İstatistikleri</font></h3>
			<?php
			include 'admin_db.php';
			$toplam_tur_sayisi=0;
			$toplam_tur = $baglanti->query("select * from turlar");
			foreach($toplam_tur as $toplam_val)
			{
				$toplam_tur_sayisi++;
			}
			$aktif_tur_sayisi=0;
			$aktif_tur = $baglanti->query("select * from turlar where aktif=1");
			foreach($aktif_tur as $aktif_val)
			{
				$aktif_tur_sayisi++;
			}
			$pasif_tur_sayisi = $toplam_tur_sayisi-$aktif_tur_sayisi;
			?>
			<div class="row">
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-aqua">
                <div class="inner">
                  <h3><a href="TurListesi.php" style="color:white;"><?php echo $toplam_tur_sayisi; ?></a></h3>
                  <p><a href="TurListesi.php" style="color:white;"><i style="color:0000" class="fa fa-pie-chart"></i> Toplam Tur Sayısı</a></p>
                </div>
                <div class="icon">
                  <i class="ion ion-bag"></i>
                </div>
                
              </div>
            </div><!-- ./col -->
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-green">
                <div class="inner">
                  <h3><a href="TurListesi.php?filtre=aktif_tur" style="color:white;"><?php echo $aktif_tur_sayisi; ?></a></h3>
                  <p><a href="TurListesi.php?filtre=aktif_tur" style="color:white;"><i style="color:0000;" class="fa fa-arrow-circle-right"></i> Aktif Tur Sayısı</a></p>
                </div>
                <div class="icon">
                  <i class="ion ion-stats-bars"></i>
                </div>
                
              </div>
            </div><!-- ./col -->
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-yellow">
                <div class="inner">
                  <h3><a href="TurListesi.php?filtre=pasif_tur" style="color:white;"><?php echo $pasif_tur_sayisi; ?></a></h3>
                  <p><a href="TurListesi.php?filtre=pasif_tur" style="color:white;"><i style="color:0000;" class="fa fa-arrow-circle-right"></i> Pasif Tur Sayısı</a></p>
                </div>
                <div class="icon">
                  <i class="ion ion-person-add"></i>
                </div>
                
              </div>
            </div><!-- ./col -->
          </div>
		</div>
	</div>
</section>	
<?php include 'footer_view.php'; ?>