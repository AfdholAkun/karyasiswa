<div style="width: 100%">
    <?php $this->load->view('backend/header-pdf'); ?>
    <div style="border: 1px solid black;"></div>
    <div style="padding: 5px 10px;">
        <h4 align="center" class="title"><?php echo $title ?></h4>
        <p align="center" class="tanggal">Tanggal Cetak : <?php echo $tanggal?></p>
        <table width="100%" class="table_medium" border="1">
            <thead>
            <tr style="background:cyan;">
                <th width="3%">No</th>
                <th width="15%">Waktu</th>
                <th width="10%">Kode User</th>
                <th width="16%">Nama User</th>
                <th width="7%">Level</th>
                <th>Deskripsi</th>
            </tr>
            </thead>
            <tbody>
            <?php $no = 0; foreach ($data_result->result() as $d) { $no++;?>
                <tr>
                    <td align="center"><?php echo $no ?></td>
                    <td><?php echo $this->model->select_data($d->tgl_log); ?></td>
                    <td><?php echo $this->model->select_data($d->kode_user); ?></td>
                    <td><?php echo $this->model->select_data($d->nama_user); ?></td>
                    <td><?php echo $this->model->select_data($d->level); ?></td>
                    <td><?php echo $this->model->select_data($d->deskripsi); ?></td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>