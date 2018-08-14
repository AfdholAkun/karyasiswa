<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class System_logs extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->model->cek_login();
        $this->load->model('Model_system_logs', 'ms');
    }

	public function CountTable()
    {
        $this->model->check_is_ajax();
        $count = $this->model->GetCustomTable("system_logs", "order by kode_user asc")->num_rows();
        echo $count;
    } 

    public function index()
    {
        $data = array(
			'judul' => 'System',
            'modul' => 'System Logs',
            'list_modul' => 'List Data',
            'content' => 'system/system-logs-data',
            'link_fetch_data' => site_url('system_logs/fetch_data'),        	
            'user' => $this->model->GetCustomTable("user", "order by kode_user asc")
        );
        $this->load->view('backend/template', $data);
    }   

    public function fetch_data()
    {
        $this->model->check_is_ajax();
        // $result = array('data' => array());
        $no = $_POST['start'];
        $data = $this->ms->get_datatables();
        foreach ($data as $key => $value) { $no++;
            $result['data'][] = array(
                $no,
                $this->model->select_data($value->created_date),
                $this->model->select_data($value->kode_user),
                $this->model->select_data($value->name_user),
                $this->model->select_data($value->level),
                $this->model->select_data($value->deskripsi),
            );
        }
        // foreach ($list as $d) {
        //     $no++;
        //     $row = array();
        //     $row[] = $no;
        //     $row[] = $d->created_date;
        //     $row[] = $d->kode_user;
        //     $row[] = $d->name_user;
        //     $row[] = $d->deskripsi;
        //     $data[] = $row;
        // }
        // $result['data'] = $data;
        $result['draw'] = $_POST['draw'];
        $result['recordsTotal'] = $this->ms->count_all();
        $result['recordsFiltered'] = $this->ms->count_filtered();
        echo json_encode($result);
    }

    public function ResetData()
    {
        $this->model->check_is_ajax();
        $result['notif'] = 0;
        if($this->model->Reset('system_logs')){
            $result['notif'] = 1;
        }
        echo json_encode($result);
    }

}

/* End of file system_logs.php */
/* Location: ./application/controllers/system_logs.php */