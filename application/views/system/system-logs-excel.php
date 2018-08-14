<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=report_stok.xls");
header("Pragma: no-cache");
header("Expires: 0");
?>
<table border="1">
    <thead>
    <tr>
        <th colspan="6"><h3><?php echo $title;?></h3></th>
    </tr>
    <tr>
        <th colspan="6">Tanggal Report : <?php echo $tanggal;?></th>
    </tr>
    <tr>
        <th>NO</th>
        <th>WAKTU</th>
        <th>KODE USER</th>
        <th>NAMA USER</th>
        <th>LEVEL</th>
        <th>DESKRIPSI</th>
    </tr>
    </thead>
    <tbody>
    <?php $i=0; foreach($data_result->result() as $d) { $i++;?>
        <tr>
            <td><?php echo $i; ?></td>
            <td><?php echo $this->model->select_data($d->tgl_log); ?></td>
            <td><?php echo $this->model->select_data($d->kode_user); ?></td>
            <td><?php echo $this->model->select_data($d->nama_user); ?></td>
            <td><?php echo $this->model->select_data($d->level); ?></td>
            <td><?php echo $this->model->select_data($d->deskripsi); ?></td>
        </tr>
    <?php  } ?>
    </tbody>
</table>