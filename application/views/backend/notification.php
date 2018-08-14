<?php
$barang = $this->model->GetBarang("where jml_barang <= 0");
$lapor = $this->model->GetLapor("where status_baca = 'belum'");
?>
<li class="dropdown notifications-menu">
	<a href="#" class="dropdown-toggle" data-toggle="dropdown">
		<i class="glyphicon glyphicon-bell"></i>
		<?php if ($barang->num_rows() > 0): ?>
		<span class="label label-warning"><?php echo $barang->num_rows() ?></span>
		<?php endif ?>
	</a>
	<ul class="dropdown-menu">
		
		<li class="header"><?php if ($barang->num_rows() > 0) { echo $barang->num_rows(); } ?> Notifikasi</li>
		<li>
			<ul class="menu">
				<?php if ($barang->num_rows() > 0) {
					foreach ($barang->result() as $d) {
						?>
						<li>
							<a href="<?php echo site_url('notifikasi')?>">
								<i class="fa fa-warning text-yellow"></i> Stok Barang
								<?php echo $this->model->select_data($d->nama_barang);
								if ($d->jml_barang == 0) { echo " Kosong "; } else{ echo " Tersisa ".$d->jml_barang;}
								?>
							</a>
						</li>
						<?php
					}
				} ?>
			</ul>
		</li>
	</ul>
</li>
<?php if ($this->session->userdata('ses_sarpras_level') == "Admin"): ?>

<li class="dropdown notifications-menu">
	<a href="<?php echo site_url('akun/lapor') ?>">
		<i class="glyphicon glyphicon-envelope"></i>
		<?php if ($lapor->num_rows() > 0): ?>
			<span class="label label-warning"><?= $lapor->num_rows() ?></span>
		<?php endif ?>
	</a>
</li>
<?php endif ?>
