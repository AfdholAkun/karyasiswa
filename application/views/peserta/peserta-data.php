<style>
	#tables tbody tr td:nth-child(1) {
		text-align: center;
	}
	@media (min-width: 768px){
		.modal-dialog {
		    width: 85%;
		    margin: 30px auto;
		}
	}

	.no-resize {
	    resize: none;
	}
</style>
<div class="col-md-12">
	<div class="row">
		<div class="panel panel-default">
			<div class="panel-heading" >
				<span style="font-size: 11pt">Data Peserta
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
								<td width="">Nip</td>
								<td width="">Nama</td>
								<td width="">Jenis Kelamin</td>
								<td width="">Tempat Tanggal Lahir</td>
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
			<form action="#" id="form">
				<input type="hidden" name="nip_lama">
				<input type="hidden" name="nip_status">
				<div class="panel-body">
					<div class="col-md-6">
						<div class="form-group">
							<label>Nama</label>
							<input type="text" class="form-control" name="nama" required>
						</div>
					</div>					
					<div class="col-md-6">
						<div class="form-group">
							<label>Nip</label>
							<input type="text" class="form-control" name="nip" onkeyup="CekNip()" required>
							<p id="nip_info" class="control-label" style="margin-bottom: -10px;font-size: 7pt;">*Nip tidak boleh kosong</p>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Tempat Lahir</label>
							<input type="text" class="form-control" name="tempat_lahir" required>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Tanggal Lahir</label>
							<input type="date" class="form-control" name="tgl_lahir" required>	
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Jenis Kelamin</label>
							<select class="form-control select2" name="jenis_kelamin" style="width: 100%" required>
								<option value="">~ Pilih ~</option>
								<option value="Laki-Laki">Laki-Laki</option>
								<option value="Perempuan">Perempuan</option>
							</select>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Agama</label>
							<select class="form-control select2" name="id_agama" style="width: 100%" required>
								<option value="">~ Pilih ~</option>
								<?php foreach ($agama->result() as $d): ?>
									<option value="<?php echo $d->id ?>"><?php echo $d->nama_agama ?></option>
								<?php endforeach ?>
							</select>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label>Pangkat</label>
							<select class="form-control select2" name="id_pangkat" style="width: 100%">
								<option value="">~ Pilih ~</option>
								<?php foreach ($pangkat->result() as $d): ?>
									<option value="<?php echo $d->id ?>"><?php echo $d->nama_pangkat ?></option>
								<?php endforeach ?>
							</select>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label>Jabatan Terakhir</label>
							<input type="text" class="form-control" name="jabatan_terakhir">
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label>Instansi Asal</label>
							<select class="form-control select2" name="id_instansi" style="width: 100%">
								<option value="">~ Pilih ~</option>
								<?php foreach ($instansi_asal->result() as $d): ?>
									<option value="<?php echo $d->id ?>"><?php echo $d->nama_instansi ?></option>
								<?php endforeach ?>
							</select>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Alamat Kantor</label>
							<textarea class="form-control no-resize" name="alamat_kantor"></textarea>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Alamat Rumah</label>
							<textarea class="form-control no-resize" name="alamat_rumah"></textarea>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Provinsi</label>
							<select class="form-control select2" name="kode_provinsi" style="width: 100%" required>
								<option value="">~ Pilih ~</option>
								<?php foreach ($provinsi->result() as $d): ?>
									<option value="<?php echo $d->kode ?>"><?php echo $d->nama_provinsi ?></option>
								<?php endforeach ?>
							</select>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Kota / Kabupaten</label>
							<select class="form-control select2" name="kode_kota" style="width: 100%" required>
								<option value="">~ Pilih ~</option>
								<?php foreach ($kota->result() as $d): ?>
									<option value="<?php echo $d->kode ?>"><?php echo $d->nama_kota ?></option>
								<?php endforeach ?>
							</select>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label>Ket. Status Kepegawaian</label>
							<input type="text" class="form-control" name="ket_status_kepegawaian">
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label>Penempatan</label>
							<input type="text" class="form-control" name="penempatan">
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label>Instansi 1 s/d 8</label>
							<input type="text" class="form-control" name="instansi_1_sd_8">
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<div class="col-md-12">
						<button type="button" class="btn btn-default btn-flat" onclick="ResetInputAja();ResetInput();">Reset</button>
						<button type="submit" class="btn bg-green btn-flat ladda-button" data-style="zoom-in" id="btn-simpan" name="save""><span class="ladda-label">Simpan</span></button>
					</div>
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
					<table class="table" width="100%" id="table-detail">
						<tr>
							<th width="18%">Nama</th>
							<th width="2%">:</th>
							<th class="nama"></th>
						</tr>
						<tr>
							<th>Nip</th>
							<th>:</th>
							<th class="nip"></th>
						</tr>
						<tr>
							<th>Tempat Tanggal Lahir</th>
							<th>:</th>
							<th class="tempat_tanggal_lahir"></th>
						</tr>
						<tr>
							<th>Jenis Kelamin</th>
							<th>:</th>
							<th class="jenis_kelamin"></th>
						</tr>
						<tr>
							<th>Agama</th>
							<th>:</th>
							<th class="nama_agama"></th>
						</tr>
						<tr>
							<th>Pangkat</th>
							<th>:</th>
							<th class="nama_pangkat"></th>
						</tr>
						<tr>
							<th>Jabatan Terakhir</th>
							<th>:</th>
							<th class="jabatan_terakhir"></th>
						</tr>
						<tr>
							<th>Instansi Asal</th>
							<th>:</th>
							<th class="nama_instansi"></th>
						</tr>
						<tr>
							<th>Alamat Kantor</th>
							<th>:</th>
							<th class="alamat_kantor"></th>
						</tr>
						<tr>
							<th>Alamat Rumah</th>
							<th>:</th>
							<th class="alamat_rumah"></th>
						</tr>
						<tr>
							<th>Provinsi</th>
							<th>:</th>
							<th class="nama_provinsi"></th>
						</tr>
						<tr>
							<th>Kota / Kabupaten</th>
							<th>:</th>
							<th class="nama_kota"></th>
						</tr>
						<tr>
							<th>Ket Status Kepegawaian</th>
							<th>:</th>
							<th class="ket_status_kepegawaian"></th>
						</tr>
						<tr>
							<th>Penempatan</th>
							<th>:</th>
							<th class="penempatan"></th>
						</tr>
						<tr>
							<th>Instansi 1 sd 8</th>
							<th>:</th>
							<th class="instansi_1_sd_8"></th>
						</tr>
						<tr>
							<th>Dibuat OLeh</th>
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

	var nip = $('[name=nip]');
	var nip_lama = $('[name=nip_lama]');
	var nip_status = $('[name=nip_status]');

	$(document).ready(function() {
		
		$('#form').on("submit", function(e){
			e.preventDefault();
			var url;
			var data = new FormData($('#form')[0]);
			var result = "";
			if (SaveMethod == "Tambah") {
				url = link+'peserta/InsertData';
			}else{
				url = link+'peserta/UpdateData';
			}
			if (nip_status.val() != 1) {
				nip.parent().parent().addClass('has-error');
			}else{
				nip.parent().parent().removeClass('has-error');
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
		$('#nip_info').text("*Nip bersifat unik");		
	}

	function CekNip() {
		delay(function(){
			$.ajax({
				url: link+'peserta/CekNip',
				type: 'post',
				data: {nip:nip.val(), nip_lama:nip_lama.val()},
				dataType:'json',
				success:function(data){
					CekIsToken(data.notif);
					$('#nip_info').text(data.value);
					if (data.value == "*Nip tersedia") {
						nip_status.val(1);
						$('[name=nip]').parent().parent().removeClass('has-error');
					}else{
						nip_status.val(0);
						$('[name=nip]').parent().parent().addClass('has-error');
					}
				},
				error:function(){
					notify("Error System", "Gagal Cek Nip", "error");
				}
			});
		}, 300);
	}

	function InputStatusHidden(status) {
		nip_status.val(status);
	}	

	function InsertData() {
		loading_start();
		ResetInput();
		SaveMethod = "Tambah";
		$('#modal-form').modal('show');
		$('#modal-form').find('.modal-title').text("Tambah Data");
		$('.select2').trigger('change');
		loading_stop();
	}

	function EditData(kode){
		SaveMethod = "Update";
		ResetInput();
		$.ajax({
			url: link+'peserta/EditData/'+kode,
			type: 'post',
			dataType: 'json',
			success:function(data){
				CekIsToken(data.notif);
				if (data.notif == 1) {
					InputStatusHidden(1);
					$('#modal-form').modal('show');
					$('#modal-form').find('.modal-title').text("Edit Data");
					$('[name=nama]').val(data.data.nama);
					nip_lama.val(data.data.nip);
					nip.val(data.data.nip);
					$('[name=tempat_lahir]').val(data.data.tempat_lahir);
					$('[name=tgl_lahir]').val(data.data.tgl_lahir);
					$('[name=jenis_kelamin]').val(data.data.jenis_kelamin);
					$('[name=id_agama]').val(data.data.id_agama);
					$('[name=id_pangkat]').val(data.data.id_pangkat);
					$('[name=jabatan_terakhir]').val(data.data.jabatan_terakhir);
					$('[name=id_instansi]').val(data.data.id_instansi);
					$('[name=alamat_kantor]').val(data.data.alamat_kantor);
					$('[name=alamat_rumah]').val(data.data.alamat_rumah);
					$('[name=kode_provinsi]').val(data.data.kode_provinsi);
					$('[name=kode_kota]').val(data.data.kode_kota);
					$('[name=ket_status_kepegawaian]').val(data.data.ket_status_kepegawaian);
					$('[name=penempatan]').val(data.data.penempatan);
					$('[name=instansi_1_sd_8]').val(data.data.instansi_1_sd_8);
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
			url: link+'peserta/EditData/'+kode,
			type: 'post',
			dataType: 'json',
			success:function(data){
				CekIsToken(data.notif);
				if (data.notif == 1) {
					$('.nama').text(data.data.nama);
					$('.nip').text(data.data.nip);
					$('.tempat_tanggal_lahir').text(data.data.tempat_lahir +", "+ NullDate(data.data.tgl_lahir));
					$('.jenis_kelamin').text(data.data.jenis_kelamin);
					$('.nama_agama').text(data.data.nama_agama);
					$('.nama_pangkat').text(data.data.nama_pangkat);
					$('.jabatan_terakhir').text(data.data.jabatan_terakhir);
					$('.nama_instansi').text(data.data.nama_instansi);
					$('.alamat_kantor').text(data.data.alamat_kantor);
					$('.alamat_rumah').text(data.data.alamat_rumah);
					$('.nama_provinsi').text(data.data.nama_provinsi);
					$('.nama_kota').text(data.data.nama_kota);
					$('.ket_status_kepegawaian').text(data.data.ket_status_kepegawaian);
					$('.penempatan').text(data.data.penempatan);
					$('.instansi_1_sd_8').text(data.data.instansi_1_sd_8);
					$('.created_by').text(data.data.created_by);
					$('.created_date').text(NullDateTime(data.data.created_date));
					$('.last_modified_by').text(data.data.last_modified_by);
					$('.last_modified_date').text(NullDateTime(data.data.last_modified_date));
					$('#modal-detail').modal('show');
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
			text: "Menghapus data dengan nip peserta = "+kode+" ?",
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
						url:link+'peserta/DeleteData/'+kode,
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
			url:link+'peserta/CountTable',
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
				text: "Menghapus semua data peserta ",
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
							url:link+'peserta/ResetData',
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