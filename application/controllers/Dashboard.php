<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_dashboard', 'md');
    }
	
    public function index()
    {
        $data = array(
            'judul' => 'Dashboard',
            'modul' => 'Dashboard',
            'list_modul' => 'List Dashboard',
            'content' => 'dashboard/dashboard-data',
            'link_fetch_data' => site_url(''),
            'GrafikKaryaSiswaTahun' => $this->md->GrafikKaryaSiswaTahun(""),
            'KeteranganKaryasiswa' => $this->model->GetCustomTable("keterangan_karyasiswa", "where is_deleted = 0"),
        );
        $this->load->view('backend/template', $data);
    }

}

/* End of file dashboard.php */
/* Location: ./application/controllers/dashboard.php */