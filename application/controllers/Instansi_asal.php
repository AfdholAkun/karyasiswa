<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Instansi_asal extends CI_Controller {


    public function __construct()
    {
        parent::__construct();
        $this->model->CekLogin();
        $this->load->model('Model_instansi_asal', 'mia');
        // $this->model->cek_user("Manager");
        // $this->model->cek_user("Warehouse");
    }

    public function CountTable()
    {
        $this->model->check_is_ajax();
        $count_table = $this->model->GetCustomTable("instansi_asal", "where is_deleted = 0")->num_rows();
        $result['value'] = $count_table;
        echo json_encode($result);
    }

    public function CekNamaInstansi()
    {
        $this->model->check_is_ajax();
        $result = array();
        $nama_instansi = $this->model->input('nama_instansi');
        $nama_instansi_lama = $this->model->input('nama_instansi_lama');
        $cek = $this->model->GetCustomTable("instansi_asal", "where nama_instansi = '$nama_instansi' and is_deleted = 0")->num_rows();
        if ($nama_instansi == '') {
            $result['value'] = "*Instansi tidak boleh kosong";
        }else if($nama_instansi != $nama_instansi_lama and $cek > 0){
            $result['value'] = "*Instansi sudah ada";
        }else if(strlen($nama_instansi) < 5 or strlen($nama_instansi) > 100){
            $result['value'] = "*Instansi 5-100 character";
        }else{
            $result['value'] = "*Instansi tersedia";
        }
        echo json_encode($result);
    }  

    public function index()
    {
        $data = array(
            'judul' => 'Instansi',
            'modul' => 'Data Instansi',
            'list_modul' => 'List Data',
            'content' => 'instansi-asal/instansi-asal-data',
            'link_fetch_data' => site_url('instansi_asal/fetch_data'),
        );
        $this->load->view('backend/template', $data);
    }

    public function fetch_data()
    {
        $this->model->check_is_ajax();
        $no = 0;
        $result = array('data' => array());
        $data = $this->mia->get_datatables();
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
                $this->model->select_data($value->nama_instansi),
                $opsi,
            );
        }
        $result['draw'] = $_POST['draw'];
        $result['recordsTotal'] = $this->mia->count_all();
        $result['recordsFiltered'] = $this->mia->count_filtered();
        echo json_encode($result);
    }

    public function InsertData()
    {
        $this->model->check_is_ajax();
        $result['notif'] = 0;
        $nama_instansi = $this->model->input("nama_instansi");
        $data = array(
            'nama_instansi' => $this->model->input("nama_instansi"),
            'created_by' => $this->model->GetSesLogin('kode'),
            'created_date' => $this->model->TanggalWaktu(),
        );
        if ($this->model->Simpan('instansi_asal', $data) == 1) {
            $this->model->SetLog("Tambah Instansi pada nama = $nama_instansi");
            $result['notif'] = 1;
        }
        echo json_encode($result);
    }

    public function EditData($kode='')
    {
        $this->model->check_is_ajax();
        $id = $this->model->select_data($kode);
        $result['notif'] = 0;
        $data = $this->model->GetCustomTable("instansi_asal", "where id = '$id' and is_deleted = 0");
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
        $nama_instansi = $this->model->input("nama_instansi");
        $data = array(
            'nama_instansi' => $nama_instansi,
            'last_modified_by' => $this->model->GetSesLogin('kode'),
            'last_modified_date' => $this->model->TanggalWaktu()
        );
        if ($this->model->Update("instansi_asal", $data, "id = '$id'") == 1) {
            $this->model->SetLog("Update Instansi pada nama = ".$nama_instansi);
            $result['notif'] = 1;
        }
        echo json_encode($result);
    }

    public function DeleteData($kode='')
    {
        $this->model->check_is_ajax();
        $result['notif'] = 0;
        $id = $this->model->select_data($kode);
        $gethapus = $this->model->GetCustomTable("instansi_asal", "where id = '$id'");
        if ($gethapus->num_rows() > 0) {
            if ($this->model->Hapus('instansi_asal', "id = '$id'") == 1) {
                $this->model->SetLog("Hapus Instansi pada nama = ".$gethapus->row()->nama_instansi);
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
        if($this->db->Reset('instansi_asal') == 1){
            $this->model->SetLog("Reset Instansi");
            $result['notif'] = 1;
        }
        echo json_encode($result);
    }
}

/* End of file instansi_asal.php */
/* Location: ./application/controllers/instansi_asal.php */