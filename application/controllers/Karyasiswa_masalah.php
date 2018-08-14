<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Karyasiswa_masalah extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->model->CekLogin();
        $this->load->model('Model_karyasiswa_masalah', 'mkm');
    }

    public function CountTable()
    {
        $this->model->check_is_ajax();
        $count_table = $this->model->GetCustomTable("karyasiswa_masalah", "where is_deleted = 0")->num_rows();
        $result['value'] = $count_table;
        echo json_encode($result);
    }

    public function index()
    {
        $data = array(
            'judul' => 'Karyasiswa Masalah',
            'modul' => 'Data Karyasiswa Masalah',
            'list_modul' => 'List Data',
            'content' => 'karyasiswa-masalah/karyasiswa-masalah-data',
            'link_fetch_data' => site_url('karyasiswa_masalah/fetch_data'),

            'karyasiswa_log' => $this->model->GetCustomTable("v_karyasiswa_log", "where is_deleted = 0 order by nama asc"),
        );
        $this->load->view('backend/template', $data);
    }

    public function fetch_data()
    {
        $this->model->check_is_ajax();
        $no = 0;
        $result = array('data' => array());
        $data = $this->mkm->get_datatables();
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
                $this->model->select_data($value->nama_keterangan),
                $opsi,
            );
        }
        $result['draw'] = $_POST['draw'];
        $result['recordsTotal'] = $this->mkm->count_all();
        $result['recordsFiltered'] = $this->mkm->count_filtered();
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
        	'progress' => $this->model->input("progress"),
        	'masalah_pokok' => $this->model->input("masalah_pokok"),
        	'ringkasan_kondisi_1' => $this->model->input("ringkasan_kondisi_1"),
        	'ringkasan_kondisi_2' => $this->model->input("ringkasan_kondisi_2"),
        	'ringkasan_kondisi_3' => $this->model->input("ringkasan_kondisi_3"),
        	'ringkasan_kondisi_4' => $this->model->input("ringkasan_kondisi_4"),
        	'ringkasan_kondisi_5' => $this->model->input("ringkasan_kondisi_5"),
        	'masalah_kondisi_1' => $this->model->input("masalah_kondisi_1"),
        	'masalah_kondisi_2' => $this->model->input("masalah_kondisi_2"),
        	'masalah_kondisi_3' => $this->model->input("masalah_kondisi_3"),
        	'masalah_kondisi_4' => $this->model->input("masalah_kondisi_4"),
        	'masalah_kondisi_5' => $this->model->input("masalah_kondisi_5"),
        	'upaya_penyelesaian_1' => $this->model->input("upaya_penyelesaian_1"),
        	'upaya_penyelesaian_2' => $this->model->input("upaya_penyelesaian_2"),
        	'upaya_penyelesaian_3' => $this->model->input("upaya_penyelesaian_3"),
        	'upaya_penyelesaian_4' => $this->model->input("upaya_penyelesaian_4"),
        	'upaya_penyelesaian_5' => $this->model->input("upaya_penyelesaian_5"),
        	'saran_1' => $this->model->input("saran_1"),
        	'saran_2' => $this->model->input("saran_2"),
        	'saran_3' => $this->model->input("saran_3"),
        	'hasil_rapat_1' => $this->model->input("hasil_rapat_1"),
        	'hasil_rapat_2' => $this->model->input("hasil_rapat_2"),
        	'hasil_rapat_3' => $this->model->input("hasil_rapat_3"),
        	'verifikasi' => $this->model->input("verifikasi"),
            'created_by' => $this->model->GetSesLogin('kode'),
            'created_date' => $this->model->TanggalWaktu(),
        );
        if ($this->model->Simpan('karyasiswa_masalah', $data) == 1) {
            $this->model->SetLog("Tambah Karyasiswa Masalah pada nip = $nip, nama = $nama, universitas = $universitas, jenjang = $jenjang");
            $result['notif'] = 1;
        }
        echo json_encode($result);
    }

    public function EditData($kode='')
    {
        // $this->model->check_is_ajax();
        $id = $this->model->select_data($kode);
        $result['notif'] = 0;
        $data = $this->model->GetCustomTable("v_karyasiswa_masalah", "where id = '$id' and is_deleted = 0");
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
        $getdata = $this->model->GetCustomTable("v_karyasiswa_log", "where id = '$id'")->row();
        $nama = $getdata->nama;
        $nip = $getdata->nip;
        $universitas = $getdata->nama_universitas;
        $jenjang = $getdata->nama_jenjang_studi."~".$getdata->dl;
        $data = array(
        	'id_karyasiswa_log' => $this->model->input("id_karyasiswa_log"),
        	'progress' => $this->model->input("progress"),
        	'masalah_pokok' => $this->model->input("masalah_pokok"),
        	'ringkasan_kondisi_1' => $this->model->input("ringkasan_kondisi_1"),
        	'ringkasan_kondisi_2' => $this->model->input("ringkasan_kondisi_2"),
        	'ringkasan_kondisi_3' => $this->model->input("ringkasan_kondisi_3"),
        	'ringkasan_kondisi_4' => $this->model->input("ringkasan_kondisi_4"),
        	'ringkasan_kondisi_5' => $this->model->input("ringkasan_kondisi_5"),
        	'masalah_kondisi_1' => $this->model->input("masalah_kondisi_1"),
        	'masalah_kondisi_2' => $this->model->input("masalah_kondisi_2"),
        	'masalah_kondisi_3' => $this->model->input("masalah_kondisi_3"),
        	'masalah_kondisi_4' => $this->model->input("masalah_kondisi_4"),
        	'masalah_kondisi_5' => $this->model->input("masalah_kondisi_5"),
        	'upaya_penyelesaian_1' => $this->model->input("upaya_penyelesaian_1"),
        	'upaya_penyelesaian_2' => $this->model->input("upaya_penyelesaian_2"),
        	'upaya_penyelesaian_3' => $this->model->input("upaya_penyelesaian_3"),
        	'upaya_penyelesaian_4' => $this->model->input("upaya_penyelesaian_4"),
        	'upaya_penyelesaian_5' => $this->model->input("upaya_penyelesaian_5"),
        	'saran_1' => $this->model->input("saran_1"),
        	'saran_2' => $this->model->input("saran_2"),
        	'saran_3' => $this->model->input("saran_3"),
        	'hasil_rapat_1' => $this->model->input("hasil_rapat_1"),
        	'hasil_rapat_2' => $this->model->input("hasil_rapat_2"),
        	'hasil_rapat_3' => $this->model->input("hasil_rapat_3"),
        	'verifikasi' => $this->model->input("verifikasi"),
            'last_modified_by' => $this->model->GetSesLogin('kode'),
            'last_modified_date' => $this->model->TanggalWaktu()
        );
        if ($this->model->Update('karyasiswa_masalah', $data, "id = '$id'") == 1) {
            $this->model->SetLog("Update Karyasiswa Masalah pada nip = $nip, nama = $nama, universitas = $universitas, jenjang = $jenjang");
            $result['notif'] = 1;
        }
        echo json_encode($result);
    }

    public function DeleteData($kode='')
    {
        $this->model->check_is_ajax();
        $result['notif'] = 0;
        $id = $this->model->select_data($kode);
        $gethapus = $this->model->GetCustomTable("v_karyasiswa_masalah", "where id = '$id'");
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
            if ($this->model->Update('karyasiswa_masalah', $data, "id = '$id'") == 1) {
                $this->model->SetLog("Hapus Karyasiswa Masalah pada nip = $nip, nama = $nama, universitas = $universitas, jenjang = $jenjang");
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
        if($this->model->Update('karyasiswa_masalah', $data, "is_deleted = 0") == 1){
            $this->model->SetLog("Reset Karyasiswa Masalah");
            $result['notif'] = 1;
        }
        echo json_encode($result);
    }

}

/* End of file karyasiswa_masalah.php */
/* Location: ./application/controllers/karyasiswa_masalah.php */