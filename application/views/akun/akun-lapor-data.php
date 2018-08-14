<style type="text/css">
	#tables tbody tr td:nth-child(1), #tables tbody tr td:nth-child(5) {
		text-align: center;
	}
.level-text{
    padding: 3px 10px;
    color:white;
}
</style>
<?php $ses_level = $this->session->userdata('ses_sarpras_level'); ?>
<div class="col-md-12">
	<div class="row">
		<div class="slot">
			<?php if ($ses_level != "Admin"): ?>
			<button type="button" onclick="tambah_data()" class="btn btn-primary btn-flat"><i class="fa fa-plus"></i> Tambah Lapor</button>
			<?php endif ?>
			<?php if ($ses_level == "Admin"): ?>				
			<button type="button" onclick="reset_lapor()" class="btn btn-danger btn-flat"><i class="fa fa-trash"></i> Reset Lapor</button>
			<?php endif ?>
		</div>
	</div>
</div>
<div class="col-md-12">
	<div class="row">
		<div class="slot"></div>
	</div>
</div>
<div class="col-md-12">
	<div class="row">
		<div class="slot">
			<table class="table table-hover table-bordered table-striped" id="tables" width="100%">
				<thead>
				<tr>
					<th width="5%" class="text-center">No</th>
					<th width="15%">Tanggal</th>
					<th width="">Id User</th>
					<th width="">Nama User</th>
					<th width="" class="text-center">Level</th>
					<th width="">Status</th>
					<th class="text-center" width="30%">Opsi</th>
				</tr>
				</thead>
				<tfoot>
				<tr>
					<th>no</th>
					<th>tanggal</th>
					<th>id_petugas</th>
					<th>nama_petugas</th>
					<th>level</th>
					<th>status</th>
					<th>opsi</th>
				</tr>
				</tfoot>
			</table>			
		</div>
	</div>
</div>
<div class="modal fade" id="modal-form">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Tambah Lapor</h4>
			</div>
			<form action="#" id="form" class="form-horizontal">
				<div class="modal-body">
					<div class="form-group">
						<label class="control-label col-md-3">Deskripsi</label>
						<div class="col-md-9">
							<textarea name="deskripsi" class="form-control"></textarea>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-3">Foto</label>
						<div class="col-md-9">
							<input type="file" class="form-control" name="file">
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default btn-flat" data-dismiss="modal">Close</button>
					<button type="reset" class="btn btn-danger btn-flat">Reset</button>
					<button type="submit" class="btn btn-primary btn-flat">Simpan</button>
				</div>
			</form>
		</div>
	</div>
</div>
<div class="modal fade" id="modal-detail">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Detail Lapor Bug</h4>
			</div>
			<div class="modal-body">
				<div class="table-responsive">
					<table class="table" width="100%">
						<tr>
							<th width="25%">Tanggal Lapor<th>
							<th width="2%">:</th>
							<th class="tgl_lapor"></th>
						</tr>
						<tr>
							<th>ID User<th>
							<th>:</th>
							<th class="id_user"></th>
						</tr>
						<tr>
							<th>Nama User<th>
							<th>:</th>
							<th class="nama_user"></th>
						</tr>
						<tr>
							<th>Level<th>
							<th>:</th>
							<th class="level"></th>
						</tr>
						<tr>
							<th>Status<th>
							<th>:</th>
							<th class="status"></th>
						</tr>
						<tr>
							<th>Deskripsi<th>
							<th>:</th>
							<th class="deskripsi"></th>
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

<div class="modal fade" id="modal-foto">
	<div class="modal-dialog">
			<img src="" id="foto-lapor" class="img-thumbnail img-responsive center-block modal-content">
	</div>
