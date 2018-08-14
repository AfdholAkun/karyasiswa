<style>
	#tables tbody tr td:nth-child(1) {
		text-align: center;
	}
</style>
<div class="col-md-12">
	<div class="row">
		<div class="panel panel-default">
			<div class="panel-heading" >
				<span style="font-size: 11pt">Data Universitas
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
								<td width="">Universitas</td>
								<td width="">Dalam Luar Negeri</td>
								<td class="text-center" width="30%">Opsi</td>
							</tr>
							</thead>
							</tfoot>
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
					<input type="hidden" name="id">
					<input type="hidden" name="nama_universitas_lama">
					<input type="hidden" name="nama_universitas_status" value="0">
					<div class="form-group">
						<label class="control-label col-md-4">Universitas</label>
						<div class="col-md-8">
							<input type="text" name="nama_universitas" class="form-control" required maxlength="100" onkeyup="CekNamaUniversitas()">
							<p id="nama_universitas_info" class="control-label" style="margin-bottom: -10px;font-size: 7pt;">*Universitas tidak boleh kosong</p>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-4">Dalam Luar Negeri</label>
						<div class="col-md-8">
							<select class="form-control select2" name="dl" style="width: 100%" required>
								<option value="">~ Pilih ~</option>
								<option value="DN">DN (Dalam Negeri)</option>
								<option value="LN">LN (Luar Negeri)</option>
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
				<h4 class="modal-title">Detail Universitas</h4>
			</div>
			<div class="modal-body">
				<div class="table-responsive">
					<table class="table" width="100%">
						<tr>
							<th width="29%">Universitas</th>
							<th width="2%">:</th>
							<th class="nama_universitas"></th>
						</tr>
						<tr>
							<th>Universitas</th>
							<th>:</th>
							<th class="dl"></th>
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

	var nama_universitas_lama = $('[name=nama_universitas_lama]');
	var nama_universitas_status = $('[name=nama_universitas_status]');
	var dl = $('[name=dl]');

	var id = $('[name=id]');
	var nama_universitas = $('[name=nama_universitas]');	
	$(document).ready(function() {
		$('#form').on("submit", function(e){
			e.preventDefault();
			var url;
			var data = new FormData($('#form')[0]);
			var result = "";
			if (SaveMethod == "Tambah") {
				url = link+'universitas/InsertData';
			}else{
				url = link+'universitas/UpdateData';
			}
			if (nama_universitas_status.val() != 1) {
				$('[name=nama_universitas]').parent().parent().addClass('has-error');
			}else{
				$('[name=nama_universitas]').parent().parent().removeClass('has-error');
				result += '1';
			}
			if (result == "1") {
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
			InputStatusHidden(0);		
		}
	}

	function ResetInputAja() {
		$('input').parent().parent().removeClass('has-error');
		$('select').parent().parent().removeClass('has-error');	
		$('#form')[0].reset();
		$('#nama_universitas_info').text("*Universitas tidak boleh kosong");		
	}


	function CekNamaUniversitas() {
		delay(function(){
			$.ajax({
				url: link+'universitas/CekNamaUniversitas',
				type: 'post',
				data: {nama_universitas: nama_universitas.val(), nama_universitas_lama:nama_universitas_lama.val()},
				dataType: 'json',
				success: function(data){
					CekIsToken(data.notif);
					$('#nama_universitas_info').text(data.value);
					if (data.value == '*Universitas tersedia') {
						$('[name=nama_universitas_status]').val(1);
						$('[name=nama_universitas]').parent().parent().removeClass('has-error');
					}else{
						$('[name=nama_universitas_status]').val(0);
						$('[name=nama_universitas]').parent().parent().addClass('has-error');
					}
				},
				error: function(){
					notify("Error System", "Gagal Cek Nama Universitas", "error");
				}
			});
		}, 500);
	}


	function InputStatusHidden(status) {
		nama_universitas_status.val(status);
	}	

	function InsertData() {
		loading_start();
		ResetInput();
		SaveMethod = "Tambah";
		$('#modal-form').modal('show');
		$('#modal-form').find('.modal-title').text("Tambah Data");
		loading_stop();
	}

	function EditData(kode){
		SaveMethod = "Update";
		ResetInput();
		$.ajax({
			url: link+'universitas/EditData/'+kode,
			type: 'post',
			dataType: 'json',
			success:function(data){
				CekIsToken(data.notif);
				if (data.notif == 1) {
					InputStatusHidden(1);
					$('#modal-form').modal('show');
					$('#modal-form').find('.modal-title').text("Edit Data");
					id.val(data.data.id);
					nama_universitas.val(data.data.nama_universitas);
					nama_universitas_lama.val(data.data.nama_universitas);
					dl.val(data.data.dl);
					$('.select2').trigger('change');
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
			url: link+'universitas/EditData/'+kode,
			type: 'post',
			dataType: 'json',
			success:function(data){
				CekIsToken(data.notif);
				if (data.notif == 1) {
					$('#modal-detail').modal('show');
					$('.nama_universitas').text(data.data.nama_universitas);
					$('.dl').text(data.data.dl);
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
			text: "Menghapus 1 data universitas",
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
						url:link+'universitas/DeleteData/'+kode,
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
			url:link+'universitas/CountTable',
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
		if (row > 1) {
			swal({
				title: "Reset data ?",
				text: "Menghapus semua data universitas ",
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
							url:link+'universitas/ResetData',
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