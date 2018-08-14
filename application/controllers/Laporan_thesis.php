<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan_thesis extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->model->CekLogin();
        $this->load->model('Model_laporan_thesis', 'mlt');
    }

    public function CountTable()
    {
        $this->model->check_is_ajax();
        $count_table = $this->model->GetCustomTable("laporan_thesis", "where is_deleted = 0")->num_rows();
        $result['value'] = $count_table;
        echo json_encode($result);
    }

    public function index()
    {
        $data = array(
            'judul' => 'Laporan Thesis',
            'modul' => 'Data Laporan Thesis',
            'list_modul' => 'List Data',
            'content' => 'laporan-thesis/laporan-thesis-data',
            'link_fetch_data' => site_url('laporan_thesis/fetch_data'),

            'karyasiswa_log' => $this->model->GetCustomTable("v_karyasiswa_log", "where is_deleted = 0 order by nama asc"),
            'semester' => $this->model->GetCustomTable("semester", "order by id_semester desc"),
        );
        $this->load->view('backend/template', $data);
    }

    public function fetch_data()
    {
        $this->model->check_is_ajax();
        $no = 0;
        $result = array('data' => array());
        $data = $this->mlt->get_datatables();
        foreach ($data as $key => $value) { $no++;
            $id = $this->model->select_data($value->id);
            $opsi = "
				<center>
                    <button class='btn btn-default btn-sm btn-flat' onclick='DetailData(".'"'."$id".'"'.")'> Detail</button>
					<button class='btn btn-default btn-sm btn-flat' onclick='EditData(".'"'."$id".'"'.")'> Edit</button>
					<button class='btn btn-default btn-sm btn-flat' onclick='DeleteData(".'"'."$id".'"'.")'> Hapus</button>
				</center>		
				";
            $result['data'][$key] = array(
                $no,
                $this->model->select_data($value->nip),
                $this->model->select_data($value->nama),
                $this->model->select_data($value->nama_universitas),
                $this->model->select_data($value->nama_jenjang_studi)."~".$this->model->select_data($value->dl),
                $this->model->select_data($value->nm_smt),
                $opsi,
            );
        }
        $result['draw'] = $_POST['draw'];
        $result['recordsTotal'] = $this->mlt->count_all();
        $result['recordsFiltered'] = $this->mlt->count_filtered();
        echo json_encode($result);
    }

    public function InsertData()
    {
        $this->model->check_is_ajax();
        $result['notif'] = 0;
        $id_karyasiswa_log = $this->model->input("id_karyasiswa_log");
		$getdata = $this->model->GetCustomTable("v_karyasiswa_log", "where id = '$id_karyasiswa_log'")->row();
		$nip = $getdata->nip;
		$nama = $getdata->nama;
		$universitas= $getdata->nama_universitas;
		$jenjang = $getdata->nama_jenjang_studi."~".$getdata->dl;
        $data = array(
        	'id_karyasiswa_log' => $this->model->input("id_karyasiswa_log"),
            'id_semester' => $this->model->input("id_semester"),
            'judul_thesis' => $this->model->input("judul_thesis"),
            'jadwal_thesis' => $this->model->input("jadwal_thesis"),
            'moderator_presentasi' => $this->model->input("moderator_presentasi"),
            'rekomendasi_1_hasil_presentasi' => $this->model->input("rekomendasi_1_hasil_presentasi"),
            'rekomendasi_2_hasil_presentasi' => $this->model->input("rekomendasi_2_hasil_presentasi"),
            'rekomendasi_3_hasil_presentasi' => $this->model->input("rekomendasi_3_hasil_presentasi"),
            'narasumber' => $this->model->input("narasumber"),
            'created_by' => $this->model->GetSesLogin('kode'),
            'created_date' => $this->model->TanggalWaktu(),
        );
        if ($this->model->Simpan('laporan_thesis', $data) == 1) {
            $this->model->SetLog("Tambah Laporan Thesis pada nip = $nip, nama = $nama, universitas = $universitas, jenjang = $jenjang");
            $result['post'] = $data;
            $result['notif'] = 1;
        }
        echo json_encode($result);
    }

    public function EditData($kode='')
    {
        $this->model->check_is_ajax();
        $id = $this->model->select_data($kode);
        $result['notif'] = 0;
        $data = $this->model->GetCustomTable("v_laporan_thesis", "where id = '$id' and is_deleted = 0");
        if ($data->num_rows() > 0) {
            $result['data'] = $data->row();
            $result['notif'] = 1;
        }
        echo json_encode($result);
    }

    public function UpdateData()
    {
        $this->model->check_is_ajax();
        $result['notif'] = 0;
        $id = $this->model->input("id");
        $id_karyasiswa_log = $this->model->input("id_karyasiswa_log");
        $getdata = $this->model->GetCustomTable("v_laporan_thesis", "where id = '$id'")->row();
        $nama = $getdata->nama;
        $nip = $getdata->nip;
        $universitas = $getdata->nama_universitas;
        $jenjang = $getdata->nama_jenjang_studi."~".$getdata->dl;
        $data = array(
        	'id_karyasiswa_log' => $this->model->input("id_karyasiswa_log"),
            'id_semester' => $this->model->input("id_semester"),
            'judul_thesis' => $this->model->input("judul_thesis"),
            'jadwal_thesis' => $this->model->input("jadwal_thesis"),
            'moderator_presentasi' => $this->model->input("moderator_presentasi"),
            'rekomendasi_1_hasil_presentasi' => $this->model->input("rekomendasi_1_hasil_presentasi"),
            'rekomendasi_2_hasil_presentasi' => $this->model->input("rekomendasi_2_hasil_presentasi"),
            'rekomendasi_3_hasil_presentasi' => $this->model->input("rekomendasi_3_hasil_presentasi"),
            'narasumber' => $this->model->input("narasumber"),
            'last_modified_by' => $this->model->GetSesLogin('kode'),
            'last_modified_date' => $this->model->TanggalWaktu()
        );
        if ($this->model->Update('laporan_thesis', $data, "id = '$id'") == 1) {
            $this->model->SetLog("Update Laporan Thesis pada nip = $nip, nama = $nama, universitas = $universitas, jenjang = $jenjang");
            $result['notif'] = 1;
        }
        echo json_encode($result);
    }

    public function DeleteData($kode='')
    {
        $this->model->check_is_ajax();
        $result['notif'] = 0;
        $id = $this->model->select_data($kode);
        $gethapus = $this->model->GetCustomTable("v_laporan_thesis", "where id = '$id'");
        $data = array(
            'is_deleted' => 1,
            'deleted_by' => $this->model->GetSesLogin('kode'),
            'deleted_date' => $this->model->TanggalWaktu(),
            );
        if ($gethapus->num_rows() > 0) {
	        $nama = $gethapus->row()->nama;
	        $nip = $gethapus->row()->nip;
	        $universitas = $gethapus->row()->nama_universitas;
	        $jenjang = $gethapus->row()->nama_jenjang_studi."~".$gethapus->row()->dl;
            if ($this->model->Update('laporan_thesis', $data, "id = '$id'") == 1) {
                $this->model->SetLog("Hapus Laporan Thesis pada nip = $nip, nama = $nama, universitas = $universitas, jenjang = $jenjang");
                $result['notif'] = 1;
            }
        }else{
            $result['notif'] = 2;//data tidak ditemukan
        }
        echo json_encode($result);
    }

    public function ResetData()
    {
        $this->model->check_is_ajax();
        $result['notif'] = 0;
        $data = array(
            'is_deleted' => 1,
            'deleted_by' => $this->model->GetSesLogin('kode'),
            'deleted_date' => $this->model->TanggalWaktu(),
        );
        if($this->model->Update('laporan_thesis', $data, "is_deleted = 0") == 1){
            $this->model->SetLog("Reset Laporan Thesis");
            $result['notif'] = 1;
        }
        echo json_encode($result);
    }

}

/* End of file laporan_thesis.php */
/* Location: ./application/controllers/laporan_thesis.php */