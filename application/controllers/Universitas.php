<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Universitas extends CI_Controller {


    public function __construct()
    {
        parent::__construct();
        $this->model->CekLogin();
        $this->load->model('Model_universitas', 'mu');
        // $this->model->cek_user("Manager");
        // $this->model->cek_user("Warehouse");
    }

    public function CountTable()
    {
        $this->model->check_is_ajax();
        $count_table = $this->model->GetCustomTable("universitas", "where is_deleted = 0")->num_rows();
        $result['value'] = $count_table;
        echo json_encode($result);
    }

    public function CekNamaUniversitas()
    {
        $this->model->check_is_ajax();
        $result = array();
        $nama_universitas = $this->model->input('nama_universitas');
        $nama_universitas_lama = $this->model->input('nama_universitas_lama');
        $cek = $this->model->GetCustomTable("universitas", "where nama_universitas = '$nama_universitas' and is_deleted = 0")->num_rows();
        if ($nama_universitas == '') {
            $result['value'] = "*Universitas tidak boleh kosong";
        }else if($nama_universitas != $nama_universitas_lama and $cek > 0){
            $result['value'] = "*Universitas sudah ada";
        }else if(strlen($nama_universitas) < 2 or strlen($nama_universitas) > 100){
            $result['value'] = "*Universitas 2-100 character";
        }else{
            $result['value'] = "*Universitas tersedia";
        }
        echo json_encode($result);
    }  

    public function index()
    {
        $data = array(
            'judul' => 'Universitas',
            'modul' => 'Data Universitas',
            'list_modul' => 'List Data',
            'content' => 'universitas/universitas-data',
            'link_fetch_data' => site_url('universitas/fetch_data'),
        );
        $this->load->view('backend/template', $data);
    }

    public function fetch_data()
    {
        $this->model->check_is_ajax();
        $no = 0;
        $result = array('data' => array());
        $data = $this->mu->get_datatables();
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
                $this->model->select_data($value->nama_universitas),
                $this->model->select_data($value->dl),
                $opsi,
            );
        }
        $result['draw'] = $_POST['draw'];
        $result['recordsTotal'] = $this->mu->count_all();
        $result['recordsFiltered'] = $this->mu->count_filtered();
        echo json_encode($result);
    }

    public function InsertData()
    {
        $this->model->check_is_ajax();
        $result['notif'] = 0;
        $nama_universitas = $this->model->input("nama_universitas");
        $data = array(
            'nama_universitas' => $this->model->input("nama_universitas"),
            'dl' => $this->model->input("dl"),
            'created_by' => $this->model->GetSesLogin('kode'),
            'created_date' => $this->model->TanggalWaktu(),
        );
        if ($this->model->Simpan('universitas', $data) == 1) {
            $this->model->SetLog("Tambah Universitas pada nama = $nama_universitas");
            $result['notif'] = 1;
        }
        echo json_encode($result);
    }

    public function EditData($kode='')
    {
        $this->model->check_is_ajax();
        $id = $this->model->select_data($kode);
        $result['notif'] = 0;
        $data = $this->model->GetCustomTable("universitas", "where id = '$id' and is_deleted = 0");
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
        $nama_universitas = $this->model->input("nama_universitas");
        $data = array(
            'nama_universitas' => $nama_universitas,
            'dl' => $this->model->input("dl"),
            'last_modified_by' => $this->model->GetSesLogin('kode'),
            'last_modified_date' => $this->model->TanggalWaktu()
        );
        if ($this->model->Update("universitas", $data, "id = '$id'") == 1) {
            $this->model->SetLog("Update Universitas pada nama = ".$nama_universitas);
            $result['notif'] = 1;
        }
        echo json_encode($result);
    }

    public function DeleteData($kode='')
    {
        $this->model->check_is_ajax();
        $result['notif'] = 0;
        $id = $this->model->select_data($kode);
        $gethapus = $this->model->GetCustomTable("universitas", "where id = '$id'");
        if ($gethapus->num_rows() > 0) {
            if ($this->model->Hapus('universitas',"id = '$id'") == 1) {
                $this->model->SetLog("Hapus Universitas pada nama = ".$gethapus->row()->nama_universitas);
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
        if($this->db->Reset('universitas') == 1){
            $this->model->SetLog("Reset Universitas");
            $result['notif'] = 1;
        }
        echo json_encode($result);
    }
}

/* End of file universitas.php */
/* Location: ./application/controllers/universitas.php */