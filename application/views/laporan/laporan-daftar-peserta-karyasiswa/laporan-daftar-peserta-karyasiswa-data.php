<div class="col-md-12">
	<div class="row">
		<div class="panel panel-default">
			<div class="panel-heading" >
				<span style="font-size: 11pt">Data Karya Siswa
				</span>
			</div>
			<div class="panel-body">
				<form action="" method="post" name="form_report" target="_blank" >
					<div class="col-md-12">
						<div class="row">
							<div class="col-md-6">
								<div class="row">
									<div class="form-group">
										<label>Jenjang Studi</label>
										<select class="form-control select2" name="id_jenjang_studi" style="width: 100%" onchange="tb_laporan.ajax.reload(null, true)">
											<option value="">~ Pilih ~</option>
											<?php foreach ($jenjang_studi->result() as $d): ?>
												<option value="<?php echo $d->id ?>"><?php echo $d->nama_jenjang_studi ?></option>
											<?php endforeach ?>
										</select>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-12">
						<div class="row">
							<div class="col-md-6">
								<div class="row">
									<div class="form-group">
										<label>Dalam Luar Negeri</label>
										<select class="form-control select2" name="dl" style="width: 100%" onchange="tb_laporan.ajax.reload(null, true)">
											<option value="">~ Pilih ~</option>
											<option value="DN">Dalam Negeri</option>
											<option value="LN">Luar Negeri</option>
										</select>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-12">
						<div class="row">
							<div class="col-md-6">
								<div class="row">
									<div class="form-group">
										<label>Status Karya Siswa</label>
										<select class="form-control select2" name="id_keterangan" style="width: 100%" onchange="tb_laporan.ajax.reload(null, true)">
											<option value="">~ Pilih ~</option>
											<?php foreach ($keterangan_karyasiswa->result() as $d): ?>
												<option value="<?php echo $d->id ?>"><?php echo $d->nama_keterangan ?></option>
											<?php endforeach ?>
										</select>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-12">
						<div class="row">
							<div class="form-group">
								<button type="submit" class="btn bg-green btn-flat" name="excel_report" onclick="document.form_report.action='<?php echo URL.'laporan/daftar_peserta_karyasiswa_excel' ?>'">Report Excel</button>
							</div>
						</div>
					</div>
				</form>
				<div class="col-md-12">
					<div class="row">
						<table class="table table-hover table-bordered table-striped" id="tb_laporan" width="100%">
							<thead class="bg-green">
							<tr>
								<td width="5%" class="text-center">No</td>
								<td width="">Nip</td>
								<td width="">Nama</td>
								<td width="">Universitas</td>
								<td width="">Jenjang</td>
								<td width="">Keterangan</td>
							</tr>
							</thead>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function() {
		tb_laporan = $('#tb_laporan').DataTable({
			'lengthMenu':[[10, 25, 50, 100, 200, 350, "All"], [10, 25, 50, 100, 200, 350, "All"]],
			"language": {
				"infoEmpty": "No records available",
				"zeroRecords": "Tidak ada data",
			},
            'processing' : true,
            'serverSide' : true,
			filter:false,
			ajax: {
				url:link+'laporan/fetch_data_daftar_peserta_karyasiswa',
				type:'POST',
				"data": function (d) {
					d.id_jenjang_studi = $('[name=id_jenjang_studi]').val();
					d.dl = $('[name=dl]').val();
					d.id_keterangan = $('[name=id_keterangan]').val();
				},
			},			
			'order':[],
			'responsive':true
		});		
	});
</script>