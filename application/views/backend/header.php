<script type="text/javascript">
  function akun_profil() {
    $('#akun_profil').modal('show');
  }
</script>
<header class="main-header">
  <a href="<?php echo base_url(); ?>dashboard" class="logo">Karya Siswa</a>
  <nav class="navbar navbar-static-top" role="navigation">
    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
      <span class="sr-only">Toggle navigation</span>
    </a>
    <div class="navbar-custom-menu">
      <ul class="nav navbar-nav">
        
        <li class="dropdown user-menu">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <span class="glyphicon glyphicon-user"></span><span class="hidden-xs"></span>
          </a>
          <ul class="dropdown-menu">
            <li><a href="#" onclick="akun_profil()">Profil</a></li>
            <li><a href="<?php echo site_url('akun/ganti_password');?>">Ganti Password</a></li>
            <?php if ($this->session->userdata('ses_karyasiswa_level') != "Admin"): ?>
            <li><a href="<?php echo site_url('akun/lapor');?>">Lapor Bug</a></li>
            <?php endif ?>
            <li><a href="#/logout" onclick="LogOut()">Logout</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </nav>
</header>
<div class="modal fade" id="akun_profil">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Profil Akun</h4>
      </div>
      <div class="modal-body">
        <div class="table-responsive">
          <table class="table" width="100%">
            <tr>
              <th width="20%">Kode User</th>
              <th width="2%">:</th>
              <th><?php echo $this->session->userdata('ses_karyasiswa_kode'); ?></th>
            </tr>
            <tr>
              <th>Nama User</th>
              <th>:</th>
              <th><?php echo $this->session->userdata('ses_karyasiswa_nama'); ?></th>
            </tr>
            <tr>
              <th>Akses</th>
              <th>:</th>
              <th><?php echo $this->session->userdata('ses_karyasiswa_level'); ?></th>
            </tr>
            <tr>
              <th>Username</th>
              <th>:</th>
              <th><?php echo $this->session->userdata('ses_karyasiswa_username'); ?></th>
            </tr>
            <tr>
              <th>Status</th>
              <th>:</th>
              <th><?php echo $this->session->userdata('ses_karyasiswa_status'); ?></th>
            </tr>
          </table>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
  function LogOut() {
    swal({
      title: "Logout ?",
      text: "Apakah anda yakin ?",
      type: "info",
      showCancelButton: true,
      confirmButtonClass: "btn-warning",
      confirmButtonText: "Ok",
      cancelButtonText: "Cancel",
      closeOnConfirm: true,
      closeOnCancel: true,
    },
    function(isConfirm) {
      if (isConfirm) {
        loading_start();
        setTimeout(function(){
          window.location.href = "<?php echo site_url('akun/logout')?>";          
        }, 2000);
      }
    });    
  }
</script>
