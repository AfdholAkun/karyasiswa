<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pangkat extends CI_Controller {


    public function __construct()
    {
        parent::__construct();
        $this->model->CekLogin();
        $this->load->model('Model_pangkat', 'mp');
        // $this->model->cek_user("Manager");
        // $this->model->cek_user("Warehouse");
    }

    public function CountTable()
    {
        $this->model->check_is_ajax();
        $count_table = $this->model->GetCustomTable("pangkat", "where is_deleted = 0")->num_rows();
        $result['value'] = $count_table;
        echo json_encode($result);
    }

    public function CekNamaPangkat()
    {
        $this->model->check_is_ajax();
        $result = array();
        $nama_pangkat = $this->model->input('nama_pangkat');
        $nama_pangkat_lama = $this->model->input('nama_pangkat_lama');
        $cek = $this->model->GetCustomTable("pangkat", "where nama_pangkat = '$nama_pangkat' and is_deleted = 0")->num_rows();
        if ($nama_pangkat == '') {
            $result['value'] = "*Pangkat tidak boleh kosong";
        }else if($nama_pangkat != $nama_pangkat_lama and $cek > 0){
            $result['value'] = "*Pangkat sudah ada";
        }else if(strlen($nama_pangkat) < 2 or strlen($nama_pangkat) > 35){
            $result['value'] = "*Pangkat 2-35 character";
        }else{
            $result['value'] = "*Pangkat tersedia";
        }
        echo json_encode($result);
    }  

    public function index()
    {
        $data = array(
            'judul' => 'Pangkat',
            'modul' => 'Data Pangkat',
            'list_modul' => 'List Data',
            'content' => 'pangkat/pangkat-data',
            'link_fetch_data' => site_url('pangkat/fetch_data'),
        );
        $this->load->view('backend/template', $data);
    }

    public function fetch_data()
    {
        // $this->model->check_is_ajax();
        $no = 0;
        $result = array('data' => array());
        $data = $this->mp->get_datatables();
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
                $this->model->select_data($value->nama_pangkat),
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
        $nama_pangkat = $this->model->input("nama_pangkat");
        $data = array(
            'nama_pangkat' => $this->model->input("nama_pangkat"),
            'created_by' => $this->model->GetSesLogin('kode'),
            'created_date' => $this->model->TanggalWaktu(),
        );
        if ($this->model->Simpan('pangkat', $data) == 1) {
            $this->model->SetLog("Tambah Pangkat pada nama = $nama_pangkat");
            $result['notif'] = 1;
        }
        echo json_encode($result);
    }

    public function EditData($kode='')
    {
        $this->model->check_is_ajax();
        $id = $this->model->select_data($kode);
        $result['notif'] = 0;
        $data = $this->model->GetCustomTable("pangkat", "where id = '$id' and is_deleted = 0");
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
        $nama_pangkat = $this->model->input("nama_pangkat");
        $data = array(
            'nama_pangkat' => $nama_pangkat,
            'last_modified_by' => $this->model->GetSesLogin('kode'),
            'last_modified_date' => $this->model->TanggalWaktu()
        );
        if ($this->model->Update("pangkat", $data, "id = '$id'") == 1) {
            $this->model->SetLog("Update Pangkat pada nama = ".$nama_pangkat);
            $result['notif'] = 1;
        }
        echo json_encode($result);
    }

    public function DeleteData($kode='')
    {
        $this->model->check_is_ajax();
        $result['notif'] = 0;
        $id = $this->model->select_data($kode);
        $gethapus = $this->model->GetCustomTable("pangkat", "where id = '$id'");
        if ($gethapus->num_rows() > 0) {
            if ($this->model->Hapus('pangkat', "id = '$id'") == 1) {
                $this->model->SetLog("Hapus Pangkat pada nama = ".$gethapus->row()->nama_pangkat);
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
        if($this->db->Hapus('pangkat') == 1){
            $this->model->SetLog("Reset Pangkat");
            $result['notif'] = 1;
        }
        echo json_encode($result);
    }
}

/* End of file pangkat.php */
/* Location: ./application/controllers/pangkat.php */