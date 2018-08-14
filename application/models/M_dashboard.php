<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_dashboard extends CI_Model {

    public function GrafikKaryaSiswaTahun($where='')
    {
        return $this->db->query("SELECT id_keterangan as x, nama_keterangan as y, COUNT(id_keterangan) as jumlah, YEAR(mulai_pendidikan) as tahun FROM `v_karyasiswa_log` $where GROUP BY year(mulai_pendidikan), id_keterangan ");
    }

}

/* End of file m_dashboard.php */
/* Location: ./application/models/m_dashboard.php */