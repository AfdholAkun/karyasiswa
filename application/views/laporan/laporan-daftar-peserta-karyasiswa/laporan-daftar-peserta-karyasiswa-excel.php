<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
</head>
<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=laporan-daftar-peserta-karyasiswa.xls");
header("Pragma: no-cache");
header("Expires: 0");
?>

<table border="1" cellpadding="0">
	<tr>
		<th>No</th>
		<th>Nip</th>
		<th>Nama</th>
		<th>Bidang Studi</th>
		<th>Universitas</th>
		<th>Jenjang Studi</th>
		<th>Negara</th>
		<th>Alamat Universitas</th>
		<th>Lama Studi</th>
		<th>No.SKTB</th>
		<th>Mulai Pendidikan</th>
		<th>Rencana Selesai Pendidikan</th>
		<th>Sumber Dana</th>
		<th>No.SKTB Perpanjangan 1</th>
		<th>Mulai Perpanjangan 1</th>
		<th>Selesai Perpanjangan 1</th>
		<th>No.SKTB Perpanjangan 2</th>
		<th>Mulai Perpanjangan 2</th>
		<th>Selesai Perpanjangan 2</th>
		<th>Tahun Selesai</th>
		<th>Keterangan</th>
		<th>Presentasi</th>
		<th>Lokasi Presentasi</th>
		<th>Laporan Studi</th>
		<th>SK SETJEN</th>
		<th>SK MENTERI</th>
		<th>Ket Thesis</th>
	</tr>
	<?php $no = 0; foreach ($data_result->result() as $d): $no++;?>
	<tr>
		<td><?php echo $no; ?></td>
		<td><?php echo $d->nip; ?></td>
		<td><?php echo $d->nama; ?></td>
		<td><?php echo $d->nama_bidang_studi; ?></td>
		<td><?php echo $this->model->select_data($d->nama_universitas); ?></td>
		<td><?php echo $d->nama_jenjang_studi." ~ ".$d->dl; ?></td>
		<td><?php echo $d->nama_negara; ?></td>
		<td><?php echo $d->alamat_universitas; ?></td>
		<td><?php echo $d->lama_studi; ?></td>
		<td><?php echo $d->no_sktb; ?></td>
		<td><?php echo $this->model->NullDate($d->mulai_pendidikan); ?></td>
		<td><?php echo $this->model->NullDate($d->rencana_selesai_pendidikan); ?></td>
		<td><?php echo $d->sumber_dana; ?></td>
		<td><?php echo $d->no_sktb_perpanjangan_1; ?></td>
		<td><?php echo $this->model->NullDate($d->mulai_perpanjangan_1); ?></td>
		<td><?php echo $this->model->NullDate($d->selesai_perpanjangan_1); ?></td>
		<td><?php echo $d->no_sktb_perpanjangan_2; ?></td>
		<td><?php echo $this->model->NullDate($d->mulai_perpanjangan_2); ?></td>
		<td><?php echo $this->model->NullDate($d->selesai_perpanjangan_2); ?></td>
		<td><?php echo $d->tahun_selesai; ?></td>
		<td><?php echo $d->nama_keterangan; ?></td>
		<td><?php echo $this->model->NullDate($d->presentasi); ?></td>
		<td><?php echo $d->lokasi_presentasi; ?></td>
		<td><?php echo $d->laporan_studi; ?></td>
		<td><?php echo $d->sk_setjen ?></td>
		<td><?php echo $d->sk_menteri ?></td>
		<td><?php echo $d->ket_thesis ?></td>
	</tr>
	<?php endforeach ?>
</table>