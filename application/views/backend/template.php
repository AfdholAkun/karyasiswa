<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Karya Siswa Pusdiklat</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <?php $this->load->view('backend/load'); ?>
    <?php $this->load->view('backend/icon'); ?>
</head>
<body class="skin-green">
<div id="loader"></div>
<div class="wrapper">
    <?php $this->load->view('backend/header'); ?>
    <?php $this->load->view('backend/menu'); ?>
    <div class="content-wrapper" style="background: #e9e9e9;">
        <?php $this->load->view('backend/content-header');?>
        <section class="content" >
            <?php $this->load->view($content)?>
        </section>
    </div>
    <?php $this->load->view('backend/footer');?>
</div>
</body>
<script type="text/javascript">
    const link = '<?php echo site_url() ?>';

    $('.select2').select2({
        theme:"bootstrap"
    });    

    function CekIsToken(notif) {
        if (notif == 401) {
            window.location.href = "<?php echo site_url('login')?>";            
        }
    }

    function notify(title, message, type) {
        $.notify({
            title: '<strong>'+title+' !</strong>',
            message: message
        },{
            type: type,
            placement:{
                from: 'bottom',
                align: 'right',

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

    function NullDate(value) {
        if (value === "0000-00-00") {
            value = "";
        }
        return value;
    }

    function NullDateTime(value) {
        if (value === "0000-00-00 00:00:00") {
            value = "";
        }
        return value;
    }

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

    var table;
    $(document).ready(function(){
        setTimeout(function(){
            table = $('#tables').DataTable({
                'lengthMenu':[[10, 25, 50, 100, 200, 350, 10000000], [10, 25, 50, 100, 200, 350, "All"]],
                "language": {
                    "lengthMenu": "Menampilkan _MENU_ data per halaman",
                    "zeroRecords": "Tidak ada data",
                    "info": "Menunjukan halaman _PAGE_ dari _PAGES_",
                    "infoEmpty": "No records available",
                    "infoFiltered": "(filtered from _MAX_ total records)",
                    "search": "Cari",
                },
                'processing' : true,
                'serverSide' : true,
                'ajax': {url:'<?php echo $link_fetch_data?>',type:"POST"},
                'order':[],
                "columnDefs": [ 
                    {
                    "searchable": false,
                    "orderable": false,
                    "targets": 0
                    }
                ],
                // 'deferLoading':57,
                // initComplete: function () {
                //     this.api().columns().every( function () {
                //         var column = this;
                //         var select = $('<select class="form-control" style="width: 100%" name=""><option value=""></option></select>')
                //             .appendTo( $(column.footer()).empty() )
                //             .on( 'change', function () {
                //                 var val = $.fn.dataTable.util.escapeRegex(
                //                     $(this).val()
                //                 );

                //                 column
                //                     .search( val ? '^'+val+'$' : '', true, false )
                //                     .draw();
                //             } );
                //         column.data().unique().sort().each( function ( d, j ) {
                //             select.append( '<option value="'+d+'">'+d+'</option>' )
                //         } );
                //     } );
                // },
                'responsive':true
            });
            // table.on( 'order.dt search.dt', function () {
            //     table.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            //         cell.innerHTML = i+1;
            //     } );
            // } ).draw();
            loading_stop();
        }, 500);


    });

    // setInterval( function () {
    //     table.ajax.reload(null, false);
    // }, 5000 );

    jQuery.fn.ForceNumericOnly =
        function()
        {
            return this.each(function()
            {
                $(this).keydown(function(e)
                {
                    var key = e.charCode || e.keyCode || 0;
                    // allow backspace, tab, delete, enter, arrows, numbers and keypad numbers ONLY
                    // home, end, period, and numpad decimal
                    return (
                    key == 8 ||
                    key == 9 ||
                    key == 13 ||
                    key == 46 ||
                    key == 110 ||
                    key == 190 ||
                    (key >= 35 && key <= 40) ||
                    (key >= 48 && key <= 57) ||
                    (key >= 96 && key <= 105));
                });
            });
        };

    $(function () {
        $('#datetimepicker').datetimepicker({
            format: 'DD MMMM YYYY HH:mm'
        });

        $('#datepicker').datetimepicker({
            format: 'DD MMMM YYYY'
        });

        $('#timepicker').datetimepicker({
            format: 'YYYY-MM-DD HH:mm'
        });

        $('#date').datetimepicker({
            format: 'YYYY-MM-DD'
        });

        $('#to_date').datetimepicker({
            format: 'YYYY-MM-DD'
        });

    });

</script>
</html>