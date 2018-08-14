<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bidang_studi extends CI_Controller {


    public function __construct()
    {
        parent::__construct();
        $this->model->CekLogin();
        $this->load->model('Model_bidang_studi', 'mds');
        // $this->model->cek_user("Manager");
        // $this->model->cek_user("Warehouse");
    }

    public function CountTable()
    {
        $this->model->check_is_ajax();
        $count_table = $this->model->GetCustomTable("bidang_studi", "where is_deleted = 0")->num_rows();
        $result['value'] = $count_table;
        echo json_encode($result);
    }

    public function CekNamaBidangStudi()
    {
        $this->model->check_is_ajax();
        $result = array();
        $nama_bidang_studi = $this->model->input('nama_bidang_studi');
        $nama_bidang_studi_lama = $this->model->input('nama_bidang_studi_lama');
        $cek = $this->model->GetCustomTable("bidang_studi", "where nama_bidang_studi = '$nama_bidang_studi' and is_deleted = 0")->num_rows();
        if ($nama_bidang_studi == '') {
            $result['value'] = "*Bidang Studi tidak boleh kosong";
        }else if($nama_bidang_studi != $nama_bidang_studi_lama and $cek > 0){
            $result['value'] = "*Bidang Studi sudah ada";
        }else if(strlen($nama_bidang_studi) < 1 or strlen($nama_bidang_studi) > 100){
            $result['value'] = "*Bidang Studi 1-100 character";
        }else{
            $result['value'] = "*Bidang Studi tersedia";
        }
        echo json_encode($result);
    }  

    public function index()
    {
        $data = array(
            'judul' => 'Bidang Studi',
            'modul' => 'Data Bidang Studi',
            'list_modul' => 'List Data',
            'content' => 'bidang-studi/bidang-studi-data',
            'link_fetch_data' => site_url('bidang_studi/fetch_data'),
        );
        $this->load->view('backend/template', $data);
    }

    public function fetch_data()
    {
        $this->model->check_is_ajax();
        $no = 0;
        $data = $this->mds->get_datatables();
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
                $this->model->select_data($value->nama_bidang_studi),
                $opsi,
            );
        }
        $result['draw'] = $_POST['draw'];
        $result['recordsTotal'] = $this->mds->count_all();
        $result['recordsFiltered'] = $this->mds->count_filtered();
        echo json_encode($result);
    }

    public function InsertData()
    {
        $this->model->check_is_ajax();
        $result['notif'] = 0;
        $nama_bidang_studi = $this->model->input("nama_bidang_studi");
        $data = array(
            'nama_bidang_studi' => $this->model->input("nama_bidang_studi"),
            'created_by' => $this->model->GetSesLogin('kode'),
            'created_date' => $this->model->TanggalWaktu(),
        );
        if ($this->model->Simpan('bidang_studi', $data) == 1) {
            $this->model->SetLog("Tambah Bidang Studi pada nama = $nama_bidang_studi");
            $result['notif'] = 1;
        }
        echo json_encode($result);
    }

    public function EditData($kode='')
    {
        $this->model->check_is_ajax();
        $id = $this->model->select_data($kode);
        $result['notif'] = 0;
        $data = $this->model->GetCustomTable("bidang_studi", "where id = '$id' and is_deleted = 0");
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
        $nama_bidang_studi = $this->model->input("nama_bidang_studi");
        $data = array(
            'nama_bidang_studi' => $nama_bidang_studi,
            'last_modified_by' => $this->model->GetSesLogin('kode'),
            'last_modified_date' => $this->model->TanggalWaktu()
        );
        if ($this->model->Update("bidang_studi", $data, "id = '$id'") == 1) {
            $this->model->SetLog("Update Bidang Studi pada nama = ".$nama_bidang_studi);
            $result['notif'] = 1;
        }
        echo json_encode($result);
    }

    public function DeleteData($kode='')
    {
        $this->model->check_is_ajax();
        $result['notif'] = 0;
        $id = $this->model->select_data($kode);
        $gethapus = $this->model->GetCustomTable("bidang_studi", "where id = '$id'");
        if ($gethapus->num_rows() > 0) {
            if ($this->model->Hapus('bidang_studi', "id = '$id'") == 1) {
                $this->model->SetLog("Hapus Bidang Studi pada nama = ".$gethapus->row()->nama_bidang_studi);
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
        if($this->db->Reset('bidang_studi') == 1){
            $this->model->SetLog("Reset Bidang Studi");
            $result['notif'] = 1;
        }
        echo json_encode($result);
    }
}

/* End of file bidang_studi.php */
/* Location: ./application/controllers/bidang_studi.php */