<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Keterangan_karyasiswa extends CI_Controller {


    public function __construct()
    {
        parent::__construct();
        $this->model->CekLogin();
        $this->load->model('Model_keterangan_karyasiswa', 'mk');
        // $this->model->cek_user("Manager");
        // $this->model->cek_user("Warehouse");
    }

    public function CountTable()
    {
        $this->model->check_is_ajax();
        $count_table = $this->model->GetCustomTable("keterangan_karyasiswa", "where is_deleted = 0")->num_rows();
        $result['value'] = $count_table;
        echo json_encode($result);
    }

    public function CekNamaKeterangan()
    {
        $this->model->check_is_ajax();
        $result = array();
        $nama_keterangan = $this->model->input('nama_keterangan');
        $nama_keterangan_lama = $this->model->input('nama_keterangan_lama');
        $cek = $this->model->GetCustomTable("keterangan_karyasiswa", "where nama_keterangan = '$nama_keterangan' and is_deleted = 0")->num_rows();
        if ($nama_keterangan == '') {
            $result['value'] = "*Keterangan tidak boleh kosong";
        }else if($nama_keterangan != $nama_keterangan_lama and $cek > 0){
            $result['value'] = "*Keterangan sudah ada";
        }else if(strlen($nama_keterangan) < 2 or strlen($nama_keterangan) > 35){
            $result['value'] = "*Keterangan 2-35 character";
        }else{
            $result['value'] = "*Keterangan tersedia";
        }
        echo json_encode($result);
    }  

    public function index()
    {
        $data = array(
            'judul' => 'Keterangan Karya Siswa',
            'modul' => 'Data Keterangan Karya Siswa',
            'list_modul' => 'List Data',
            'content' => 'keterangan-karyasiswa/keterangan-karyasiswa-data',
            'link_fetch_data' => site_url('Keterangan_karyasiswa/fetch_data'),
        );
        $this->load->view('backend/template', $data);
    }

    public function fetch_data()
    {
        $this->model->check_is_ajax();
        $no = 0;
        $result = array('data' => array());
        $data = $this->mk->get_datatables();
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
                $this->model->select_data($value->nama_keterangan),
                $opsi,
            );
        }
        $result['draw'] = $_POST['draw'];
        $result['recordsTotal'] = $this->mk->count_all();
        $result['recordsFiltered'] = $this->mk->count_filtered();
        echo json_encode($result);
    }

    public function InsertData()
    {
        $this->model->check_is_ajax();
        $result['notif'] = 0;
        $nama_keterangan = $this->model->input("nama_keterangan");
        $data = array(
            'nama_keterangan' => $this->model->input("nama_keterangan"),
            'created_by' => $this->model->GetSesLogin('kode'),
            'created_date' => $this->model->TanggalWaktu(),
        );
        if ($this->model->Simpan('Keterangan_karyasiswa', $data) == 1) {
            $this->model->SetLog("Tambah Keterangan pada nama = $nama_keterangan");
            $result['notif'] = 1;
        }
        echo json_encode($result);
    }

    public function EditData($kode='')
    {
        $this->model->check_is_ajax();
        $id = $this->model->select_data($kode);
        $result['notif'] = 0;
        $data = $this->model->GetCustomTable("keterangan_karyasiswa", "where id = '$id' and is_deleted = 0");
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
        $nama_keterangan = $this->model->input("nama_keterangan");
        $data = array(
            'nama_keterangan' => $nama_keterangan,
            'last_modified_by' => $this->model->GetSesLogin('kode'),
            'last_modified_date' => $this->model->TanggalWaktu()
        );
        if ($this->model->Update("keterangan_karyasiswa", $data, "id = '$id'") == 1) {
            $this->model->SetLog("Update Keterangan pada nama = ".$nama_keterangan);
            $result['notif'] = 1;
        }
        echo json_encode($result);
    }

    public function DeleteData($kode='')
    {
        $this->model->check_is_ajax();
        $result['notif'] = 0;
        $id = $this->model->select_data($kode);
        $gethapus = $this->model->GetCustomTable("keterangan_karyasiswa", "where id = '$id'");
        if ($gethapus->num_rows() > 0) {
            if ($this->model->Hapus('keterangan_karyasiswa', "id = '$id'") == 1) {
                $this->model->SetLog("Hapus Keterangan pada nama = ".$gethapus->row()->nama_keterangan);
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
        if($this->db->Hapus('keterangan_karyasiswa') == 1){
            $this->model->SetLog("Reset Keterangan");
            $result['notif'] = 1;
        }
        echo json_encode($result);
    }
}

/* End of file keterangan.php */
/* Location: ./application/controllers/keterangan.php */