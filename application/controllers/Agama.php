<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Agama extends CI_Controller {


    public function __construct()
    {
        parent::__construct();
        $this->model->CekLogin();
        $this->load->model('Model_agama', 'ma');
        // $this->model->cek_user("Manager");
        // $this->model->cek_user("Warehouse");
    }

    public function CountTable()
    {
        $this->model->check_is_ajax();
        $count_table = $this->model->GetCustomTable("agama", "where is_deleted = 0")->num_rows();
        $result['value'] = $count_table;
        echo json_encode($result);
    }

    public function CekNamaAgama()
    {
        $this->model->check_is_ajax();
        $result = array();
        $nama_agama = $this->model->input('nama_agama');
        $nama_agama_lama = $this->model->input('nama_agama_lama');
        $cek = $this->model->GetCustomTable("agama", "where nama_agama = '$nama_agama' and is_deleted = 0")->num_rows();
        if ($nama_agama == '') {
            $result['value'] = "*Agama tidak boleh kosong";
        }else if($nama_agama != $nama_agama_lama and $cek > 0){
            $result['value'] = "*Agama sudah ada";
        }else if(strlen($nama_agama) < 2 or strlen($nama_agama) > 35){
            $result['value'] = "*Agama 2-35 character";
        }else{
            $result['value'] = "*Agama tersedia";
        }
        echo json_encode($result);
    }  

    public function index()
    {
        $data = array(
            'judul' => 'Agama',
            'modul' => 'Data Agama',
            'list_modul' => 'List Data',
            'content' => 'agama/agama-data',
            'link_fetch_data' => site_url('agama/fetch_data'),
        );
        $this->load->view('backend/template', $data);
    }

    public function fetch_data()
    {
        $this->model->check_is_ajax();
        $no = 0;
        $result = array('data' => array());
        $data = $this->ma->get_datatables();
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
                $this->model->select_data($value->nama_agama),
                $opsi,
            );
        }
        $result['draw'] = $_POST['draw'];
        $result['recordsTotal'] = $this->ma->count_all();
        $result['recordsFiltered'] = $this->ma->count_filtered();
        echo json_encode($result);
    }

    public function InsertData()
    {
        $this->model->check_is_ajax();
        $result['notif'] = 0;
        $nama_agama = $this->model->input("nama_agama");
        $data = array(
            'nama_agama' => $this->model->input("nama_agama"),
            'created_by' => $this->model->GetSesLogin('kode'),
            'created_date' => $this->model->TanggalWaktu(),
        );
        if ($this->model->Simpan('agama', $data) == 1) {
            $this->model->SetLog("Tambah Agama pada nama = $nama_agama");
            $result['notif'] = 1;
        }
        echo json_encode($result);
    }

    public function EditData($kode='')
    {
        $this->model->check_is_ajax();
        $id = $this->model->select_data($kode);
        $result['notif'] = 0;
        $data = $this->model->GetCustomTable("agama", "where id = '$id' and is_deleted = 0");
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
        $nama_agama = $this->model->input("nama_agama");
        $data = array(
            'nama_agama' => $nama_agama,
            'last_modified_by' => $this->model->GetSesLogin('kode'),
            'last_modified_date' => $this->model->TanggalWaktu()
        );
        if ($this->model->Update("agama", $data, "id = '$id'") == 1) {
            $this->model->SetLog("Update Agama pada nama = ".$nama_agama);
            $result['notif'] = 1;
        }
        echo json_encode($result);
    }

    public function DeleteData($kode='')
    {
        $this->model->check_is_ajax();
        $result['notif'] = 0;
        $id = $this->model->select_data($kode);
        $gethapus = $this->model->GetCustomTable("agama", "where id = '$id'");
        if ($gethapus->num_rows() > 0) {
            if ($this->model->Hapus('agama', "id = '$id'") == 1) {
                $this->model->SetLog("Hapus Agama pada nama = ".$gethapus->row()->nama_agama);
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
        if($this->db->Reset('agama') == 1){
            $this->model->SetLog("Reset Agama");
            $result['notif'] = 1;
        }
        echo json_encode($result);
    }
}

/* End of file agama.php */
/* Location: ./application/controllers/agama.php */