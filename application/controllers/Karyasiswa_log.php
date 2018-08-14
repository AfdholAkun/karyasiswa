<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Karyasiswa_log extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->model->CekLogin();
        $this->load->model('Model_karyasiswa_log', 'mkl');
    }

    public function CountTable()
    {
        $this->model->check_is_ajax();
        $count_table = $this->model->GetCustomTable("karyasiswa_log", "where is_deleted = 0")->num_rows();
        $result['value'] = $count_table;
        echo json_encode($result);
    }

    public function index()
    {
        $data = array(
            'judul' => 'Karyasiswa',
            'modul' => 'Data Karyasiswa',
            'list_modul' => 'List Data',
            'content' => 'karyasiswa-log/karyasiswa-log-data',
            'link_fetch_data' => site_url('karyasiswa_log/fetch_data'),

            'peserta' => $this->model->GetCustomTable("v_peserta", "where is_deleted = 0 order by nama asc"),

            'negara' => $this->model->GetCustomTable("negara", "where is_deleted = 0 order by nama_negara asc"),
	        'universitas' => $this->model->GetCustomTable("universitas", "where is_deleted = 0 order by nama_universitas asc"),
            'bidang_studi' => $this->model->GetCustomTable("bidang_studi", "where is_deleted = 0 order by nama_bidang_studi asc"),
            'jenjang_studi' => $this->model->GetCustomTable("jenjang_studi", "where is_deleted = 0 order by nama_jenjang_studi asc"),
            'keterangan_karyasiswa' => $this->model->GetCustomTable("keterangan_karyasiswa", "where is_deleted = 0 order by nama_keterangan asc"),
        );
        $this->load->view('backend/template', $data);
    }

    public function fetch_data()
    {
        $this->model->check_is_ajax();
        $no = 0;
        $result = array('data' => array());
        $data = $this->mkl->get_datatables();
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
                $this->model->select_data($value->nama_jenjang_studi),
                $this->model->select_data($value->nama_keterangan),
                $opsi,
            );
        }
        $result['draw'] = $_POST['draw'];
        $result['recordsTotal'] = $this->mkl->count_all();
        $result['recordsFiltered'] = $this->mkl->count_filtered();
        echo json_encode($result);
    }

    public function InsertData()
    {
        $this->model->check_is_ajax();
        $result['notif'] = 0;
        $nip = $this->model->input("nip");
        $data = array(
            'nip' => $nip,
            'id_universitas' => $this->model->input("id_universitas"),
            'id_bidang_studi' => $this->model->input("id_bidang_studi"),
            'id_jenjang_studi' => $this->model->input("id_jenjang_studi"),
            'kode_negara' => $this->model->input("kode_negara"),
            'alamat_universitas' => $this->model->input("alamat_universitas"),
            'lama_studi' => $this->model->input("lama_studi"),
            'no_sktb' => $this->model->input("no_sktb"),
            'mulai_pendidikan' => $this->model->input("mulai_pendidikan"),
            'rencana_selesai_pendidikan' => $this->model->input("rencana_selesai_pendidikan"),
            'sumber_dana' => $this->model->input("sumber_dana"),
            'no_sktb_perpanjangan_1' => $this->model->input("no_sktb_perpanjangan_1"),
            'mulai_perpanjangan_1' => $this->model->input("mulai_perpanjangan_1"),
            'selesai_perpanjangan_1' => $this->model->input("selesai_perpanjangan_1"),
            'no_sktb_perpanjangan_2' => $this->model->input("no_sktb_perpanjangan_2"),
            'mulai_perpanjangan_2' => $this->model->input("mulai_perpanjangan_2"),
            'selesai_perpanjangan_2' => $this->model->input("selesai_perpanjangan_2"),
            'tahun_selesai' => $this->model->input("tahun_selesai"),
            'id_keterangan' => $this->model->input("id_keterangan"),			
            'ket_2' => $this->model->input("ket_2"),
            'presentasi' => $this->model->input("presentasi"),
            'lokasi_presentasi' => $this->model->input("lokasi_presentasi"),
            'laporan_studi' => $this->model->input("laporan_studi"),
            'sk_setjen' => $this->model->input("sk_setjen"),
            'sk_menteri' => $this->model->input("sk_menteri"),
            'jml_thesis' => $this->model->input("jml_thesis"),
            'ket_thesis' => $this->model->input("ket_thesis"),
            'created_by' => $this->model->GetSesLogin('kode'),
            'created_date' => $this->model->TanggalWaktu(),
        );
        if ($this->model->Simpan('karyasiswa_log', $data) == 1) {
            $this->model->SetLog("Tambah Karyasiswa Log pada nip = $nip");
            $result['notif'] = 1;
        }
        echo json_encode($result);
    }

    public function EditData($kode='')
    {
        // $this->model->check_is_ajax();
        $id = $this->model->select_data($kode);
        $result['notif'] = 0;
        $data = $this->model->GetCustomTable("v_karyasiswa_log", "where id = '$id' and is_deleted = 0");
        if ($data->num_rows() > 0) {
        	$nip = $data->row()->nip;
	        $peserta = $this->model->GetCustomTable("v_peserta", "where nip = '$nip' and is_deleted = 0");
	        if ($peserta->num_rows() > 0) {
                $result['data'] = $data->row();
	        	$result['peserta'] = $peserta->row();
	            $result['notif'] = 1;  
	        }
        }
        echo json_encode($result);
    }

    public function UpdateData()
    {
        $this->model->check_is_ajax();
        $result['notif'] = 0;
        $id = $this->model->input("id");
        $getdata = $this->model->GetCustomTable("v_karyasiswa_log", "where id = '$id'")->row();
        $nip_lama = $getdata->nip;
        $nama = $getdata->nama;
        $universitas = $getdata->nama_universitas;
        $jenjang = $getdata->nama_jenjang_studi."~".$getdata->dl;
        $data = array(
            'nip' => $this->model->input("nip"),
            'id_universitas' => $this->model->input("id_universitas"),
            'id_bidang_studi' => $this->model->input("id_bidang_studi"),
            'id_jenjang_studi' => $this->model->input("id_jenjang_studi"),  
            'kode_negara' => $this->model->input("kode_negara"),
            'alamat_universitas' => $this->model->input("alamat_universitas"),
            'lama_studi' => $this->model->input("lama_studi"),
            'no_sktb' => $this->model->input("no_sktb"),
            'mulai_pendidikan' => $this->model->input("mulai_pendidikan"),
            'rencana_selesai_pendidikan' => $this->model->input("rencana_selesai_pendidikan"),
            'sumber_dana' => $this->model->input("sumber_dana"),
            'no_sktb_perpanjangan_1' => $this->model->input("no_sktb_perpanjangan_1"),
            'mulai_perpanjangan_1' => $this->model->input("mulai_perpanjangan_1"),
            'selesai_perpanjangan_1' => $this->model->input("selesai_perpanjangan_1"),
            'no_sktb_perpanjangan_2' => $this->model->input("no_sktb_perpanjangan_2"),
            'mulai_perpanjangan_2' => $this->model->input("mulai_perpanjangan_2"),
            'selesai_perpanjangan_2' => $this->model->input("selesai_perpanjangan_2"),
            'tahun_selesai' => $this->model->input("tahun_selesai"),
            'id_keterangan' => $this->model->input("id_keterangan"),			
            'ket_2' => $this->model->input("ket_2"),
            'presentasi' => $this->model->input("presentasi"),
            'lokasi_presentasi' => $this->model->input("lokasi_presentasi"),
            'laporan_studi' => $this->model->input("laporan_studi"),
            'sk_setjen' => $this->model->input("sk_setjen"),
            'sk_menteri' => $this->model->input("sk_menteri"),
            'jml_thesis' => $this->model->input("jml_thesis"),
            'ket_thesis' => $this->model->input("ket_thesis"),
            'last_modified_by' => $this->model->GetSesLogin('kode'),
            'last_modified_date' => $this->model->TanggalWaktu()
        );
        if ($this->model->Update('karyasiswa_log', $data, "id = '$id'") == 1) {
            $this->model->SetLog("Update Karyasiswa Log pada nip = $nip_lama, nama = $nama, universitas = $universitas, jenjang = $jenjang");
            $result['notif'] = 1;
        }
        echo json_encode($result);
    }

    public function DeleteData($kode='')
    {
        $this->model->check_is_ajax();
        $result['notif'] = 0;
        $id = $this->model->select_data($kode);
        $gethapus = $this->model->GetCustomTable("v_karyasiswa_log", "where id = '$id'");
        $data = array(
            'is_deleted' => 1,
            'deleted_by' => $this->model->GetSesLogin('kode'),
            'deleted_date' => $this->model->TanggalWaktu(),
            );
        if ($gethapus->num_rows() > 0) {
            $nip = $gethapus->row()->nip;
            $nama = $gethapus->row()->nama;
            $universitas = $gethapus->row()->nama_universitas;
            $jenjang = $gethapus->row()->nama_jenjang_studi."~".$gethapus->row()->dl;
            if ($this->model->Update('karyasiswa_log', $data, "id = '$id'") == 1) {
                $this->model->SetLog("Hapus Karyasiswa Log pada nip = $nip, nama = $nama, universitas = $universitas, jenjang = $jenjang");
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
        if($this->model->Update('karyasiswa_log', $data, "is_deleted = 0") == 1){
            $this->model->SetLog("Reset Karyasiswa Log");
            $result['notif'] = 1;
        }
        echo json_encode($result);
    }

}

/* End of file karyasiswa_log.php */
/* Location: ./application/controllers/karyasiswa_log.php */