<style>
	#tables tbody tr td:nth-child(1) {
		text-align: center;
	}
</style>
<div class="col-md-12">
	<div class="row">
		<div class="panel panel-default">
			<div class="panel-heading" >
				<span style="font-size: 11pt">Data User
				</span>
			</div>
			<div class="panel-body">
				<div class="col-md-12">
					<div class="row">
						<div class="slot">
							<button type="button" onclick="InsertData()" class="btn bg-green btn-flat"><i class="fa fa-plus"></i> Tambah Data</button>
							<button onclick="ResetData()" class="btn bg-green btn-flat" id="reset_data"><i class="fa fa-trash"></i> Reset Data</button>
						</div>
					</div>
				</div>
				
				<div class="col-md-12">
					<div class="row">
						<table class="table table-hover table-bordered table-striped" id="tables" width="100%">
							<thead class="bg-green">
							<tr>
								<td width="5%" class="text-center">No</td>
								<td width="">Kode User</td>
								<td width="">Nama User</td>
								<td width="">Email</td>
								<td width="">Level</td>
								<td width="">Status</td>
								<td class="text-center" width="20%">Opsi</td>
							</tr>
							</thead>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="modal-form">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header bg-green">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Tambah Data</h4>
			</div>
			<form action="#" id="form" class="form-horizontal">
				<div class="modal-body">
					<input type="hidden" name="kode_user_lama">
					<input type="hidden" name="email_lama">
					<input type="hidden" name="email_status" value="0">
					<input type="hidden" name="username_status" value="0">
					<input type="hidden" name="password_status" value="0">
					<div class="form-group" id="box-kode-user">
						<label class="control-label col-md-3">Kode User</label>
						<div class="col-md-9">
							<input type="text" name="kode_user" class="form-control" required readonly="">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-3">Nama User</label>
						<div class="col-md-9">
							<input type="text" name="name_user" class="form-control" required maxlength="100">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-3">Email</label>
						<div class="col-md-9">
							<input type="email" name="email" class="form-control" required onkeyup="CekEmail()" maxlength="50">
							<p id="email_info" class="control-label" style="margin-bottom: -10px;font-size: 7pt;">*Email tidak boleh kosong</p>
						</div>
					</div>
					<div class="form-group" id="box-username">
						<label class="control-label col-md-3">Username</label>
						<div class="col-md-9">
							<input type="text" name="username" class="form-control"required onkeyup="CekUsername()" maxlength="25">
							<p id="username_info" class="control-label" style="margin-bottom: -10px;font-size: 7pt;">*Username 5-35 karakter</p>
						</div>
					</div>
					<div class="form-group" id="box-password">
						<label class="control-label col-md-3">Password</label>
						<div class="col-md-9">
							<input type="password" name="password" class="form-control" required onkeyup="CekPassword()">
							<p id="passsword_info" class="control-label" style="margin-bottom: -10px;font-size: 7pt;">*Password 5-35 karakter</p>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-3">Level</label>
						<div class="col-md-9">
							<select class="form-control" name="level" required>
								<option value="">Pilih</option>
								<option value="Admin">Admin</option>
								<option value="Operator">Operator</option>]
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-3">Status</label>
						<div class="col-md-9">
							<select class="form-control" name="user_status" required>
								<option value="">Pilih</option>
								<option value="Aktif">Aktif</option>
								<option value="Nonaktif">Nonaktif</option>
							</select>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default btn-flat" onclick="ResetInputAja();ResetInput();">Reset</button>
					<button type="submit" class="btn bg-green btn-flat ladda-button" data-style="zoom-in" id="btn-simpan" name="save""><span class="ladda-label">Simpan</span></button>
				</div>
			</form>
		</div>
	</div>
</div>

