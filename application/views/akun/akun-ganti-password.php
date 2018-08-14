
<div class="col-md-12">
	<div class="row">
		<div class="panel panel-default">
			<div class="panel-heading" >
				<span style="font-size: 12pt">Data User</span>
				<!-- <div class="pull-right" style="margin-top: -4px;">
					<button class="btn btn-sm btn-flat"><i class="glyphicon glyphicon-arrow-left"></i></button>
				</div> -->
			</div>
			<div class="panel-body">
				<div class="col-md-6 col-md-offset-3">
					<div class="row">
						<form action="" method="post" id="form-ganti-password">
							<div class="form-group">
								<label class="control-label">Password</label>
								<input type="password" name="password_lama" class="form-control" id="password" required maxlength="25">
								<p class="control-label" style="font-size: 8pt;">*Password 5-25 karakter</p>
							</div>
							<div class="form-group">
								<label class="control-label">Password Baru</label>
								<input type="password" name="password_baru" class="form-control" required maxlength="25">
								<p class="control-label" style="font-size: 8pt;">*Password 5-25 karakter</p>
							</div>
							<div class="form-group">
								<label class="control-label">Ulangi Password Baru</label>
								<input type="password" name="ulangi_password_baru" class="form-control" required maxlength="25">
								<p class="control-label" style="font-size: 8pt;">*Password 5-25 karakter</p>
							</div>
							<div class="form-group pull-right">
								<button type="reset" class="btn btn-danger btn-flat"> Reset</button>
								<button type="submit" class="btn btn-primary btn-flat ladda-button" data-style="zoom-in" id="btn-simpan" name="simpan""><span class="ladda-label">Simpan</span></button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function() {
	var s = Ladda.create(document.querySelector("[name=simpan]"));

		$('#form-ganti-password').on("submit", function(e) {
			e.preventDefault();
				s.start();
				setTimeout(function(){

			var password_lama = $('[name=password_lama]');
			var password_baru = $('[name=password_baru]');
			var ulangi_password_baru = $('[name=ulangi_password_baru]');
			var data = new FormData($('#form-ganti-password')[0]);
			var result = '';
			if (password_lama.val().length < 5 || password_lama.val().length > 25) {
				password_lama.parent().parent().addClass('has-error');
			}else{
				password_lama.parent().parent().removeClass('has-error');
				result += '1';
			}
			if (password_baru.val().length < 5 || password_baru.val().length > 25) {
				password_baru.parent().parent().addClass('has-error');
			}else{
				password_baru.parent().parent().removeClass('has-error');
				result += '2';
			}
			if (ulangi_password_baru.val().length < 5 || ulangi_password_baru.val().length > 25) {
				ulangi_password_baru.parent().parent().addClass('has-error');
			}else{
				ulangi_password_baru.parent().parent().removeClass('has-error');
				result += '3';
			}
			if (result == '123') {
					$.ajax({
						url: link+'akun/AksiGantiPassword',
						type: 'post',
						data: data,
						contentType: false,
						processData: false,
						dataType:'json',
						success: function(data){
							if (data.notif == 2){
								notify("Error", "Password anda salah", "warning");
							}else if (data.notif == 3){
								notify("Warning", "Password baru dan password lama tidak valid", "warning");
							}else if (data.notif == 1){
								notify("Success", "Berhasil Ganti Password", "success");
								$('#form-ganti-password')[0].reset();

							}else {
								notify("Error", "Gagal Ganti Password", "danger");
							}
						},
						error: function(){
							notify("Error System", "Gagal Ganti Password", "danger");
						}
					});
				}
				s.stop();	
			}, 500);

		});
	});

</script>