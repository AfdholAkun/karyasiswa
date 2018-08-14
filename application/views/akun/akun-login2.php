<!DOCTYPE html>
<html >
<head>
	<meta charset="UTF-8">
	<title>Calm breeze login screen</title>

	<link rel="stylesheet" href="<?php echo (LOGIN.'css/style.css');?>" type="text/css">
	<link href="<?php echo (CSS.'bootstrap.min.css');?>" rel="stylesheet" type="text/css">
	<link href="<?php echo (CSS.'animate.min.css');?>" rel="stylesheet">
	<link href="<?php echo (SWEET.'sweetalert.css');?>" rel="stylesheet">

	<script src="<?php echo (JS.'jquery.js');?>"></script>
	<script src="<?php echo (JS.'bootstrap.min.js');?>"></script>
	<script src="<?php echo (JS.'bootstrap-notify.min.js');?>"></script>
	<script src="<?php echo (SWEET.'sweetalert.min.js');?>"></script>
</head>

<body>
<div class="wrapper">
	<div class="container">
		<h1 id="judul" style="color:white;">Login</h1>
		<form class="form" id="form-login">
			<input type="text" placeholder="Username" name="username">
			<input type="password" placeholder="Password" name="password">
			<button type="submit" id="login-button">Login</button>
		</form>
	</div>
	<ul class="bg-bubbles">
		<li></li>
		<li></li>
		<li></li>
		<li></li>
		<li></li>
		<li></li>
		<li></li>
		<li></li>
		<li></li>
		<li></li>
	</ul>
</div>
<script>
	$(document).ready(function() {
		$('#form-login').on('submit', function(e) {
			e.preventDefault();
			var url;
			var data = new FormData($('#form-login')[0]);
			url = '<?php echo site_url('login/sign_in')?>';
			var username = $('[name=username]');
			var password = $('[name=password]');
			$.ajax({
				url: url,
				type: 'post',
				data: data,
				contentType: false,
				processData: false,
				async: false,
				dataType: 'json',
				cache:false,
				success:function(data){
					$('#judul').text("Selamat Datang");
					$('#form-login').fadeOut(500);
					$('.wrapper').addClass('form-success');
					username.addClass('animated shake');
					username.one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function() {
						username.removeClass('animated shake');
					});
					password.addClass('animated shake');
					password.one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function() {
						password.removeClass('animated shake');
					});
				}
			});
		});
	});
</script>
</body>
</html>
