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
				<span style="font-size: 11pt">Data Karya Siswa Masalah
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
								<td width="">Universitas</td>
								<td width="">Jenjang</td>
								<td width="">Keterangan</td>
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
				<div class="panel-body">
					<input type="hidden" name="id">
					<div class="col-md-12">
						<div class="form-group">
							<label>Nip</label>
							<select class="form-control select2" name="id_karyasiswa_log" style="width: 100%">
								<option value="">~ Pilih ~</option>
								<?php foreach ($karyasiswa_log->result() as $d): ?>
									<option value="<?php echo $d->id ?>"><?php echo $d->nip." ~ ".$d->nama." ~ ".$d->nama_universitas ?></option>
								<?php endforeach ?>
							</select>
						</div>
					</div>
					<div class="col-md-12">
						<div class="form-group">
							<label>Progress</label>
							<input type="text" class="form-control" name="progress">
						</div>
					</div>
					<div class="col-md-12">
						<div class="form-group">
							<label>Masalah Pokok</label>
							<textarea class="form-control no-resize" name="masalah_pokok"></textarea>
						</div>
					</div>
					<?php for ($i=1; $i <= 5; $i++) { ?>
						<div class="col-md-12">
							<div class="form-group">
								<label>Ringkasan Kondisi <?php echo $i ?></label>
								<textarea class="form-control no-resize" name="ringkasan_kondisi_<?php echo $i ?>"></textarea>
							</div>
						</div>
					<?php } ?>
					<?php for ($i=1; $i <= 5; $i++) { ?>
						<div class="col-md-12">
							<div class="form-group">
								<label>Masalah Kondisi <?php echo $i ?></label>
								<textarea class="form-control no-resize" name="masalah_kondisi_<?php echo $i ?>"></textarea>
							</div>
						</div>
					<?php } ?>
					<?php for ($i=1; $i <= 5; $i++) { ?>
						<div class="col-md-12">
							<div class="form-group">
								<label>Upaya Penyelesaian <?php echo $i ?></label>
								<textarea class="form-control no-resize" name="upaya_penyelesaian_<?php echo $i ?>"></textarea>
							</div>
						</div>
					<?php } ?>
					<?php for ($i=1; $i <= 3; $i++) { ?>
						<div class="col-md-12">
							<div class="form-group">
								<label>Saran <?php echo $i ?></label>
								<textarea class="form-control no-resize" name="saran_<?php echo $i ?>"></textarea>
							</div>
						</div>
					<?php } ?>
					<?php for ($i=1; $i <= 3; $i++) { ?>
						<div class="col-md-12">
							<div class="form-group">
								<label>Hasil Rapat <?php echo $i ?></label>
								<textarea class="form-control no-resize" name="hasil_rapat_<?php echo $i ?>"></textarea>
							</div>
						</div>
					<?php } ?>
					<div class="col-md-12">
						<div class="form-group">
							<label>Verifikasi</label>
							<input type="text" class="form-control" name="verifikasi">
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
				<h4 class="modal-title">Detail Karya Siswa Masalah</h4>
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
							<th>Universitas</th>
							<th>:</th>
							<th class="nama_universitas"></th>
						</tr>
						<tr>
							<th>Bidang Studi</th>
							<th>:</th>
							<th class="nama_bidang_studi"></th>
						</tr>
						<tr>
							<th>Jenjang Studi</th>
							<th>:</th>
							<th class="nama_jenjang_studi"></th>
						</tr>
						<tr>
							<th>Negara</th>
							<th>:</th>
							<th class="nama_negara"></th>
						</tr>
						<tr>
							<th>Alamat Universitas</th>
							<th>:</th>
							<th class="alamat_universitas"></th>
						</tr>
						<tr>
							<th>Progress</th>
							<th>:</th>
							<th class="progres"></th>
						</tr>
						<tr>
							<th>Masalah Pokok</th>
							<th>:</th>
							<th class="masalah_pokok"></th>
						</tr>
						<?php for ($i=1; $i < 5; $i++) { ?> 
							<tr>
								<th>Ringkasan Kondisi <?php echo $i ?></th>
								<th>:</th>
								<th class="ringkasan_kondisi_<?php echo $i ?>"></th>
							</tr>
						<?php } ?>
						<?php for ($i=1; $i < 5; $i++) { ?> 
							<tr>
								<th>Masalah Kondisi <?php echo $i ?></th>
								<th>:</th>
								<th class="masalah_kondisi_<?php echo $i ?>"></th>
							</tr>
						<?php } ?>
						<?php for ($i=1; $i < 5; $i++) { ?> 
							<tr>
								<th>Upaya Penyelesaian <?php echo $i ?></th>
								<th>:</th>
								<th class="upaya_penyelesaian_<?php echo $i ?>"></th>
							</tr>
						<?php } ?>
						<?php for ($i=1; $i < 3; $i++) { ?> 
							<tr>
								<th>Saran <?php echo $i ?></th>
								<th>:</th>
								<th class="saran_<?php echo $i ?>"></th>
							</tr>
						<?php } ?>
						<?php for ($i=1; $i < 3; $i++) { ?> 
							<tr>
								<th>Hasil Rapat <?php echo $i ?></th>
								<th>:</th>
								<th class="hasil_rapat_<?php echo $i ?>"></th>
							</tr>
						<?php } ?>
						<tr>
							<th>Verifikasi</th>
							<th>:</th>
							<th class="verifikasi"></th>
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

	var id = $('[name=id]');
	var id_karyasiswa_log = $('[name=id_karyasiswa_log]');

	$(document).ready(function() {
		
		$('#form').on("submit", function(e){
			e.preventDefault();
			var url;
			var data = new FormData($('#form')[0]);
			var result = "";
			if (SaveMethod == "Tambah") {
				url = link+'karyasiswa_masalah/InsertData';
			}else{
				url = link+'karyasiswa_masalah/UpdateData';
			}
			if (result == "") {
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

	function InputStatusHidden(status) {
		// nip_status.val(status);a
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
			url: link+'karyasiswa_masalah/EditData/'+kode,
			type: 'post',
			dataType: 'json',
			success:function(data){
				CekIsToken(data.notif);
				if (data.notif == 1) {
					InputStatusHidden(1);
					id.val(data.data.id);
					id_karyasiswa_log.val(data.data.id_karyasiswa_log);
					$('[name=progress]').val(data.data.progress);
					$('[name=masalah_pokok]').val(data.data.masalah_pokok);
					<?php for ($i=1; $i < 5; $i++) { ?>
						$('[name=ringkasan_kondisi_<?php echo $i ?>]').val(data.data.ringkasan_kondisi_<?php echo $i ?>);
					<?php } ?>
					<?php for ($i=1; $i < 5; $i++) { ?>
						$('[name=masalah_kondisi_<?php echo $i ?>]').val(data.data.masalah_kondisi_<?php echo $i ?>);
					<?php } ?>
					<?php for ($i=1; $i < 5; $i++) { ?>
						$('[name=upaya_penyelesaian_<?php echo $i ?>]').val(data.data.upaya_penyelesaian_<?php echo $i ?>);
					<?php } ?>
					<?php for ($i=1; $i < 3; $i++) { ?>
						$('[name=saran_<?php echo $i ?>]').val(data.data.saran_<?php echo $i ?>);
					<?php } ?>
					<?php for ($i=1; $i < 3; $i++) { ?>
						$('[name=hasil_rapat_<?php echo $i ?>]').val(data.data.hasil_rapat_<?php echo $i ?>);
					<?php } ?>
					$('[name=verifikasi]').val(data.data.verifikasi);
					$('#modal-form').find('.modal-title').text("Edit Data");
					$('#modal-form').modal('show');
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
			url: link+'karyasiswa_masalah/EditData/'+kode,
			type: 'post',
			dataType: 'json',
			success:function(data){
				CekIsToken(data.notif);
				if (data.notif == 1) {
					$('.nama').text(data.data.nama);
					$('.nip').text(data.data.nip);
					$('.nama_universitas').text(data.data.nama_universitas);
					$('.nama_bidang_studi').text(data.data.nama_bidang_studi);
					$('.nama_jenjang_studi').text(data.data.nama_jenjang_studi+"~"+data.data.dl);
					$('.nama_negara').text(data.data.nama_negara);
					$('.alamat_universitas').text(data.data.alamat_universitas);
					$('.progres').text(data.data.progress);
					$('.masalah_pokok').text(data.data.masalah_pokok);
					<?php for ($i=1; $i < 5; $i++) { ?>
						$('.ringkasan_kondisi_<?php echo $i ?>').text(data.data.ringkasan_kondisi_<?php echo $i ?>);
					<?php } ?>
					<?php for ($i=1; $i < 5; $i++) { ?>
						$('.masalah_kondisi_<?php echo $i ?>').text(data.data.masalah_kondisi_<?php echo $i ?>);
					<?php } ?>
					<?php for ($i=1; $i < 5; $i++) { ?>
						$('.upaya_penyelesaian_<?php echo $i ?>').text(data.data.upaya_penyelesaian_<?php echo $i ?>);
					<?php } ?>
					<?php for ($i=1; $i < 3; $i++) { ?>
						$('.saran_<?php echo $i ?>').text(data.data.saran_<?php echo $i ?>);
					<?php } ?>
					<?php for ($i=1; $i < 3; $i++) { ?>
						$('.hasil_rapat_<?php echo $i ?>').text(data.data.hasil_rapat_<?php echo $i ?>);
					<?php } ?>
					$('.verifikasi').text(data.data.verifikasi);						
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
			text: "Menghapus data 1 data ?",
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
						url:link+'karyasiswa_masalah/DeleteData/'+kode,
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
			url:link+'karyasiswa_masalah/CountTable',
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
							url:link+'karyasiswa_masalah/ResetData',
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