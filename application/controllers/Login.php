<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	}

    public function index()
    {
        // $this->hapus_status_false();
        $this->session->unset_userdata('ses_karyasiswa_id');
        $this->session->unset_userdata('ses_karyasiswa_nama');
        $this->session->unset_userdata('ses_karyasiswa_level');
        $this->session->unset_userdata('ses_karyasiswa_username');
        $this->session->unset_userdata('ses_karyasiswa_status');
        $this->load->view('akun/akun-login');
    }

    public function LogIn()
    {
        $result['notif'] = 0;
        $username = $this->model->input("username");
        $password = md5($this->model->input("password"));
        $token = md5($this->model->GenerateString(32));
        $cek = $this->model->GetCustomTable("user", "where username = '$username' and password = '$password'");
        if ($cek->num_rows() > 0) {
            $d = $cek->row();
            if ($d->status == "Aktif") {
                $data = array(
                    'ses_karyasiswa_kode' => $d->kode_user,
                    'ses_karyasiswa_nama' => $d->name_user,
                    'ses_karyasiswa_level' => $d->level,
                    'ses_karyasiswa_username' => $d->username,
                    'ses_karyasiswa_email' => $d->email,
                    'ses_karyasiswa_status' => $d->status,
                    'ses_karyasiswa_token' => $token,
                );
                if ($this->model->Update("user", array('token' => $token), "kode_user = '$d->kode_user'") == 1){
                    $this->session->set_userdata($data);
                    $this->model->SetLog("Login, IP = ".$this->input->ip_address());
                    $result['notif'] = 1;
                }
            }else{
                $result['notif'] = 2;// akun tidak aktif
            }
        }
        echo json_encode($result);
    }    

}

/* End of file login.php */
/* Location: ./application/controllers/login.php */