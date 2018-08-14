<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class System_backup extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->model->cek_login();
        $this->model->cek_user("Manager");
        $this->model->cek_user("Warehouse");
    }

    public function index()
    {
        $data = array(
            'judul' => 'System',
            'modul' => 'System Backup',
            'list_modul' => 'List Backup',
            'content' => 'system/system-backup-data',
            'link_fetch_data' => '',
        );
        $this->load->view('backend/template', $data);
    }

    public function db()
    {
        $this->model->SetLog("Backup Database");
        $this->load->dbutil();

        $prefs = array(
            'format' => 'zip',
            'filename' => 'karyasiswa.sql'
        );

        $backup =& $this->dbutil->backup($prefs);

        $db_name = 'karyasiswa-backup-on-' . $this->model->TanggalWaktu() . '.zip'; // file name
        $save  = 'backup/db/' . $db_name; // dir name backup output destination

        $this->load->helper('file');
        write_file($save, $backup);

        $this->load->helper('download');
        force_download($db_name, $backup);
    }

    function files()
    {
        $this->model->SetLog("Backup Files");
        $opt = array(
            'src' => 'D:xampp/htdocs/karyasiswa/', // dir name to backup
            'dst' => '' // dir name backup output destination
        );

        // Codeigniter v3x
        $this->load->library('recurseZip_lib', $opt);
        $download = $this->recursezip_lib->compress();

        redirect(base_url($download));
    }

}

/* End of file system_backup.php */
/* Location: ./application/controllers/system_backup.php */