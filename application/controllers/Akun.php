<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Akun extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->model->cek_login();
    }

    public function ganti_password()
    {
        $data = array(
            'judul' => 'Akun',
            'modul' => 'Akun',
            'list_modul' => 'Ganti Password',
            'content' => 'akun/akun-ganti-password',
            'link_fetch_data' => site_url(),
            'ses_level' => $this->session->userdata('ses_karyasiswa_level'),
        );
        $this->load->view('backend/template', $data);
    }

    public function AksiGantiPassword()
    {
        $this->model->check_is_ajax();
        $result['notif'] = 0;
        $ses_kode = $this->session->userdata('ses_karyasiswa_kode');
        $tampil = $this->model->GetCustomTable("user", "where kode_user = '$ses_kode'")->row();
        $password = $tampil->password;
        $password_lama = md5($this->model->input("password_lama"));
        $password_baru = md5($this->model->input("password_baru"));
        $ulangi_password_baru = md5($this->model->input("ulangi_password_baru"));
        if ($password != $password_lama) {
            $result['notif'] = 2; // Password tkodeak valkode
        }elseif ($password_baru != $ulangi_password_baru){
            $result['notif'] = 3; // Password baru dan ulangi password tkodeak valkode
        }else{
            $data = array(
                'password' => $password_baru,
            );
            if ($this->model->Update('user', $data, array('kode_user' => $ses_kode)) == 1){
                // $this->model->SetLog("Ganti Password");
                $result['notif'] = 1;
            }
        }
        echo json_encode($result);
    }

    public function logout()
    {
        $this->model->SetLog("Logout");
        $this->session->unset_userdata('ses_karyasiswa_kode');
        $this->session->unset_userdata('ses_karyasiswa_nama');
        $this->session->unset_userdata('ses_karyasiswa_level');
        $this->session->unset_userdata('ses_karyasiswa_username');
        $this->session->unset_userdata('ses_karyasiswa_status');
        $this->session->unset_userdata('ses_karyasiswa_token');
        redirect('login');
    }

}

/* End of file akun.php */
/* Location: ./application/controllers/akun.php */