<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->model->CekLogin();
        $this->load->model('Model_user', 'mu');
    }

    public function CekEmail()
    {
        $this->model->check_is_ajax();
        $result = array();
        $email = $this->model->input('email');
        $email_lama = $this->model->input('email_lama');
        $cek_user = $this->model->GetCustomTable("user", "where email = '$email'")->num_rows();
        if ($email == '') {
            $result['value'] = "*Email tidak boleh kosong";
        }else if($email != $email_lama and $cek_user > 0){
            $result['value'] = "*Email sudah ada";
        }else{
            $result['value'] = "*Email tersedia";
        }
        echo json_encode($result);
    }   

    public function CekUsername()
    {
        $this->model->check_is_ajax();
        $result = array(); 
        $username = $this->model->input('username');
        $cek_user = $this->model->GetCustomTable("user", "where username = '$username'")->num_rows();
        if ($username == '') {
            $result['value'] = "*Username tidak boleh kosong";
        }else if($cek_user > 0){
            $result['value'] = "*Username sudah ada";
        }else if(strlen($username) < 5 or strlen($username) > 35){
            $result['value'] = "*Username 5-35 character";
        }else{
            $result['value'] = "*Username tersedia";
        }
        echo json_encode($result);
    } 

    public function CountTable()
    {
        $this->model->check_is_ajax();
        $count_table = $this->model->GetCustomTable("user", "where is_deleted = 0")->num_rows();
        $result['value'] = $count_table;
        echo json_encode($result);
    }

    public function index()
    {
        $data = array(
            'judul' => 'User',
            'modul' => 'Data User',
            'list_modul' => 'List Data',
            'content' => 'user/user-data',
            'link_fetch_data' => site_url('user/fetch_data'),
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
            $id = $this->model->select_data($value->kode_user);
            $opsi = "
				<center>
                    <button class='btn btn-default btn-sm btn-flat' onclick='DetailData(".'"'."$id".'"'.")'> Detail</button>
					<button class='btn btn-default btn-sm btn-flat' onclick='EditData(".'"'."$id".'"'.")'> Edit</button>
					<button class='btn btn-default btn-sm btn-flat' onclick='DeleteData(".'"'."$id".'"'.")'> Hapus</button>
				</center>		
				";
            $result['data'][$key] = array(
                $no,
                $this->model->select_data($value->kode_user),
                $this->model->select_data($value->name_user),
                $this->model->select_data($value->email),
                $this->model->select_data($value->level),
                $this->model->select_data($value->status),
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
        $kode_user = $this->model->getkodeunik("user","kode_user", "U-", "3");
        $data = array(
            'kode_user' => $kode_user,
            'name_user' => $this->model->input("name_user"),
            'email' => $this->model->input("email"),
            'username' => $this->model->input("username"),
            'password' => md5($this->model->input("password")),
            'level' => $this->model->input("level"),
            'status' => $this->model->input("user_status"),
            'created_by' => $this->model->GetSesLogin('kode'),
            'created_date' => $this->model->TanggalWaktu(),
        );
        if ($this->model->Simpan('user', $data) == 1) {
            $this->model->SetLog("Tambah User dengan kode user = $kode_user");
            $result['notif'] = 1;
        }
        echo json_encode($result);
    }

    public function EditData($kode='')
    {
        $this->model->check_is_ajax();
        $id = $this->model->select_data($kode);
        $result['notif'] = 0;
        $data = $this->model->GetCustomTable("user", "where kode_user = '$id' and is_deleted = 0");
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
        $data = array(
            'name_user' => $this->model->input("name_user"),
            'email' => $this->model->input("email"),
            'level' => $this->model->input("level"),
            'status' => $this->model->input("user_status"),
            'last_modified_by' => $this->model->GetSesLogin('kode'),
            'last_modified_date' => $this->model->TanggalWaktu()
        );
        if ($this->model->Update('user', $data, array('kode_user' => $this->model->input('kode_user'))) == 1) {
            $this->model->SetLog("Update User dengan kode user = ".$this->model->input('kode_user'));
            $result['notif'] = 1;
        }
        echo json_encode($result);
    }

    public function DeleteData($kode='')
    {
        $this->model->check_is_ajax();
        $result['notif'] = 0;
        $id = $this->model->select_data($kode);
        $gethapus = $this->model->GetCustomTable("user", "where kode_user = '$id'");
        $data = array(
            'status' => 'Nonaktif',
            'is_deleted' => 1,
            'deleted_by' => $this->model->GetSesLogin('kode'),
            'deleted_date' => $this->model->TanggalWaktu(),
            );
        if ($gethapus->num_rows() > 0) {
            if ($this->model->Update('user', $data, "kode_user = '$id'") == 1) {
                $this->model->SetLog("Hapus User dengan kode user = ".$id);
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
            'status' => 'Nonaktif',
            'is_deleted' => 1,
            'deleted_by' => $this->model->GetSesLogin('kode'),
            'deleted_date' => $this->model->TanggalWaktu(),
        );
        if($this->db->update('user', $data, "is_deleted = 0") == 1){
            $this->model->SetLog("Reset User");
            $result['notif'] = 1;
        }
        echo json_encode($result);
    }

    public function laporan()
    {
        $data = array(
            'judul' => 'User',
            'modul' => 'Laporan User',
            'list_modul' => 'List Data',
            'link_fetch_data' => site_url('user/fetch_data_laporan'),
            'content' => 'user/user-report',
        );
        $this->load->view('backend/template', $data);
    }

    public function fetch_data_laporan()
    {
        $this->model->check_is_ajax();
        $no = 0;
        $result = array('data' => array());
        $data = $this->model->GetCustomTable("user", "where is_deleted = 0 order by kode_user asc")->result();
        foreach ($data as $key => $value) { $no++;
            $result['data'][$key] = array(
                $no,
                $this->model->select_data($value->kode_user),
                $this->model->select_data($value->name_user),
                $this->model->select_data($value->email),
                $this->model->select_data($value->level),
                $this->model->select_data($value->status),
            );
        }
        echo json_encode($result);
    }

    public function ReportExcel()
    {
        $this->model->SetLog("Laporan Excel User");
        $data = array(
            'data_result' => $this->model->GetCustomTable("user", "where is_deleted = 0 order by kode_user asc")->result(),
            'title' => "Laporan User",
            'tanggal_cetak' => $this->model->tanggal(),
        );
        $this->load->view('user/user-excel', $data);
    }

}

/* End of file user.php */
/* Location: ./application/controllers/user.php */