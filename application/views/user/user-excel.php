<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=report_user.xls");
header("Pragma: no-cache");
header("Expires: 0");
?>
<table border="1">
    <thead>
    <tr>
        <th colspan="6"><h3><?php echo $title;?></h3></th>
    </tr>
    <tr>
        <th colspan="6">Tanggal Report : <?php echo $tanggal_cetak;?></th>
    </tr>
    <tr>
        <th>NO</th>
        <th>KODE USER</th>
        <th>NAMA USER</th>
        <th>EMAIL</th>
        <th>LEVEL</th>
        <th>STATUS</th>
    </tr>
    </thead>
    <tbody>
    <?php $i=0; foreach($data_result as $d) { $i++;?>
        <tr>
            <td><?php echo $i; ?></td>
            <td><?php echo $this->model->select_data($d->kode_user); ?></td>
            <td><?php echo $this->model->select_data($d->name_user); ?></td>
            <td><?php echo $this->model->select_data($d->email); ?></td>
            <td><?php echo $this->model->select_data($d->level); ?></td>
            <td><?php echo $this->model->select_data($d->status); ?></td>
        </tr>
    <?php  } ?>
    </tbody>
</table>