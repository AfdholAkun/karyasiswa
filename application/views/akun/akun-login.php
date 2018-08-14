<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Karya Siswa PUSDIKLAT</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <?php $this->load->view('backend/load'); ?>
    <?php $this->load->view('backend/icon'); ?>
    <style>

        .z-depth-0 {
            box-shadow: none !important;
        }

        .z-depth-1{
            box-shadow: 0 2px 2px 0 rgba(0, 0, 0, 0.14), 0 1px 5px 0 rgba(0, 0, 0, 0.12), 0 3px 1px -2px rgba(0, 0, 0, 0.2);
        }

        .z-depth-1-half{
            box-shadow: 0 3px 3px 0 rgba(0, 0, 0, 0.14), 0 1px 7px 0 rgba(0, 0, 0, 0.12), 0 3px 1px -1px rgba(0, 0, 0, 0.2);
        }

        .z-depth-2 {
            box-shadow: 0 4px 5px 0 rgba(0, 0, 0, 0.14), 0 1px 10px 0 rgba(0, 0, 0, 0.12), 0 2px 4px -1px rgba(0, 0, 0, 0.3);
        }

        .z-depth-3 {
            box-shadow: 0 6px 10px 0 rgba(0, 0, 0, 0.14), 0 1px 18px 0 rgba(0, 0, 0, 0.12), 0 3px 5px -1px rgba(0, 0, 0, 0.3);
        }

        .z-depth-4 {
            box-shadow: 0 8px 10px 1px rgba(0, 0, 0, 0.14), 0 3px 14px 2px rgba(0, 0, 0, 0.12), 0 5px 5px -3px rgba(0, 0, 0, 0.3);
        }

        .z-depth-5 {
            box-shadow: 0 16px 24px 2px rgba(0, 0, 0, 0.14), 0 6px 30px 5px rgba(0, 0, 0, 0.12), 0 8px 10px -5px rgba(0, 0, 0, 0.3);
        }

        .card {
            position: relative;
            margin: 0.5rem 0 1rem 0;
            background-color: #fff;
            transition: box-shadow .25s;
            border-radius: 2px;
        }

    </style>
</head>
<body style="background: #e7e7e7">
<div id="loader"></div>
<div class="container" style="margin: auto auto;">
    <div class="row" style="margin-top: 70px;margin-bottom: 80px">
    <center>        
        <img src="<?php echo URL.'assets/img/logo-kementrian.png'?>" width="120">
        <h3>Aplikasi Karya Siswa PUSDIKLAT SDM</h3><br>
    </center>
        <div class="col-md-4 col-md-offset-4 animated zoomIn"  id="content">
            <div class="panel panel-default z-depth-5">
                <div class="panel-heading">
                    <div style="font-size: 14pt" class="panel-title text-center" id="title-box">Login Sistem</div>
                </div>
                <div class="panel-body">
                    <form id="form-login" style="padding: 10px;">
                        <div style="margin-bottom: 25px; margin-top: 5px" class="input-group">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
                            <input type="text" name="username" class="form-control" placeholder="Username" required>
                        </div>
                        <div style="margin-bottom: 20px" class="input-group">
                            <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
                            <input type="password" name="password" class="form-control" placeholder="Password" required >
                        </div>
                        <div class="input-group" style="width: 100%; ">
                            <button type="submit" class="btn btn-primary ladda-button" data-style="zoom-in" name="login" style="width:100%;"><span class="ladda-label">LOGIN</span></button>
                            <button type="submit" class="btn btn-primary disabled ladda-button" data-style="zoom-in" name="login_ok" style="width:100%;" disabled><span class="ladda-label">LOGIN</span></button>
                        </div>   
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
<script type="text/javascript">
    var c = Ladda.create(document.querySelector('[name=login]'));

    function notify(title, message, type) {
        $.notify({
            title: '<strong>'+title+' !</strong>',
            message: message
        },{
            type: type,
            placement:{
                from: 'bottom',
                align: 'center',
            }
        });
    }    

    var delay = (function(){
      var timer = 0;
      return function(callback, ms){
        clearTimeout (timer);
        timer = setTimeout(callback, ms);
      };
    })();

  function loading() {
    $('#loader').fadeIn('slow');
    setTimeout(function(){
        $('#loader').fadeOut('slow'); 
    }, 0);    
  }
  function loading_start(){
    $('#loader').fadeIn('slow');
  }
  function loading_stop() {
    $('#loader').fadeOut('slow'); 
  }

    $(document).ready(function() {
        loading_stop();
        $('[name=login_ok]').fadeOut();

        $('#form-login').on("submit", function(e) {
            e.preventDefault();
            var data = new FormData($('#form-login')[0]);
            var url = '<?php echo site_url('login/LogIn')?>';
            c.start();
            // loading_start();
            setTimeout(function(){
                $.ajax({
                    url: url,
                    type: 'post',
                    data: data,
                    contentType: false,
                    processData: false,
                    async: false,
                    dataType: 'json',
                    success: function(data){
                        if (data.notif == 1) {
                            notify('Success', 'Berhasil Login', 'success');
                            $('[name=username]').attr('disabled', true);                         
                            $('[name=password]').attr('disabled', true); 
                                // c.stop();
                            $('[name=login]').fadeOut(0);                            
                            $('[name=login_ok]').fadeIn(0);                            
                            setTimeout(function(){
                                window.location.href = "<?php echo site_url('user')?>";
                            }, 2000);
                        }else if (data.notif == 2) {
                            notify('Warning', 'Akun tidak aktif', 'warning');
                        }else{
                            notify('Error', 'Username dan password tidak valid', 'error');
                        }
                    },
                    error: function(){
                        notify('Error System', 'Kesalahan pada system', 'error');
                    }
                });
                c.stop();                      

                // loading_stop();
            }, 800);
        });

        
    });

</script>