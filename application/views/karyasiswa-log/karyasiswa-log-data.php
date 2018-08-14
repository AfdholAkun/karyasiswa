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
				<span style="font-size: 11pt">Data Karya Siswa
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
							<select class="form-control select2" name="nip" style="width: 100%">
								<option value="">~ Pilih ~</option>
								<?php foreach ($peserta->result() as $d): ?>
									<option value="<?php echo $d->nip ?>"><?php echo $d->nip." ~ ".$d->nama ?></option>
								<?php endforeach ?>
							</select>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label>Universitas</label>
							<select class="form-control select2" name="id_universitas" style="width: 100%" required>
								<option value="">~ Pilih ~</option>
								<?php foreach ($universitas->result() as $d): ?>
								<option value="<?php echo $d->id ?>"><?php echo $d->nama_universitas."~".$d->dl ?></option>
								<?php endforeach ?>
							</select>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label>Bidang Studi</label>
							<select class="form-control select2" name="id_bidang_studi" style="width: 100%" required>
								<option value="">~ Pilih ~</option>
								<?php foreach ($bidang_studi->result() as $d): ?>
									<option value="<?php echo $d->id ?>"><?php echo $d->nama_bidang_studi ?></option>
								<?php endforeach ?>
							</select>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label>Jenjang Studi</label>
							<select class="form-control select2" name="id_jenjang_studi" style="width: 100%" required>
								<option value="">~ Pilih ~</option>
								<?php foreach ($jenjang_studi->result() as $d): ?>
									<option value="<?php echo $d->id ?>"><?php echo $d->nama_jenjang_studi ?></option>
								<?php endforeach ?>
							</select>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Negara</label>
							<select class="form-control select2" name="kode_negara" style="width: 100%" required>
								<option value="">~ Pilih ~</option>
								<?php foreach ($negara->result() as $d): ?>
									<option value="<?php echo $d->kode ?>"><?php echo $d->nama_negara ?></option>
								<?php endforeach ?>
							</select>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>Alamat Universitas</label>
							<input type="text" class="form-control" name="alamat_universitas">
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<label>Lama Studi (Tahun)</label>
							<input type="text" class="form-control" name="lama_studi">
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<label>NO SKTB</label>
							<input type="text" class="form-control" name="no_sktb">
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<label>Mulai Pendidikan</label>
							<input type="date" class="form-control" name="mulai_pendidikan">
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<label>Rencana Selesai Pendidikan</label>
							<input type="date" class="form-control" name="rencana_selesai_pendidikan">
						</div>
					</div>
					<div class="col-md-12">
						<div class="form-group">
							<label>Sponsor / Sumber Dana</label>
							<input type="text" class="form-control" name="sumber_dana">
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label>NO.SKTB Perpanjangan I</label>
							<input type="text" class="form-control" name="no_sktb_perpanjangan_1">
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label>Mulai Perpanjangan I</label>
							<input type="date" class="form-control" name="mulai_perpanjangan_1">
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label>Selesai Perpanjangan I</label>
							<input type="date" class="form-control" name="selesai_perpanjangan_1">
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label>NO.SKTB Perpanjangan II</label>
							<input type="text" class="form-control" name="no_sktb_perpanjangan_2">
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label>Mulai Perpanjangan II</label>
							<input type="date" class="form-control" name="mulai_perpanjangan_2">
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label>Selesai Perpanjangan II</label>
							<input type="date" class="form-control" name="selesai_perpanjangan_2">
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label>Tahun Selesai</label>
							<select class="form-control select2" name="tahun_selesai" style="width: 100%">
								<option value="">~ Pilih ~</option>
								<?php $tahun = date('Y')+50; for ($i=$tahun; $i > 1900 ; $i--) { ?>
									<option value="<?php echo $i ?>"><?php echo $i ?></option>
								<?php } ?>
							</select>
							<!-- <input type="text" class="form-control" name="tahun_selesai" required> -->
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label>Keterangan</label>
							<select class="form-control select2" name="id_keterangan" style="width: 100%" required>
								<option value="">~ Pilih ~</option>
								<?php foreach ($keterangan_karyasiswa->result() as $d): ?>
									<option value="<?php echo $d->id ?>"><?php echo $d->nama_keterangan ?></option>
								<?php endforeach ?>
							</select>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label>Keterangan 2</label>
							<input type="text" class="form-control" name="ket_2">
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label>Presentasi</label>
							<input type="date" class="form-control" name="presentasi">
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label>Lokasi Persentasi</label>
							<input type="text" class="form-control" name="lokasi_presentasi">
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label>Laporan Studi</label>
							<input type="text" class="form-control" name="laporan_studi">
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<label>SK SETJEN</label>
							<input type="text" class="form-control" name="sk_setjen">
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<label>SK MENTERI</label>
							<input type="text" class="form-control" name="sk_menteri">
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<label>Jumlah Thesis</label>
							<input type="text" class="form-control" name="jml_thesis">
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<label>Ket Thesis</label>
							<input type="text" class="form-control" name="ket_thesis">
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
				<h4 class="modal-title">Detail Karya Siswa</h4>
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
							<th>Instansi 1 sd 8</th>
							<th>:</th>
							<th class="instansi_1_sd_8"></th>
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
							<th>Lama Studi</th>
							<th>:</th>
							<th class="lama_studi"></th>
						</tr>
						<tr>
							<th>No.SKTB</th>
							<th>:</th>
							<th class="no_sktb"></th>
						</tr>
						<tr>
							<th>Mulai Pendidikan</th>
							<th>:</th>
							<th class="mulai_pendidikan"></th>
						</tr>
						<tr>
							<th>Rencana Selesai Pendidikan</th>
							<th>:</th>
							<th class="rencana_selesai_pendidikan"></th>
						</tr>
						<tr>
							<th>Sumber Dana</th>
							<th>:</th>
							<th class="sumber_dana"></th>
						</tr>
						<tr>
							<th>No.SKTB Perpanjangan I</th>
							<th>:</th>
							<th class="no_sktb_perpanjangan_1"></th>
						</tr>
						<tr>
							<th>Mulai Perpanjangan I</th>
							<th>:</th>
							<th class="mulai_perpanjangan_1"></th>
						</tr>
						<tr>
							<th>Selesai Perpanjangan I</th>
							<th>:</th>
							<th class="selesai_perpanjangan_1"></th>
						</tr>
						<tr>
							<th>No.SKTB Perpanjangan II</th>
							<th>:</th>
							<th class="no_sktb_perpanjangan_2"></th>
						</tr>
						<tr>
							<th>Mulai Perpanjangan II</th>
							<th>:</th>
							<th class="mulai_perpanjangan_2"></th>
						</tr>
						<tr>
							<th>Selesai Perpanjangan II</th>
							<th>:</th>
							<th class="selesai_perpanjangan_2"></th>
						</tr>
						<tr>
							<th>Tahun Selesai</th>
							<th>:</th>
							<th class="tahun_selesai"></th>
						</tr>
						<tr>
							<th>Keterangan</th>
							<th>:</th>
							<th class="nama_keterangan"></th>
						</tr>
						<tr>
							<th>Ket 2</th>
							<th>:</th>
							<th class="ket_2"></th>
						</tr>
						<tr>
							<th>Presentasi</th>
							<th>:</th>
							<th class="presentasi"></th>
						</tr>
						<tr>
							<th>Lokasi Presentasi</th>
							<th>:</th>
							<th class="lokasi_presentasi"></th>
						</tr>
						<tr>
							<th>Laporan Studi</th>
							<th>:</th>
							<th class="laporan_studi"></th>
						</tr>
						<tr>
							<th>SK SETJEN</th>
							<th>:</th>
							<th class="sk_setjen"></th>
						</tr>
						<tr>
							<th>SK MENTERI</th>
							<th>:</th>
							<th class="sk_menteri"></th>
						</tr>
						<tr>
							<th>Jumlah Thesis</th>
							<th>:</th>
							<th class="jml_thesis"></th>
						</tr>
						<tr>
							<th>Ket Thesis</th>
							<th>:</th>
							<th class="ket_thesis"></th>
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
	var nip = $('[name=nip]');

	$(document).ready(function() {
		$('#form').on("submit", function(e){
			e.preventDefault();
			var url;
			var data = new FormData($('#form')[0]);
			var result = "";
			if (SaveMethod == "Tambah") {
				url = link+'karyasiswa_log/InsertData';
			}else{
				url = link+'karyasiswa_log/UpdateData';
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
			url: link+'karyasiswa_log/EditData/'+kode,
			type: 'post',
			dataType: 'json',
			success:function(data){
				CekIsToken(data.notif);
				if (data.notif == 1) {
					InputStatusHidden(1);
					id.val(data.data.id);
					nip.val(data.data.nip);
					$('[name=dl]').val(data.data.dl);
					$('[name=id_universitas]').val(data.data.id_universitas);
					$('[name=id_bidang_studi]').val(data.data.id_bidang_studi);
					$('[name=id_jenjang_studi]').val(data.data.id_jenjang_studi);
					$('[name=kode_negara]').val(data.data.kode_negara);
					$('[name=alamat_universitas]').val(data.data.alamat_universitas);
					$('[name=lama_studi]').val(data.data.lama_studi);
					$('[name=no_sktb]').val(data.data.no_sktb);
					$('[name=mulai_pendidikan]').val(data.data.mulai_pendidikan);
					$('[name=rencana_selesai_pendidikan]').val(data.data.rencana_selesai_pendidikan);
					$('[name=sumber_dana]').val(data.data.sumber_dana);
					$('[name=no_sktb_perpanjangan_1]').val(data.data.no_sktb_perpanjangan_1);
					$('[name=mulai_perpanjangan_1]').val(data.data.mulai_perpanjangan_1);
					$('[name=selesai_perpanjangan_1]').val(data.data.selesai_perpanjangan_1);
					$('[name=no_sktb_perpanjangan_2]').val(data.data.no_sktb_perpanjangan_2);
					$('[name=mulai_perpanjangan_2]').val(data.data.mulai_perpanjangan_2);
					$('[name=selesai_perpanjangan_2]').val(data.data.selesai_perpanjangan_2);
					$('[name=tahun_selesai]').val(data.data.tahun_selesai);
					$('[name=id_keterangan]').val(data.data.id_keterangan);
					$('[name=ket_2]').val(data.data.ket_2);
					$('[name=presentasi]').val(data.data.presentasi);
					$('[name=lokasi_presentasi]').val(data.data.lokasi_presentasi);
					$('[name=laporan_studi]').val(data.data.laporan_studi);
					$('[name=sk_setjen]').val(data.data.sk_setjen);
					$('[name=sk_menteri]').val(data.data.sk_menteri);
					$('[name=jml_thesis]').val(data.data.jml_thesis);
					$('[name=ket_thesis]').val(data.data.ket_thesis);
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
			url: link+'karyasiswa_log/EditData/'+kode,
			type: 'post',
			dataType: 'json',
			success:function(data){
				CekIsToken(data.notif);
				if (data.notif == 1) {
					$('.nama').text(data.data.nama);
					$('.nip').text(data.data.nip);
					$('.tempat_tanggal_lahir').text(data.peserta.tempat_lahir +", "+ NullDate(data.peserta.tgl_lahir));
					$('.jenis_kelamin').text(data.peserta.jenis_kelamin);
					$('.nama_agama').text(data.peserta.nama_agama);
					$('.nama_pangkat').text(data.peserta.nama_pangkat);
					$('.jabatan_terakhir').text(data.peserta.jabatan_terakhir);
					$('.nama_instansi').text(data.peserta.nama_instansi);
					$('.alamat_kantor').text(data.peserta.alamat_kantor);
					$('.alamat_rumah').text(data.peserta.alamat_rumah);
					$('.nama_provinsi').text(data.peserta.nama_provinsi);
					$('.nama_kota').text(data.peserta.nama_kota);
					$('.ket_status_kepegawaian').text(data.peserta.ket_status_kepegawaian);
					$('.instansi_1_sd_8').text(data.peserta.instansi_1_sd_8);
					$('.nama_universitas').text(data.data.nama_universitas);
					$('.nama_bidang_studi').text(data.data.nama_bidang_studi);
					$('.nama_jenjang_studi').text(data.data.nama_jenjang_studi+"~"+data.data.dl);
					$('.nama_negara').text(data.data.nama_negara);
					$('.alamat_universitas').text(data.data.alamat_universitas);
					$('.lama_studi').text(data.data.lama_studi);
					$('.no_sktb').text(data.data.no_sktb);
					$('.mulai_pendidikan').text(NullDate(data.data.mulai_pendidikan));
					$('.rencana_selesai_pendidikan').text(NullDate(data.data.rencana_selesai_pendidikan));
					$('.sumber_dana').text(data.data.sumber_dana);
					$('.no_sktb_perpanjangan_1').text(data.data.no_sktb_perpanjangan_1);
					$('.mulai_perpanjangan_1').text(NullDate(data.data.mulai_perpanjangan_1));
					$('.selesai_perpanjangan_1').text(NullDate(data.data.selesai_perpanjangan_1));
					$('.no_sktb_perpanjangan_2').text(data.data.no_sktb_perpanjangan_2);
					$('.mulai_perpanjangan_2').text(NullDate(data.data.mulai_perpanjangan_2));
					$('.selesai_perpanjangan_2').text(NullDate(data.data.selesai_perpanjangan_2));
					$('.tahun_selesai').text(data.data.tahun_selesai);
					$('.nama_keterangan').text(data.data.nama_keterangan);
					$('.ket_2').text(data.data.ket_2);
					$('.presentasi').text(NullDate(data.data.presentasi));
					$('.lokasi_presentasi').text(data.data.lokasi_presentasi);
					$('.laporan_studi').text(data.data.laporan_studi);
					$('.sk_setjen').text(data.data.sk_setjen);
					$('.sk_menteri').text(data.data.sk_menteri);
					$('.jml_thesis').text(data.data.jml_thesis);
					$('.ket_thesis').text(data.data.ket_thesis);
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
						url:link+'karyasiswa_log/DeleteData/'+kode,
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
			url:link+'karyasiswa_log/CountTable',
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
							url:link+'karyasiswa_log/ResetData',
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