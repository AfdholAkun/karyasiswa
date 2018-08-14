<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Model_daftar_peserta_karyasiswa', 'mdpk');
	}

	public function daftar_peserta_karyasiswa()
    {
        $data = array(
            'judul' => 'Laporan Karya Siswa',
            'modul' => 'Laporan Karya Siswa',
            'list_modul' => 'List Data',
            'content' => 'laporan/laporan-daftar-peserta-karyasiswa/laporan-daftar-peserta-karyasiswa-data',
            'link_fetch_data' => site_url(''),
            'jenjang_studi' => $this->model->GetCustomTable("jenjang_studi", "where is_deleted = 0"),
            'keterangan_karyasiswa' => $this->model->GetCustomTable("keterangan_karyasiswa", "where is_deleted = 0"),
        );
        $this->load->view('backend/template', $data);
    }

    public function fetch_data_daftar_peserta_karyasiswa()
    {
    	
        $this->model->check_is_ajax();
        $no = 0;
        $result = array('data' => array());
        $data = $this->mdpk->get_datatables();
        foreach ($data as $key => $value) { $no++;
            $result['data'][$key] = array(
                $no,
                $this->model->select_data($value->nip),
                $this->model->select_data($value->nama),
                $this->model->select_data($value->nama_universitas),
                $this->model->select_data($value->nama_jenjang_studi),
                $this->model->select_data($value->nama_keterangan),
            );
        }
        $result['draw'] = $_POST['draw'];
        $result['recordsTotal'] = $this->mdpk->count_all();
        $result['recordsFiltered'] = $this->mdpk->count_filtered();
        echo json_encode($result);
    }

    public function daftar_peserta_karyasiswa_excel()
    {
        $this->model->check_is_submit("excel_report");
        $where_id_jenjang = $this->model->where('id_jenjang_studi', 'id_jenjang_studi', false);
        $where_dl = $this->model->where('dl', 'dl', true);
        $where_id_keterangan = $this->model->where('id_keterangan', 'id_keterangan', true);
        $data_result = $this->model->GetCustomTable("v_karyasiswa_log", "where $where_id_jenjang $where_dl $where_id_keterangan and is_deleted = 0");
        $data = array(
            'data_result' => $data_result,    
        );    
        $this->load->view('laporan/laporan-daftar-peserta-karyasiswa/laporan-daftar-peserta-karyasiswa-excel', $data, FALSE);
    }

}

/* End of file laporan.php */
/* Location: ./application/controllers/laporan.php */