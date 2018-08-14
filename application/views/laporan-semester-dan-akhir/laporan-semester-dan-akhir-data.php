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
				<span style="font-size: 11pt">Data Laporan Semester dan Akhir
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
								<td width="">Semester</td>
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
					<input type="hidden" name="file_karyasiswa_lama">
					<input type="hidden" name="file_sktb_lama">
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
							<label>Semester</label>
							<select class="form-control select2" name="id_semester" style="width: 100%">
								<option value="">~ Pilih ~</option>
								<?php foreach ($semester->result() as $d): ?>
									<option value="<?php echo $d->id_semester ?>"><?php echo $d->nm_smt ?></option>
								<?php endforeach ?>
							</select>
						</div>
					</div>
					<div class="col-md-12">
						<div class="form-group">
							<label>Keterangan</label>
							<textarea class="form-control no-resize" name="keterangan"></textarea>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Progress</label>
							<input type="text" class="form-control" name="progress">
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Tahun Lulus</label>
							<input type="text" class="form-control" name="tahun_lulus">
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>SKS</label>
							<input type="text" class="form-control" name="sks">
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>IP</label>
							<input type="text" class="form-control" name="ip">
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>FILE Karyasiswa</label>
							<input type="file" name="file_karyasiswa" class="form-control">
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>FILE SKTB</label>
							<input type="file" name="file_sktb" class="form-control">
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
							<th>Semester</th>
							<th>:</th>
							<th class="nm_smt"></th>
						</tr>	
						<tr>
							<th>Progress</th>
							<th>:</th>
							<th class="progres"></th>
						</tr>
						<tr>
							<th>Tahun Lulus</th>
							<th>:</th>
							<th class="tahun_lulus"></th>
						</tr>			
						<tr>
							<th>Keterangan</th>
							<th>:</th>
							<th class="keterangan"></th>
						</tr>			
						<tr>
							<th>SKS</th>
							<th>:</th>
							<th class="sks"></th>
						</tr>			
						<tr>
							<th>IP</th>
							<th>:</th>
							<th class="ip"></th>
						</tr>			
						<tr>
							<th>File Karyasiswa</th>
							<th>:</th>
							<th class="file_karyasiswa"></th>
						</tr>				
						<tr>
							<th>File SKTB</th>
							<th>:</th>
							<th class="file_sktb"></th>
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
				url = link+'laporan_semester_dan_akhir/InsertData';
			}else{
				url = link+'laporan_semester_dan_akhir/UpdateData';
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
			url: link+'laporan_semester_dan_akhir/EditData/'+kode,
			type: 'post',
			dataType: 'json',
			success:function(data){
				CekIsToken(data.notif);
				if (data.notif == 1) {
					InputStatusHidden(1);
					id.val(data.data.id);
					id_karyasiswa_log.val(data.data.id_karyasiswa_log);
					$('[name=id_semester]').val(data.data.id_semester);
					$('[name=keterangan]').val(data.data.keterangan);
					$('[name=progress]').val(data.data.progress);
					$('[name=tahun_lulus]').val(data.data.tahun_lulus);
					$('[name=sks]').val(data.data.sks);
					$('[name=ip]').val(data.data.ip);
					$('[name=file_karyasiswa_lama]').val(data.data.file_karyasiswa);
					$('[name=file_sktb_lama]').val(data.data.file_sktb);
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
			url: link+'laporan_semester_dan_akhir/EditData/'+kode,
			type: 'post',
			dataType: 'json',
			success:function(data){
				CekIsToken(data.notif);
				if (data.notif == 1) {
					$('.nama').text(data.data.nama);
					$('.nip').text(data.data.nip);
					$('.nama_universitas').text(data.data.nama_universitas);
					$('.nama_bidang_studi').text(data.data.nama_bidang_studi);
					$('.nama_jenjang_studi').text(data.data.nama_jenjang_studi+'~'+data.data.dl);
					$('.nama_negara').text(data.data.nama_negara);
					$('.alamat_universitas').text(data.data.alamat_universitas);
					$('.nm_smt').text(data.data.nm_smt);						
					$('.progres').text(data.data.progress);						
					$('.tahun_lulus').text(data.data.tahun_lulus);						
					$('.keterangan').text(data.data.keterangan);						
					$('.sks').text(data.data.sks);						
					$('.ip').text(data.data.ip);	
					if (data.data.file_karyasiswa !== "") {
						var file_karyasiswa_link = "<a href='"+link+"assets/upload/file-karyasiswa/"+data.data.file_karyasiswa+"' target='_blank'>Lihat disini</a>"; 
					}else{
						var file_karyasiswa_link = "<p>Tidak ada file</p>";
					}
					$('.file_karyasiswa').html(file_karyasiswa_link);
					$('.file_sktb').html("<a href='"+link+"assets/upload/file-sktb/"+data.data.file_sktb+"' target='_blank'>Lihat disini</a>");
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
						url:link+'laporan_semester_dan_akhir/DeleteData/'+kode,
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
			url:link+'laporan_semester_dan_akhir/CountTable',
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
							url:link+'laporan_semester_dan_akhir/ResetData',
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