<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jenjang_studi extends CI_Controller {


    public function __construct()
    {
        parent::__construct();
        $this->model->CekLogin();
        $this->load->model('Model_jenjang_studi', 'mjs');
        // $this->model->cek_user("Manager");
        // $this->model->cek_user("Warehouse");
    }

    public function CountTable()
    {
        $this->model->check_is_ajax();
        $count_table = $this->model->GetCustomTable("jenjang_studi", "where is_deleted = 0")->num_rows();
        $result['value'] = $count_table;
        echo json_encode($result);
    }

    public function CekNamaJenjangStudi()
    {
        $this->model->check_is_ajax();
        $result = array();
        $nama_jenjang_studi = $this->model->input('nama_jenjang_studi');
        $nama_jenjang_studi_lama = $this->model->input('nama_jenjang_studi_lama');
        $cek = $this->model->GetCustomTable("jenjang_studi", "where nama_jenjang_studi = '$nama_jenjang_studi' and is_deleted = 0")->num_rows();
        if ($nama_jenjang_studi == '') {
            $result['value'] = "*Jenjang Studi tidak boleh kosong";
        }else if($nama_jenjang_studi != $nama_jenjang_studi_lama and $cek > 0){
            $result['value'] = "*Jenjang Studi sudah ada";
        }else if(strlen($nama_jenjang_studi) < 1 or strlen($nama_jenjang_studi) > 100){
            $result['value'] = "*Jenjang Studi 1-100 character";
        }else{
            $result['value'] = "*Jenjang Studi tersedia";
        }
        echo json_encode($result);
    }  

    public function index()
    {
        $data = array(
            'judul' => 'Jenjang Studi',
            'modul' => 'Data Jenjang Studi',
            'list_modul' => 'List Data',
            'content' => 'jenjang-studi/jenjang-studi-data',
            'link_fetch_data' => site_url('jenjang_studi/fetch_data'),
        );
        $this->load->view('backend/template', $data);
    }

    public function fetch_data()
    {
        $this->model->check_is_ajax();
        $no = 0;
        $result = array('data' => array());
        $data = $this->mjs->get_datatables();
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
                $this->model->select_data($value->nama_jenjang_studi),
                $opsi,
            );
        }
        $result['draw'] = $_POST['draw'];
        $result['recordsTotal'] = $this->mjs->count_all();
        $result['recordsFiltered'] = $this->mjs->count_filtered();
        echo json_encode($result);
    }

    public function InsertData()
    {
        $this->model->check_is_ajax();
        $result['notif'] = 0;
        $nama_jenjang_studi = $this->model->input("nama_jenjang_studi");
        $data = array(
            'nama_jenjang_studi' => $this->model->input("nama_jenjang_studi"),
            'created_by' => $this->model->GetSesLogin('kode'),
            'created_date' => $this->model->TanggalWaktu(),
        );
        if ($this->model->Simpan('jenjang_studi', $data) == 1) {
            $this->model->SetLog("Tambah Jenjang Studi pada nama = $nama_jenjang_studi");
            $result['notif'] = 1;
        }
        echo json_encode($result);
    }

    public function EditData($kode='')
    {
        $this->model->check_is_ajax();
        $id = $this->model->select_data($kode);
        $result['notif'] = 0;
        $data = $this->model->GetCustomTable("jenjang_studi", "where id = '$id' and is_deleted = 0");
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
        $nama_jenjang_studi = $this->model->input("nama_jenjang_studi");
        $data = array(
            'nama_jenjang_studi' => $nama_jenjang_studi,
            'last_modified_by' => $this->model->GetSesLogin('kode'),
            'last_modified_date' => $this->model->TanggalWaktu()
        );
        if ($this->model->Update("jenjang_studi", $data, "id = '$id'") == 1) {
            $this->model->SetLog("Update Jenjang Studi pada nama = ".$nama_jenjang_studi);
            $result['notif'] = 1;
        }
        echo json_encode($result);
    }

    public function DeleteData($kode='')
    {
        $this->model->check_is_ajax();
        $result['notif'] = 0;
        $id = $this->model->select_data($kode);
        $gethapus = $this->model->GetCustomTable("jenjang_studi", "where id = '$id'");
        if ($gethapus->num_rows() > 0) {
            if ($this->model->Hapus('jenjang_studi', "id = '$id'") == 1) {
                $this->model->SetLog("Hapus Jenjang Studi pada nama = ".$gethapus->row()->nama_jenjang_studi);
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
        if($this->db->Reset('jenjang_studi') == 1){
            $this->model->SetLog("Reset Jenjang Studi");
            $result['notif'] = 1;
        }
        echo json_encode($result);
    }
}

/* End of file jenjang_studi.php */
/* Location: ./application/controllers/jenjang_studi.php */