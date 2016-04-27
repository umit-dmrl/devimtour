<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Yönetim Paneli</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="admin_tasarim/bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="font-awesome/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="admin_tasarim/dist/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="admin_tasarim/dist/css/AdminLTE.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="admin_tasarim/plugins/iCheck/square/blue.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body class="hold-transition login-page">
    <div class="login-box">
      <div class="login-logo">
        <a href="javascript:void()"><b>Yönetim Paneli</b></a>
      </div><!-- /.login-logo -->
      <div class="login-box-body">
        <p class="login-box-msg">Lütfen bilgilerinizi giriniz.</p>
        <form action="" method="post">
			<input type="hidden" name="state" value="state" />
          <div class="form-group has-feedback">
            <input type="text" class="form-control" name="eposta" placeholder="E-mail Adresi">
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input type="password" name="parola" class="form-control" placeholder="Şifre">
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
          <div class="row">
            <div class="col-xs-8" style="display:none;">
              <div class="checkbox icheck">
                <label>
                  <input type="checkbox"> Remember Me
                </label>
              </div>
            </div><!-- /.col -->
            <div class="col-xs-4">
              <button type="submit" name="bntLogin" class="btn btn-primary btn-block btn-flat">Giriş Yap</button>
            </div><!-- /.col -->
          </div>
        </form>
		
	<br>
	<?php
	session_start();
	
	if(isset($_POST["bntLogin"]))
	{
		include 'admin_db.php';
		$kullanici_adi = $_POST["eposta"];
		$parola = $_POST["parola"];
		$login = $baglanti->query("select * from admin where kullanici_adi='".$kullanici_adi."' and parola='".$parola."'");
		$sayac=0;
		$user="";
		foreach($login as $val)
		{
			$user=$val["kullanici_adi"];
			$sayac++;
		}
		if($sayac==0)
		{
			echo "<font color='maroon'>Kullanıcı Adı Veya Parola Hatalı !</font>";
		}else{
			$_SESSION["username"] = $user;
			header("Location:index.php");
		}
	}
	?>

       

      </div><!-- /.login-box-body -->
    </div><!-- /.login-box -->

    <!-- jQuery 2.1.4 -->
    <script src="admin_tasarim/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="admin_tasarim/bootstrap/js/bootstrap.min.js"></script>
    <!-- iCheck -->
    <script src="admin_tasarim/plugins/iCheck/icheck.min.js"></script>
    <script>
      $(function () {
        $('input').iCheck({
          checkboxClass: 'icheckbox_square-blue',
          radioClass: 'iradio_square-blue',
          increaseArea: '20%' // optional
        });
      });
    </script>
  </body>
</html>