<div class="modal fade" id="modal-detail">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header bg-green">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Detail User</h4>
			</div>
			<div class="modal-body">
				<div class="table-responsive">
					<table class="table" width="100%">
						<tr>
							<th width="29%">Kode User</th>
							<th width="2%">:</th>
							<th class="kode_user"></th>
						</tr>
						<tr>
							<th>Nama User</th>
							<th>:</th>
							<th class="name_user"></th>
						</tr>
						<tr>
							<th>Email</th>
							<th>:</th>
							<th class="email"></th>
						</tr>
						<tr>
							<th>Level</th>
							<th>:</th>
							<th class="level"></th>
						</tr>
						<tr>
							<th>Status</th>
							<th>:</th>
							<th class="user_status"></th>
						</tr>
						<tr>
							<th>Dibuat Oleh</th>
							<th>:</th>
							<th class="created_by"></th>
						</tr>
						<tr>
							<th>Tanggal Dibuat</th>
							<th>:</th>
							<th class="created_date"></th>
						</tr>
						<tr>
							<th>Terakhir Edit Oleh</th>
							<th>:</th>
							<th class="last_modified_by"></th>
						</tr>
						<tr>
							<th>Tanggal Terakhir Edit</th>
							<th>:</th>
							<th class="last_modified_date"></th>
						</tr>
					</table>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">

	var SaveMethod = "Tambah";
	var l = Ladda.create(document.querySelector('[name=save]'));

	var kode_user_lama = $('[name=kode_user_lama]');
	var email_lama = $('[name=email_lama]');
	var email_status = $('[name=email_status]');
	var username_status = $('[name=username_status]');
	var password_status = $('[name=password_status]');

	var kode_user = $('[name=kode_user]');
	var name_user = $('[name=name_user]');
	var email = $('[name=email]');
	var level = $('[name=level]');
	var user_status = $('[name=user_status]');
	var username = $('[name=username]');
	var password = $('[name=password]');

	$(document).ready(function() {
		$('#form').on("submit", function(e){
			e.preventDefault();
			var url;
			var data = new FormData($('#form')[0]);
			var result = "";
			if (SaveMethod == "Tambah") {
				url = link+'user/InsertData';
			}else{
				url = link+'user/UpdateData';
			}
			if (email_status.val() != 1) {
				$('[name=email]').parent().parent().addClass('has-error');
			}else{
				$('[name=email]').parent().parent().removeClass('has-error');
				result += '1';
			}
			if (username_status.val() != 1 && SaveMethod == "Tambah") {
				$('[name=username]').parent().parent().addClass('has-error');
			}else{
				$('[name=username]').parent().parent().removeClass('has-error');
				result += '2';
			}
			if (password_status.val() != 1 && SaveMethod == "Tambah"){
				$('[name=password]').parent().parent().addClass('has-error');
			}else{
				$('[name=password]').parent().parent().removeClass('has-error');
				result += '3';
			}
			if (result == "123") {
				l.start();
				setTimeout(function(){
					$.ajax({
						url: url,
						data: data,
						type: 'post',
						contentType: false,
						processData: false,
						async: false,
						dataType: 'json',
						success:function(data){
							CekIsToken(data.notif);
							if (data.notif == 1) {
									$('#modal-form').modal('hide');	
									ResetInputAja();
									notify("Success", "Berhasil "+SaveMethod+" Data", "success");
							}else{
								notify("Error", "Gagal "+SaveMethod+" Data", "danger");
							}
						},
						error:function(){
							notify("Error System", "Gagal "+SaveMethod+" Data", "danger");
						}
					});	
					table.ajax.reload(null, false);
					l.stop();
					// loading();
				}, 300);
			}
		});
	});

	function ResetInput() {
		if (SaveMethod == "Update") {
			ResetInputAja();
			l.stop();
			$('#box-kode-user').fadeIn(0);
			$('#box-password').fadeOut(0);
			$('#box-username').fadeOut(0);
			InputStatusHidden(0);
			kode_user.val(kode_user_lama.val());			
		}
	}

	function ResetInputAja() {
		$('input').parent().parent().removeClass('has-error');
		$('select').parent().parent().removeClass('has-error');	
		$('#form')[0].reset();
		$('#email_info').text("*Email tidak boleh kosong");
		$('#username_info').text("*Username 5-25 karakter");
		$('#password_info').text("*Password 5-25 karakter");		
	}

	function InputRequired(status) {
		username.attr('required', status);
		password.attr('required', status);
	}	

	function CekEmail() {
		delay(function(){
			$.ajax({
				url: link+'user/CekEmail',
				type: 'post',
				data: {email: email.val(), email_lama:email_lama.val()},
				dataType: 'json',
				success: function(data){
					CekIsToken(data.notif);
					$('#email_info').text(data.value);
					if (data.value == '*Email tersedia') {
						$('[name=email_status]').val(1);
						$('[name=email]').parent().parent().removeClass('has-error');
					}else{
						$('[name=email_status]').val(0);
						$('[name=email]').parent().parent().addClass('has-error');
					}
				},
				error: function(){
					notify("Error System", "Gagal Cek Email", "error");
				}
			});
		}, 500);
	}

	function CekUsername() {
		delay(function(){
			$.ajax({
				url: link+'user/CekUsername',
				type: 'post',
				data: {username:username.val()},
				dataType:'json',
				success:function(data){
					CekIsToken(data.notif);
					$('#username_info').text(data.value);
					if (data.value == "*Username tersedia") {
						username_status.val(1);
						$('[name=username]').parent().parent().removeClass('has-error');
					}else{
						username_status.val(0);
						$('[name=username]').parent().parent().addClass('has-error');
					}
				},
				error:function(){
					notify("Error System", "Gagal Cek Username", "error");
				}
			});
		}, 500);
	}

	function CekPassword() {
		if (password.val().length < 5 || password.val().length > 25){
			password_status.val(0);
			$('[name=password]').parent().parent().addClass('has-error');
		}else{
			password_status.val(1);
			$('[name=password]').parent().parent().removeClass('has-error');		
		}
	}			

	function InputStatusHidden(status) {
		email_status.val(status);
		username_status.val(status);
		password_status.val(status);
	}	

	function InsertData() {
		loading_start();
		ResetInput();
		SaveMethod = "Tambah";
		$('#modal-form').modal('show');
		$('#modal-form').find('.modal-title').text("Tambah Data");
		$('#box-kode-user').fadeOut(0);
		$('#box-password').fadeIn(0);
		$('#box-username').fadeIn(0);	
		InputRequired(true);	
		loading_stop();
	}

	function EditData(kode){
		SaveMethod = "Update";
		ResetInput();
		InputRequired(false);
		$.ajax({
			url: link+'user/EditData/'+kode,
			type: 'post',
			dataType: 'json',
			success:function(data){
				CekIsToken(data.notif);
				if (data.notif == 1) {
					InputStatusHidden(1);
					$('#modal-form').modal('show');
					$('#modal-form').find('.modal-title').text("Edit Data");
					kode_user_lama.val(data.data.kode_user);
					kode_user.val(data.data.kode_user);
					name_user.val(data.data.name_user);
					email.val(data.data.email);
					username.val(data.data.username);
					password.val(data.data.password);
					level.val(data.data.level);
					user_status.val(data.data.status);
				}else if(data.notif == 0){
					notify("Warning", 'Data tidak ditemukan', "warning");
				}
			},
			error:function(){
				notify('Error System', 'Gagal Edit Data', 'error');
			}
		});
	}

	function DetailData(kode){
		$.ajax({
			url: link+'user/EditData/'+kode,
			type: 'post',
			dataType: 'json',
			success:function(data){
				CekIsToken(data.notif);
				if (data.notif == 1) {
					$('#modal-detail').modal('show');
					$('.kode_user').text(data.data.kode_user);
					$('.name_user').text(data.data.name_user);
					$('.email').text(data.data.email);
					$('.level').text(data.data.level);
					$('.user_status').text(data.data.status);
					$('.created_by').text(data.data.created_by);
					$('.created_date').text(NullDateTime(data.data.created_date));
					$('.last_modified_by').text(data.data.last_modified_by);
					$('.last_modified_date').text(NullDateTime(data.data.last_modified_date));
				}else if(data.notif == 0){
					notify("Warning", 'Data tidak ditemukan', "warning");
				}
			},
			error:function(){
				notify('Error System', 'Gagal Detail Data', 'error');
			}
		});
	}

	function DeleteData(kode) {
		swal({
			title: "Hapus data ?",
			text: "Menghapus data dengan kode user = "+kode+" ?",
			type: "warning",
			showCancelButton: true,
			confirmButtonClass: "btn-warning",
			confirmButtonText: "Ok",
			cancelButtonText: "Cancel",
			closeOnConfirm: false,
			closeOnCancel: true,
			showLoaderOnConfirm: true
		},
		function(isConfirm) {
			if (isConfirm) {
				setTimeout(function(){
					$.ajax({
						url:link+'user/DeleteData/'+kode,
						type:'post',
						async: false,
						dataType:'json',
						success: function(data){
							CekIsToken(data.notif);
							if (data.notif == 1) {
								notify('Success', 'Berhasil Hapus Data', 'success');
							}else if(data.notif == 2){
								notify('Warning', 'Data Tidak Ditemukan', 'warning');
							}else{
								notify('Error', 'Gagal Hapus Data', 'error');
							}
						},
						error: function(){
							notify('Error system', 'Gagal Hapus Data', 'error');
						}
					});
					table.ajax.reload(null, false);	
					swal.close();	
				}, 300);
			}
		});
	}	

	function ResetData() {
		var row ;
		$.ajax({
			url:link+'user/CountTable',
			async:false,
			type:'post',
			dataType:'json',
			success:function(data){
				CekIsToken(data.notif);
				row = data.value;
			},
			error:function(){
				notify('Error System', 'Gagal Count Table', 'error');
			}
		});
		if (row > 0) {
			swal({
				title: "Reset data ?",
				text: "Menghapus semua data user ",
				type: "warning",
				showCancelButton: true,
				confirmButtonClass: "btn-warning",
				confirmButtonText: "Ok",
				cancelButtonText: "Cancel",
				closeOnConfirm: false,
				closeOnCancel: true,
				showLoaderOnConfirm: true
			},
			function(isConfirm) {
				if (isConfirm) {
					setTimeout(function(){
						$.ajax({
							url:link+'user/ResetData',
							type:'post',
							async:false,
							dataType:'json',
							success: function(data){
								CekIsToken(data.notif);
								if (data.notif == 1) {
									notify('Success', 'Berhasil reset data', 'success');
								}else{
									notify('Error', 'Gagal reset data', 'error');
								}
							},
							error: function(){
								notify('Error System', 'Gagal Reset Data', 'error');
							}
						});
						table.ajax.reload(null, false);			
						swal.close();	
					}, 300);
				}
			});
		}else{
			notify('Warning', 'Tidak ada data', 'warning');
		}
	}	
</script>