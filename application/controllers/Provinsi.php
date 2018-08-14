<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Provinsi extends CI_Controller {


    public function __construct()
    {
        parent::__construct();
        $this->model->CekLogin();
        $this->load->model('Model_provinsi', 'mp');
        // $this->model->cek_user("Manager");
        // $this->model->cek_user("Warehouse");
    }

    public function CountTable()
    {
        $this->model->check_is_ajax();
        $count_table = $this->model->GetCustomTable("provinsi", "where is_deleted = 0")->num_rows();
        $result['value'] = $count_table;
        echo json_encode($result);
    }

	public function CekKodeProvinsi()
    {
        $this->model->check_is_ajax();
        $result = array();
        $kode = $this->model->input('kode');
        $kode_lama = $this->model->input('kode_lama');
        $cek = $this->model->GetCustomTable("provinsi", "where kode = '$kode' and is_deleted = 0")->num_rows();
        if ($kode == '') {
            $result['value'] = "*Kode tidak boleh kosong";
        }else if($kode != $kode_lama and $cek > 0){
            $result['value'] = "*Kode sudah ada";
        }else if(strlen($kode) < 1 or strlen($kode) > 10){
            $result['value'] = "*Kode 1-10 character";
        }else{
            $result['value'] = "*Kode tersedia";
        }
        echo json_encode($result);
    }     

    public function index()
    {
        $data = array(
            'judul' => 'Provinsi',
            'modul' => 'Data Provinsi',
            'list_modul' => 'List Data',
            'content' => 'provinsi/provinsi-data',
            'link_fetch_data' => site_url('provinsi/fetch_data'),
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
            $id = $this->model->select_data($value->kode);
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
                $this->model->select_data($value->nama_provinsi),
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
        $kode = $this->model->input("kode");
        $data = array(
        	'kode' => $kode,
            'nama_provinsi' => $this->model->input("nama_provinsi"),
            'created_by' => $this->model->GetSesLogin('kode'),
            'created_date' => $this->model->TanggalWaktu(),
        );
        if ($this->model->Simpan('provinsi', $data) == 1) {
            $this->model->SetLog("Tambah Provinsi pada kode = $kode");
            $result['notif'] = 1;
        }
        echo json_encode($result);
    }

    public function EditData($kode='')
    {
        $this->model->check_is_ajax();
        $result['notif'] = 0;
        $id = $this->model->select_data($kode);
        $data = $this->model->GetCustomTable("provinsi", "where kode = '$id' and is_deleted = 0");
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
        $kode = $this->model->input("kode");
        $kode_lama = $this->model->input("kode_lama");
        $data = array(
        	'kode' => $kode,
            'nama_provinsi' => $this->model->input("nama_provinsi"),
            'last_modified_by' => $this->model->GetSesLogin('kode'),
            'last_modified_date' => $this->model->TanggalWaktu()
        );
        if ($this->model->Update("provinsi", $data, "kode = '$kode_lama'") == 1) {
            $this->model->SetLog("Update Provinsi pada kode = ".$kode_lama);
            $result['notif'] = 1;
        }
        echo json_encode($result);
    }

    public function DeleteData($kode='')
    {
        $this->model->check_is_ajax();
        $result['notif'] = 0;
        $id = $this->model->select_data($kode);
        $gethapus = $this->model->GetCustomTable("provinsi", "where kode = '$id'");
        if ($gethapus->num_rows() > 0) {
            if ($this->model->Hapus('provinsi',"kode = '$id'") == 1) {
                $this->model->SetLog("Hapus Provinsi pada kode = ".$id);
                $result['notif'] = 1;
            }
        }else{
            $result['notif'] = 2; //data tidak ditemukan
        }
        echo json_encode($result);
    }

    public function ResetData()
    {
        $this->model->check_is_ajax();
        $result['notif'] = 0;
        if($this->db->Hapus('provinsi') == 1){
            $this->model->SetLog("Reset Provinsi");
            $result['notif'] = 1;
        }
        echo json_encode($result);
    }
}

/* End of file provinsi.php */
/* Location: ./application/controllers/provinsi.php */