</div>
<script type="text/javascript">

	$(document).ready(function() {
		$('#form').on('submit', function(e){
			e.preventDefault();
			swal({
			title: "Simpan data ?",
			text: "Yakin simpan data ?",
			type: "success",
			showCancelButton: true,
			confirmButtonClass: "btn-warning",
			confirmButtonText: "Ok",
			cancelButtonText: "Cancel",
			closeOnConfirm: true,
			closeOnCancel: true
			},						
			function (isConfirm) {
				if (isConfirm) {			
					$.ajax({
						url: '<?php echo site_url('akun/simpan_lapor') ?>',
						type: 'post',
						dataType: 'json',
						data: new FormData($('#form')[0]),
						contentType: false,
						processData: false,
						async: false,
						success:function(data){
							if (data.notif == 1) {
								$('#modal-form').modal('hide');
								table.ajax.reload(null, false);
								notify('Success', 'Berhasil simpan data', 'success');
							}else{
								notify('Error', 'Gagal simpan data', 'danger');
							}				
						},
						error:function(){
							alert('gagal simpan lapor');
						}
					});
				}
			});				
		});
	});

	function tambah_data() {
		$('#modal-form').modal('show');
	}

	function detail_data(kode) {
		$.ajax({
			url: '<?php echo site_url('akun/detail_lapor/') ?>'+kode,
			dataType: 'json',
			success:function(data){
				$('#modal-detail').modal('show');
				$('.tgl_lapor').text(data.tgl_lapor);
				$('.id_user').text(data.id_user);
				$('.nama_user').text(data.nama_user);
				$('.level').text(data.level);
				$('.status').text(data.status);
				$('.deskripsi').text(data.deskripsi);
				table.ajax.reload(null, false);
			},
			error:function(){
				alert("gagal detail data");
			}
		});
	}

	function hapus_data(kode) {
		swal({
		title: "Hapus data ?",
		type: "warning",
		showCancelButton: true,
		confirmButtonClass: "btn-warning",
		confirmButtonText: "Ok",
		cancelButtonText: "Cancel",
		closeOnConfirm: true,
		closeOnCancel: true		
		},						
		function (isConfirm) {
			if (isConfirm) {			
				$.ajax({
					url:'<?php echo site_url('akun/hapus_lapor/') ?>'+kode,
					dataType: 'json',
					success: function(data){
						if(data.notif == 1){
							table.ajax.reload(null, false);
							notify('Success', 'Berhasil hapus data', 'success');
						}else{
							notify('Error', 'Gagal hapus data', 'danger');
						}
					},
					error:function(){
						alert('gagal hapus data');
					}
				});
			}
		});
	}

	function lihat_foto(kode) {
		$.ajax({
			url: '<?php echo site_url('akun/detail_lapor/') ?>'+kode,
			dataType: 'json',
			success:function(data){
				$('#modal-foto').modal('show');
				$('#foto-lapor').attr('src', '<?php echo site_url('assets/upload/foto-lapor/')?>'+data.foto);
				table.ajax.reload(null, false);
			},
			error:function(){
				alert("gagal detail data");
			}
		});		
	}

	function perbaiki(kode) {
		swal({
		title: "Sudah diperbaiki ?",
		type: "success",
		showCancelButton: true,
		confirmButtonClass: "btn-success",
		confirmButtonText: "Ok",
		cancelButtonText: "Cancel",
		closeOnConfirm: true,
		closeOnCancel: true		
		},						
		function (isConfirm) {
			if (isConfirm) {			
				$.ajax({
					url:'<?php echo site_url('akun/perbaiki/') ?>'+kode,
					dataType: 'json',
					success: function(data){
						if(data.notif == 1){
							table.ajax.reload(null, false);
							notify('Success', 'Berhasil perbaiki data', 'success');
						}else{
							notify('Error', 'Gagal perbaiki data', 'danger');
						}
					},
					error:function(){
						alert('gagal perbaiki data');
					}
				});
			}
		});		
	}

	function reset_lapor() {
		var row ;
		$.ajax({
			url:'<?php echo site_url('akun/count_table')?>',
			async:false,
			type:'post',
			success:function(data){
				row = data;
			},
			error:function(){
				alert('error count table');
			}
		});
		if (row > 0) {		
			swal({
			title: "Reset Lapor ?",
			text: "Menghapus semua lapor bug !",
			type: "warning",
			showCancelButton: true,
			confirmButtonClass: "btn-warning",
			confirmButtonText: "Ok",
			cancelButtonText: "Cancel",
			closeOnConfirm: true,
			closeOnCancel: true		
			},						
			function (isConfirm) {
				if (isConfirm) {			
					$.ajax({
						url:'<?php echo site_url('akun/reset_lapor') ?>',
						dataType: 'json',
						success: function(data){
							if(data.notif == 1){
								table.ajax.reload(null, false);
								notify('Success', 'Berhasil reset data', 'success');
							}else{
								notify('Error', 'Gagal reset data', 'danger');
							}
						},
						error:function(){
							alert('gagal perbaiki data');
						}
					});
				}
			});			
		}else{
			notify('Warning', 'Tidak ada data', 'warning');
		}
	}
</script>