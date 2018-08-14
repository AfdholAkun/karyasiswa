<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Peserta extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->model->CekLogin();
        $this->load->model('Model_peserta', 'mp');
    }

    public function CekNip()
    {
        $this->model->check_is_ajax();
        $result = array(); 
        $nip = $this->model->input('nip');
        $cek_user = $this->model->GetCustomTable("peserta", "where nip = '$nip'")->num_rows();
        if ($nip == '') {
            $result['value'] = "*Nip tidak boleh kosong";
        }else if($cek_user > 0){
            $result['value'] = "*Nip sudah ada";
        }else if(strlen($nip) < 5 or strlen($nip) > 35){
            $result['value'] = "*Nip 5-35 character";
        }else{
            $result['value'] = "*Nip tersedia";
        }
        echo json_encode($result);
    } 

    public function CountTable()
    {
        $this->model->check_is_ajax();
        $count_table = $this->model->GetCustomTable("peserta", "where is_deleted = 0")->num_rows();
        $result['value'] = $count_table;
        echo json_encode($result);
    }

    public function index()
    {
        $data = array(
            'judul' => 'Peserta',
            'modul' => 'Data Peserta',
            'list_modul' => 'List Data',
            'content' => 'peserta/peserta-data',
            'link_fetch_data' => site_url('peserta/fetch_data'),

            'agama' => $this->model->GetCustomTable("agama", "where is_deleted = 0 order by nama_agama asc"),
            'pangkat' => $this->model->GetCustomTable("pangkat", "where is_deleted = 0 order by nama_pangkat asc"),
            'instansi_asal' => $this->model->GetCustomTable("instansi_asal", "where is_deleted = 0 order by nama_instansi asc"),
            'kota' => $this->model->GetCustomTable("kota", "where is_deleted = 0 order by nama_kota asc"),
            'provinsi' => $this->model->GetCustomTable("provinsi", "where is_deleted = 0 order by nama_provinsi asc"),
        );
        $this->load->view('backend/template', $data);
    }

    public function fetch_data()
    {
        $this->model->check_is_ajax();
        $no = 0;
        $result = array('data' => array());
        $data = $this->mp->get_datatables();
        foreach ($data as $key => $value) { $no++;
            $id = $this->model->select_data($value->nip);
            $opsi = "
				<center>
                    <button class='btn btn-default btn-sm btn-flat' onclick='DetailData(".'"'."$id".'"'.")'> Detail</button>
					<button class='btn btn-default btn-sm btn-flat' onclick='EditData(".'"'."$id".'"'.")'> Edit</button>
					<button class='btn btn-default btn-sm btn-flat' onclick='DeleteData(".'"'."$id".'"'.")'> Hapus</button>
				</center>		
				";
            $result['data'][$key] = array(
                $no,
                $id,
                $this->model->select_data($value->nama),
                $this->model->select_data($value->jenis_kelamin),
                $this->model->select_data($value->tempat_lahir).', '.$this->model->select_data($value->tgl_lahir),
                $opsi,
            );
        }
        $result['draw'] = $_POST['draw'];
        $result['recordsTotal'] = $this->mp->count_all();
        $result['recordsFiltered'] = $this->mp->count_filtered();
        echo json_encode($result);
    }

    public function InsertData()
    {
        $this->model->check_is_ajax();
        $result['notif'] = 0;
        $nip = $this->model->input("nip");
        $data = array(
            'nama' => $this->model->input("nama"),
            'nip' => $nip,
            'tempat_lahir' => $this->model->input("tempat_lahir"),
            'tgl_lahir' => $this->model->input("tgl_lahir"),
            'jenis_kelamin' => $this->model->input("jenis_kelamin"),
            'id_agama' => $this->model->input("id_agama"),
            'id_pangkat' => $this->model->input("id_pangkat"),
            'jabatan_terakhir' => $this->model->input("jabatan_terakhir"),
            'id_instansi' => $this->model->input("id_instansi"),
            'alamat_kantor' => $this->model->input("alamat_kantor"),
            'alamat_rumah' => $this->model->input("alamat_rumah"),
            'kode_provinsi' => $this->model->input("kode_provinsi"),
            'kode_kota' => $this->model->input("kode_kota"),
            'ket_status_kepegawaian' => $this->model->input("ket_status_kepegawaian"),
            'penempatan' => $this->model->input("penempatan"),
            'instansi_1_sd_8' => $this->model->input("instansi_1_sd_8"),
            'created_by' => $this->model->GetSesLogin('kode'),
            'created_date' => $this->model->TanggalWaktu(),
        );
        if ($this->model->Simpan('peserta', $data) == 1) {
            $this->model->SetLog("Tambah Peserta dengan nip = $nip");
            $result['notif'] = 1;
        }
        echo json_encode($result);
    }

    public function EditData($kode='')
    {
        // $this->model->check_is_ajax();
        $id = $this->model->select_data($kode);
        $result['notif'] = 0;
        $data = $this->model->GetCustomTable("v_peserta", "where nip = '$id' and is_deleted = 0");
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
        $nip = $this->model->input("nip");
        $nip_lama = $this->model->input("nip_lama");
        $data = array(
            'nama' => $this->model->input("nama"),
            'nip' => $nip,
            'tempat_lahir' => $this->model->input("tempat_lahir"),
            'tgl_lahir' => $this->model->input("tgl_lahir"),
            'jenis_kelamin' => $this->model->input("jenis_kelamin"),
            'id_agama' => $this->model->input("id_agama"),
            'id_pangkat' => $this->model->input("id_pangkat"),
            'jabatan_terakhir' => $this->model->input("jabatan_terakhir"),
            'id_instansi' => $this->model->input("id_instansi"),
            'alamat_kantor' => $this->model->input("alamat_kantor"),
            'alamat_rumah' => $this->model->input("alamat_rumah"),
            'kode_provinsi' => $this->model->input("kode_provinsi"),
            'kode_kota' => $this->model->input("kode_kota"),
            'ket_status_kepegawaian' => $this->model->input("ket_status_kepegawaian"),
            'penempatan' => $this->model->input("penempatan"),
            'instansi_1_sd_8' => $this->model->input("instansi_1_sd_8"),
            'last_modified_by' => $this->model->GetSesLogin('kode'),
            'last_modified_date' => $this->model->TanggalWaktu()
        );
        if ($this->model->Update('peserta', $data, "nip = '$nip_lama'") == 1) {
            $this->model->SetLog("Update Peserta dengan nip = $nip");
            $result['notif'] = 1;
        }
        echo json_encode($result);
    }

    public function DeleteData($kode='')
    {
        $this->model->check_is_ajax();
        $result['notif'] = 0;
        $id = $this->model->select_data($kode);
        $gethapus = $this->model->GetCustomTable("peserta", "where nip = '$id'");
        $data = array(
            'is_deleted' => 1,
            'deleted_by' => $this->model->GetSesLogin('kode'),
            'deleted_date' => $this->model->TanggalWaktu(),
            );
        if ($gethapus->num_rows() > 0) {
            if ($this->model->Update('peserta', $data, "nip = '$id'") == 1) {
                $this->model->SetLog("Hapus Peserta dengan nip = ".$id);
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
        if($this->model->Update('peserta', $data, "is_deleted = 0") == 1){
            $this->model->SetLog("Reset Peserta");
            $result['notif'] = 1;
        }
        echo json_encode($result);
    }

}

/* End of file peserta.php */
/* Location: ./application/controllers/peserta.php */