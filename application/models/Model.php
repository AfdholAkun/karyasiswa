<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model extends CI_Model{

    public function SetLog($deskripsi)
    {
        $data = array(
            'id' => '',
            'kode_user' => $this->GetSesLogin('kode'),
            'deskripsi' => $deskripsi,
            'created_date' => $this->TanggalWaktu(),
        );
        $this->model->Simpan("system_logs", $data);
    }

    public function GetCustomTable($table, $where='')
    {
        return $this->db->query("SELECT * FROM $table $where");
    }

    public function Reset($table)
    {
        return $this->db->query("DELETE from ".$table);
    }

    public function Simpan($table, $data)
    {
        return $this->db->insert($table, $data);
    }  

    public function Update($table, $data, $where)
    {
        return $this->db->update($table, $data, $where);
    }

    public function Hapus($table, $where)
    {
        return $this->db->delete($table, $where);
    }

    public function getAi($table, $atribut)
    {
        $q = $this->db->query("SELECT MAX($atribut) as idmax from ".$table);
        if ($q->num_rows() > 0) {
            foreach ($q->result() as $k) {
                $kode = ((int)$k->idmax)+1;
            }
        }else{
            $kode = 1;
        }
        return $kode;
    }

    function getkodeunik($table, $atribut, $initial, $jumlah_0) {
        $q = $this->db->query("SELECT MAX(RIGHT($atribut, $jumlah_0)) AS idmax FROM ".$table);
        if($q->num_rows()>0){
            foreach($q->result() as $k){
                $kode = ((int)$k->idmax)+1;
            }
        }else{
            $kode = "1";
        }
        $bikin_kode = str_pad($kode, $jumlah_0, "0", STR_PAD_LEFT);
        $kode_jadi = "$initial$bikin_kode";
        return $kode_jadi;
    }

    function getkodeunikbk($table, $atribut, $initial, $jumlah_0) {
        $q = $this->db->query("SELECT MAX(RIGHT($atribut, $jumlah_0)) AS idmax FROM ".$table." WHERE status = '1'");
        if($q->num_rows()>0){
            foreach($q->result() as $k){
                $kode = ((int)$k->idmax)+1;
            }
        }else{
            $kode = "1";
        }
        $bikin_kode = str_pad($kode, $jumlah_0, "0", STR_PAD_LEFT);
        $kode_jadi = "$initial$bikin_kode";
        return $kode_jadi;
    }

    function getkodeunikp($table, $atribut, $initial, $jumlah_0) {
        date_default_timezone_set('Asia/Jakarta');
        $tanggal = date('Ymd');
        $q = $this->db->query("SELECT MAX(RIGHT($atribut, $jumlah_0)) AS idmax FROM $table where $atribut LIKE '%$tanggal%' and status = 1");
        if($q->num_rows()>0){
            foreach($q->result() as $k){
                $kode = ((int)$k->idmax)+1;
            }
        }else{
            $kode = "1";
        }
        $bikin_kode = str_pad($kode, $jumlah_0, "0", STR_PAD_LEFT);
        $kode_jadi = "$initial$tanggal$bikin_kode";
        return $kode_jadi;
    }

    function getkodeunikbaru($table, $atribut, $initial, $jumlah_0, $tgl) {
        date_default_timezone_set('Asia/Jakarta');
        $tanggal = str_replace('-', '', $tgl);
        $q = $this->db->query("SELECT MAX(RIGHT($atribut, $jumlah_0)) AS idmax FROM $table where $atribut LIKE '%$tanggal%' and status = 1");
        if($q->num_rows()>0){
            foreach($q->result() as $k){
                $kode = ((int)$k->idmax)+1;
            }
        }else{
            $kode = "1";
        }
        $bikin_kode = str_pad($kode, $jumlah_0, "0", STR_PAD_LEFT);
        $kode_jadi = "$initial$tanggal$bikin_kode";
        return $kode_jadi;
    }

    public function cek_tanggal($tgl_awal, $tgl_akhir)
    {
        $cek = $this->db->query("SELECT IF(DATE('$tgl_awal') <= DATE('$tgl_akhir'), 'oke', 'no') as y");
        return $cek->row()->y;
    }

    public function Tanggal()
    {
        date_default_timezone_set('Asia/Jakarta');
        return $tanggal = date('Y-m-d');
    }

    public function TanggalWaktu()
    {
        date_default_timezone_set('Asia/Jakarta');
        return $tanggal = date("Y-m-d H:i:s");
    }

    public function NullDate($value='')
    {
        if ($value === "0000-00-00") {
            $value = "";
        }
        return $value;
    }

    public function NullDateTime($value='')
    {
        if ($value === "0000-00-00 00:00:00") {
            $value = "";
        }
        return $value;
    }

    public function cek_login()
    {
        $ses_kode = $this->session->userdata('ses_karyasiswa_kode');
        if (!$this->session->userdata('ses_karyasiswa_kode')) {
            // echo json_encode(array('notif' => 400));
            redirect('login');
            // header("location:".URL.'login');
        }
        // else{
        //     $data = $this->GetCustomTable("user", "where kode_user = '$ses_kode'");
        //     if ($this->session->userdata('ses_karyasiswa_token') != $data->row()->token) {
        //         // echo '<script>location.href="'.URL.'login";</script>' ;
        //         // header("location:".URL.'login');
        //         // echo json_encode(array('notif' => 400));
        //         // redirect('login');
        //         // exit();
        //     }
        // }
    }

    public function CekLogin()
    {

        if (!$this->session->userdata('ses_karyasiswa_token')) {
            if (!$this->input->is_ajax_request()) {
                redirect('login');
            }else{
                echo json_encode(array('notif' => 401));
                exit();
            }
        }else{
            $ses_kode = $this->session->userdata('ses_karyasiswa_kode');
            $data = $this->GetCustomTable("user", "where kode_user = '$ses_kode'");
            if ($this->session->userdata('ses_karyasiswa_token') != $data->row()->token) {
                if (!$this->input->is_ajax_request()) {
                    redirect('login');
                }else{
                    echo json_encode(array('notif' => 401));
                    exit();
                }                   
            }
        }
    }

    public function cek_pengguna($level, $notif, $pesan, $link)
    {
        if ($this->session->userdata('ses_karyasiswa_level') == $level) {
            $this->session->set_flashdata($notif, $pesan);
            redirect($link);
        }
    }

    public function cek_user($level='')
    {
        if ($this->session->userdata('ses_karyasiswa_level') == $level) {
            show_404();
        }
    }

    public function cek_submit($atribut, $notif, $pesan, $link)
    {
        if (!isset($_POST[$atribut])) {
            $this->session->set_flashdata($notif, $pesan);
            redirect($link);
        }
    }

    public function cek_form($atribut, $notif, $pesan, $link)
    {
        if (!$this->input->post($atribut)) {
            $this->session->set_flashdata($notif, $pesan);
            show_404();
        }
    }

    public function cek_file($atribut, $notif, $pesan, $link)
    {
        if (!$_FILES[$atribut]['name']) {
            $this->session->set_flashdata($notif, $pesan);
            show_404();
        }
    }

    public function cek_uri($ke, $notif, $pesan, $link)
    {
        if ($this->uri->segment($ke) == '') {
            $this->session->set_flashdata($notif, $pesan);
            show_404();
        }
    }

    public function check_is_ajax()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }
    }

    public function check_is_submit($atribut)
    {
        if (!isset($_POST[$atribut])) {
            show_404();
        }
    }

    public function pesan($alert, $notif, $message)
    {
        echo "  <div class='alert $alert alert-dismissable'>
                    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                    <strong> $notif ! </strong> $message
                </div>";
    }

    public function message($alert, $notif, $message)
    {
        $result = "  <div class='alert $alert alert-dismissable'>
                    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                    <strong> $notif ! </strong> $message
                </div>";
        return $result;
    }

    public function input_data($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        return $data;
    }

    public function select_data($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    public function input($atribut)
    {
        return ltrim(addslashes($this->input_data($this->input->post($atribut))));
    }
    
    public function like($atri, $field)
    {
        $atribut = $this->input($atri);
        if($atribut == null){
            $result = $field." like '%$atribut%'";
        }else{
            $result = $field." = '$atribut'";
        }
        return $result;
    }

    public function where($atri, $field, $and)
    {
        $atribut = $this->input($atri);
        $result = "";
        if($atribut != ""){
            $result = $field." = '$atribut'";
            if ($and == true) {
                $result = "and ".$field." = '$atribut'";
            }
        }
        return $result;
    }

    public function GenerateString($length) 
    {
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        return substr(str_shuffle($chars), 0, $length);
    }    

    public function GetSesLogin($session)
    {
        return $this->session->userdata("ses_karyasiswa_".$session);
    }

}
?>