<?php
$level = $this->session->userdata('ses_rodeo_level');
?>
<aside class="main-sidebar">
    <section class="sidebar">
        <div class="user-panel">
            <div class="pull-left info">
                <p><?php echo $this->model->GetSesLogin('nama') ?></p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        <ul class="sidebar-menu">
            <li class="header">MENU</li>
            <li>
                <a href="<?php echo site_url('dashboard')?>">
                    <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                </a>
            </li>
            <li>
                <a href="<?php echo site_url('peserta')?>">
                    <i class="fa fa-dashboard"></i> <span>Biodata Peserta KS</span>
                </a>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-inbox"></i>
                    <span>Transaksi</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?php echo URL ?>karyasiswa_log"><i class="fa fa-angle-double-right"></i> Karyasiswa Log KS</a></li>
                    <li><a href="<?php echo URL ?>karyasiswa_masalah"><i class="fa fa-angle-double-right"></i> Karyasiswa Masalah KS</a></li>
                    <li><a href="<?php echo URL ?>laporan_semester_dan_akhir"><i class="fa fa-angle-double-right"></i> Laporan Semester dan Akhir</a></li>
                    <li><a href="<?php echo URL ?>laporan_thesis"><i class="fa fa-angle-double-right"></i> Laporan Thesis</a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-inbox"></i>
                    <span>Data Referensi</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?php echo URL ?>provinsi"><i class="fa fa-angle-double-right"></i> Provinsi</a></li>
                    <li><a href="<?php echo URL ?>kota"><i class="fa fa-angle-double-right"></i> Kota</a></li>
                    <li><a href="<?php echo URL ?>negara"><i class="fa fa-angle-double-right"></i> Negara</a></li>
                    <li><a href="<?php echo URL ?>universitas"><i class="fa fa-angle-double-right"></i> Universitas</a></li>
                    <li><a href="<?php echo URL ?>bidang_studi"><i class="fa fa-angle-double-right"></i> Bidang Studi</a></li>
                    <li><a href="<?php echo URL ?>program_studi"><i class="fa fa-angle-double-right"></i> Program Studi</a></li>
                    <li><a href="<?php echo URL ?>agama"><i class="fa fa-angle-double-right"></i> Agama</a></li>
                    <li><a href="<?php echo URL ?>instansi_asal"><i class="fa fa-angle-double-right"></i> Instansi Asal</a></li>
                    <li><a href="<?php echo URL ?>pangkat"><i class="fa fa-angle-double-right"></i> Pangkat</a></li>
                    <li><a href="<?php echo URL ?>keterangan_karyasiswa"><i class="fa fa-angle-double-right"></i> Keterangan Karyasiswa</a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-inbox"></i>
                    <span>Laporan</span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?php echo URL.'laporan/daftar_peserta_karyasiswa' ?>"><i class="fa fa-angle-double-right"></i> Daftar Peserta KS</a></li>
                    <li><a href="<?php echo URL.'laporan/profile_peserta_karyasiswa' ?>"><i class="fa fa-angle-double-right"></i> Profile Peserta KS</a></li>
                    <li><a href="<?php echo URL.'laporan/statistik_karyasiswa' ?>"><i class="fa fa-angle-double-right"></i> Statistik KS</a></li>
                    <li><a href="<?php echo URL.'laporan/progress_karyasiswa' ?>"><i class="fa fa-angle-double-right"></i> Progres KS</a></li>
                </ul>
            </li>        
            <li class="header">Aplikasi Karya Siswa Pusdiklat Created By Kreasi Media</li>
        </ul>
    </section>
</aside>