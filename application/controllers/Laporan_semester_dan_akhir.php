<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan_semester_dan_akhir extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->model->CekLogin();
        $this->load->model('Model_laporan_semester_dan_akhir', 'mls');
    }

    public function CountTable()
    {
        $this->model->check_is_ajax();
        $count_table = $this->model->GetCustomTable("laporan_akademik", "where is_deleted = 0")->num_rows();
        $result['value'] = $count_table;
        echo json_encode($result);
    }

    public function index()
    {
        $data = array(
            'judul' => 'Laporan Semester dan Akhir',
            'modul' => 'Data Laporan Semester dan Akhir',
            'list_modul' => 'List Data',
            'content' => 'laporan-semester-dan-akhir/laporan-semester-dan-akhir-data',
            'link_fetch_data' => site_url('laporan_semester_dan_akhir/fetch_data'),

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
        $data = $this->mls->get_datatables();
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
        $result['recordsTotal'] = $this->mls->count_all();
        $result['recordsFiltered'] = $this->mls->count_filtered();
        echo json_encode($result);
    }

    public function InsertData()
    {
        $this->model->check_is_ajax();
        $result['notif'] = 0;
        $id_karyasiswa_log = $this->model->input("id_karyasiswa_log");
        $file_karyasiswa = $_FILES['file_karyasiswa']['name'];
        $file_sktb = $_FILES['file_sktb']['name'];
		$getdata = $this->model->GetCustomTable("v_karyasiswa_log", "where id = '$id_karyasiswa_log'")->row();
		$nip = $getdata->nip;
		$nama = $getdata->nama;
		$universitas= $getdata->nama_universitas;
		$jenjang = $getdata->nama_jenjang_studi."~".$getdata->dl;
        if ($file_karyasiswa == null) {           
            $file_karyasiswa_name = "";
        }else{
            $config = array(
                'upload_path' => './assets/upload/file-karyasiswa',
                'allowed_types' => 'pdf',
                'max_size' => '1000000',
            );
            $this->load->library('upload', $config, 'uploadkaryasiswa');
            $this->uploadkaryasiswa->initialize($config);
            $this->uploadkaryasiswa->do_upload('file_karyasiswa');
            $upload_data = $this->uploadkaryasiswa->data();
            $file_karyasiswa_name = $upload_data['file_name'];
        }
        if ($file_sktb == null) {
            $file_sktb_name = "";
        }else{
            $config = array(
                'upload_path' => './assets/upload/file-sktb',
                'allowed_types' => 'pdf',
                'max_size' => '1000000',
            );
            $this->load->library('upload', $config, 'uploadsktb');
            $this->uploadsktb->do_upload('file_sktb');
            $upload_data = $this->uploadsktb->data();
            $file_sktb_name = $upload_data['file_name'];    
        }
        $data = array(
        	'id_karyasiswa_log' => $this->model->input("id_karyasiswa_log"),
            'id_semester' => $this->model->input("id_semester"),
            'progress' => $this->model->input("progress"),
            'tahun_lulus' => $this->model->input("tahun_lulus"),
            'keterangan' => $this->model->input("keterangan"),
            'sks' => $this->model->input("sks"),
            'ip' => $this->model->input("ip"),
            'file_karyasiswa' => $file_karyasiswa_name,
            'file_sktb' => $file_sktb_name,
            'created_by' => $this->model->GetSesLogin('kode'),
            'created_date' => $this->model->TanggalWaktu(),
        );
        if ($this->model->Simpan('laporan_akademik', $data) == 1) {
            $this->model->SetLog("Tambah Laporan Semester dan Akhir pada nip = $nip, nama = $nama, universitas = $universitas, jenjang = $jenjang");
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
        $data = $this->model->GetCustomTable("v_laporan_akademik", "where id = '$id' and is_deleted = 0");
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
        $file_karyasiswa = $_FILES['file_karyasiswa']['name'];
        $file_karyasiswa_lama = $this->model->input("file_karyasiswa_lama");
        $file_karyasiswa_unlink = false;
        $file_sktb = $_FILES['file_sktb']['name'];
        $file_sktb_lama = $this->model->input("file_sktb_lama");
        $file_sktb_unlink = false;
        $getdata = $this->model->GetCustomTable("v_laporan_akademik", "where id = '$id'")->row();
        $nama = $getdata->nama;
        $nip = $getdata->nip;
        $universitas = $getdata->nama_universitas;
        $jenjang = $getdata->nama_jenjang_studi."~".$getdata->dl;
        if ($file_karyasiswa == null) {
            $file_karyasiswa_name = $file_karyasiswa_lama;
        }else{
            $config = array(
                'upload_path' => './assets/upload/file-karyasiswa',
                'allowed_types' => 'pdf',
                'max_size' => '1000000',
            );
            $this->load->library('upload', $config, 'uploadkaryasiswa');
            $this->uploadkaryasiswa->do_upload('file_karyasiswa');
            $upload_data = $this->uploadkaryasiswa->data();
            $file_karyasiswa_name = $upload_data['file_name'];
            $file_karyasiswa_unlink = true;              
        }
        if ($file_sktb == null) {
            $file_sktb_name = $file_sktb_lama;
        }else{
            $config = array(
                'upload_path' => './assets/upload/file-sktb',
                'allowed_types' => 'pdf',
                'max_size' => '1000000',
            );
            $this->load->library('upload', $config, 'uploadsktb');
            $this->uploadsktb->do_upload('file_sktb');
            $upload_data = $this->uploadsktb->data();
            $file_sktb_name = $upload_data['file_name'];
            $file_sktb_unlink = true;
        }
        $data = array(
        	'id_karyasiswa_log' => $this->model->input("id_karyasiswa_log"),
            'id_semester' => $this->model->input("id_semester"),
            'progress' => $this->model->input("progress"),
            'tahun_lulus' => $this->model->input("tahun_lulus"),
            'keterangan' => $this->model->input("keterangan"),
            'sks' => $this->model->input("sks"),
            'ip' => $this->model->input("ip"),
            'file_karyasiswa' => $file_karyasiswa_name,
            'file_sktb' => $file_sktb_name,
            'last_modified_by' => $this->model->GetSesLogin('kode'),
            'last_modified_date' => $this->model->TanggalWaktu()
        );
        if ($this->model->Update('laporan_akademik', $data, "id = '$id'") == 1) {
            if ($file_karyasiswa_unlink == true and $file_karyasiswa_lama !== null and file_exists('./assets/upload/file-karyasiswa/'.$file_karyasiswa_lama) == 1) {
                unlink('./assets/upload/file-karyasiswa/'.$file_karyasiswa_lama);
            }
            if ($file_sktb_unlink == true and $file_sktb_lama !== null and file_exists('./assets/upload/file-sktb/'.$file_sktb_lama) == 1) {
                unlink('./assets/upload/file-sktb/'.$file_sktb_lama);
            }
            $this->model->SetLog("Update Laporan Semester dan Akhir pada nip = $nip, nama = $nama, universitas = $universitas, jenjang = $jenjang");
            $result['notif'] = 1;
        }
        echo json_encode($result);
    }

    public function DeleteData($kode='')
    {
        $this->model->check_is_ajax();
        $result['notif'] = 0;
        $id = $this->model->select_data($kode);
        $gethapus = $this->model->GetCustomTable("v_laporan_akademik", "where id = '$id'");
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
            if ($this->model->Update('laporan_akademik', $data, "id = '$id'") == 1) {
                $this->model->SetLog("Hapus Laporan Semester dan Akhir pada nip = $nip, nama = $nama, universitas = $universitas, jenjang = $jenjang");
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
        if($this->model->Update('laporan_akademik', $data, "is_deleted = 0") == 1){
            $this->model->SetLog("Reset Laporan Semester dan Akhir");
            $result['notif'] = 1;
        }
        echo json_encode($result);
    }

}

/* End of file laporan_semester_dan_akhir.php */
/* Location: ./application/controllers/laporan_semester_dan_akhir.php */