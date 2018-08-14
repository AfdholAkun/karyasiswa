<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Semester extends CI_Controller {


    public function __construct()
    {
        parent::__construct();
        $this->model->CekLogin();
        $this->load->model('Model_semester', 'ms');
        // $this->model->cek_user("Manager");
        // $this->model->cek_user("Warehouse");
    }

    public function index()
    {
        $data = array(
            'judul' => 'Semester',
            'modul' => 'Data Semester',
            'list_modul' => 'List Data',
            'content' => 'semester/semester-data',
            'link_fetch_data' => site_url('semester/fetch_data'),
        );
        $this->load->view('backend/template', $data);
    }

    public function fetch_data()
    {
        $this->model->check_is_ajax();
        $no = 0;
        $result = array('data' => array());
        $data = $this->ms->get_datatables();
        foreach ($data as $key => $value) { $no++;
            $id = $this->model->select_data($value->id_semester);
            $result['data'][$key] = array(
                $no,
                $this->model->select_data($value->id_semester),
                $this->model->select_data($value->nm_smt),
            );
        }
        $result['draw'] = $_POST['draw'];
        $result['recordsTotal'] = $this->ms->count_all();
        $result['recordsFiltered'] = $this->ms->count_filtered();
        echo json_encode($result);
    }

    public function InsertSemester()
    {
    	$this->model->check_is_ajax();
    	$result['notif'] = 0;
    	$GetMaxTahun = $this->db->query("SELECT max(tahun) as x FROM semester");
    	if ($GetMaxTahun->num_rows() > 0) {
    		$tahun = $GetMaxTahun->row()->x;
    	}else{
    		$tahun = date('Y');
    	}
    	$new = $tahun+1;
    	$newplus = $new+1;
    	$ganjil = $new.'/'.$newplus.' Ganjil';
    	$genap = $new.'/'.$newplus.' Genap';
    	if($this->db->query("INSERT INTO semester VALUES('".$new."1', '$new', '1', '', '$ganjil', NULL, NULL, '0')") == 1){
	    	if($this->db->query("INSERT INTO semester VALUES('".$new."2', '$new', '2', '', '$genap', NULL, NULL, '0')") == 1){
	    		$result['notif'] = 1;
	    	}
    	}
    	echo json_encode($result);
    }
}

/* End of file semester.php */
/* Location: ./application/controllers/semester.php */