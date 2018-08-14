<div class="col-md-12">
	<div class="row">
		<div class="panel panel-default">
			<div class="panel-heading" >
				<span style="font-size: 11pt">Grafik Karya Siswa
				</span>
			</div>
			<div class="panel-body">
				<div class="col-md-12">
					<div class="row">
						<div id="chartContainer" style="height: 370px; max-width: 920px; margin: 0px auto;"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function() {
		var chart = new CanvasJS.Chart("chartContainer", {
		exportEnabled: true,
		animationEnabled: true,
		title:{
			text: ""
		},
		subtitles: [{
			text: ""
		}], 
		axisX: {
			title: ""
		},
		toolTip: {
			shared: true
		},
		legend: {
			cursor: "pointer",
			itemclick: toggleDataSeries
		},
		data: [
			<?php foreach ($KeteranganKaryasiswa->result() as $d): ?>
				{
					type: "column",
					name: "<?php echo $d->nama_keterangan ?>",
					showInLegend: true,
					dataPoints: [
						<?php foreach ($this->md->GrafikKaryaSiswaTahun("where id_keterangan = '$d->id'")->result() as $d): ?>
							{ label: "<?php echo $d->tahun ?>",  y: <?php echo $d->jumlah ?> },
						<?php endforeach ?>
					]
				},	
			<?php endforeach ?>
		]
		});
		chart.render();

		function toggleDataSeries(e) {
		if (typeof (e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
			e.dataSeries.visible = false;
		} else {
			e.dataSeries.visible = true;
		}
		e.chart.render();
		}
	});
</script>