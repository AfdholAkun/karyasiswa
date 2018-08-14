<style>
	#tables tbody tr td:nth-child(1) {
		text-align: center;
	}
</style>
<div class="col-md-12">
	<div class="row">
		<div class="panel panel-default">
			<div class="panel-heading" >
				<span style="font-size: 11pt">Data Semester
				</span>
			</div>
			<div class="panel-body">
				<div class="col-md-12">
					<div class="row">
						<div class="slot">
							<button type="button" onclick="InsertSemester()" id="Add" class="btn bg-green btn-flat ladda-button" data-style="zoom-in"><i class="fa fa-plus"></i> Tambah Semester</button>
						</div>
					</div>
				</div>
				
				<div class="col-md-12">
					<div class="row">
						<table class="table table-hover table-bordered table-striped" id="tables" width="100%">
							<thead class="bg-green">
							<tr>
								<td width="5%" class="text-center">No</td>
								<td width="">Id Semester</td>
								<td width="">Nama Semester</td>
							</tr>
							</thead>
							</tfoot>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
var l = Ladda.create(document.querySelector('#Add'));
function InsertSemester() {
	l.start();
	setTimeout(function(){
		$.ajax({
			url: link+'semester/InsertSemester',
			type: 'post',
			dataType: 'json',
			success:function(data){
				CekIsToken(data.notif);
				if (data.notif == 1) {
					notify('Berhasil', 'Tambah Transaksi', 'success');
				}
			},
			error:function(){
				notify('Error System !', 'Gagal InsertSemester', 'danger');
			}
		});
		table.ajax.reload(null, false);	
		l.stop();
	});
}
</script>