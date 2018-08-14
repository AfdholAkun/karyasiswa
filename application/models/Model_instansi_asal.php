<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_instansi_asal extends CI_Model {

	var $table = 'instansi_asal';
	var $column_order = array(null, 'nama_instansi',null);
	var $column_search = array('nama_instansi');
	var $where = "is_deleted = 0";
	var $order_default = "nama_instansi desc";
	
	public function __construct()
	{
		parent::__construct();
	}

	private function _get_datatables_query()
	{
		$this->db->from($this->table);
		$this->db->where($this->where);
		$i = 0;
		foreach ($this->column_search as $item) {
			if ($_POST['search']['value']) {
				if ($i === 0) {
					$this->db->group_start();
					$this->db->like($item, $_POST['search']['value']);
				}else{
					$this->db->or_like($item, $_POST['search']['value']);
				}
				if (count($this->column_search) - 1 == $i)
					$this->db->group_end();
			}
			$i++;
		}
		if (isset($_POST['order'])) {
			$this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		}else if(isset($this->order_default)){
			$this->db->order_by($this->order_default);
		}
	}

	function get_datatables()
	{
		$this->_get_datatables_query();
		if ($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered()
	{
		$this->_get_datatables_query();
		$query = $this->db->get();
		return $query->num_rows();
	}

	function count_all()
	{
		$this->db->from($this->table);
		$this->db->where($this->where);
		return $this->db->count_all_results	();
	}

}

/* End of file model_system_logs.php */
/* Location: ./application/models/model_system_logs.php */