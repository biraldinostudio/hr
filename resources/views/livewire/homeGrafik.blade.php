
  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Halaman Beranda</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Halaman Beranda</li>
            </ol>
          </div>
        </div>
      </div>
    </section>

    <section class="content">
      <div class="container-fluid">
	 		@if($countTranss==null)
		Belum ada data
@else	 
        <div class="row">
          <div class="col-md-6">
            <div class="card card-info">
              <div class="card-header">
                <h3 class="card-title">Cuty By Departemen</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <div class="card-body">
                <canvas id="donutChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
              </div>
            </div>
			</div>
			<div class="col-md-6">
				<div class="card card-warning">
				  <div class="card-header">
					<h3 class="card-title">Dinas By Departemen</h3>

					<div class="card-tools">
					  <button type="button" class="btn btn-tool" data-card-widget="collapse">
						<i class="fas fa-minus"></i>
					  </button>
					  <button type="button" class="btn btn-tool" data-card-widget="remove">
						<i class="fas fa-times"></i>
					  </button>
					</div>
				  </div>
				  <div class="card-body">
					<canvas id="assignChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
				  </div>
				</div>			
			</div>
		</div>
		
		
        <div class="row">
          <div class="col-md-6">
            <div class="card card-info">
				<div class="card card-success">
				  <div class="card-header">
					<h3 class="card-title">Izin By Departemen</h3>

					<div class="card-tools">
					  <button type="button" class="btn btn-tool" data-card-widget="collapse">
						<i class="fas fa-minus"></i>
					  </button>
					  <button type="button" class="btn btn-tool" data-card-widget="remove">
						<i class="fas fa-times"></i>
					  </button>
					</div>
				  </div>
				  <div class="card-body">
					<canvas id="permChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
				  </div>
				  <!-- /.card-body -->
				</div>	
			</div>
			</div>
			<div class="col-md-6">
				<div class="card card-primary">
				  <div class="card-header">
					<h3 class="card-title">Cuti - Izin - Dinas</h3>

					<div class="card-tools">
					  <button type="button" class="btn btn-tool" data-card-widget="collapse">
						<i class="fas fa-minus"></i>
					  </button>
					  <button type="button" class="btn btn-tool" data-card-widget="remove">
						<i class="fas fa-times"></i>
					  </button>
					</div>
				  </div>
				  <div class="card-body">
					<div class="chart">
					  <canvas id="barChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
					</div>
				  </div>
				</div>		
			</div>
		</div>		
			
	
				
		<div class="row">

      <div class="col-md-6">

			
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Cuti Izin Dinas</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <div class="card-body">
                <div class="chart">
                  <canvas id="areaChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
              </div>
            </div>
			
			{{--

            <!-- DONUT CHART -->
            <div class="card card-danger">
              <div class="card-header">
                <h3 class="card-title">Cuty By Department</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <div class="card-body">
                <canvas id="donutChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
              </div>
              <!-- /.card-body -->
            </div>
			--}}

          </div>
          <!-- /.col (LEFT) -->
          <div class="col-md-6">
            <!-- LINE CHART -->
            <div class="card card-info">
              <div class="card-header">
                <h3 class="card-title">Cuti Izin Dinas</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <div class="card-body">
                <div class="chart">
                  <canvas id="lineChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->


			{{--
            <!-- STACKED BAR CHART -->
            <div class="card card-success">
              <div class="card-header">
                <h3 class="card-title">Stacked Bar Chart</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <div class="card-body">
                <div class="chart">
                  <canvas id="stackedBarChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
              </div>
            </div>--}}

          </div>
			</div>
@endif
      </div>
    </section>
  </div>

@push('styles')
  <link rel="stylesheet" href="{{asset('template/custom/home.css')}}">
@endpush
@push('scripts')
<script src="{{asset('template/plugins/chart.js/Chart.min.js')}}"></script>
<script>
  $(function () {
    var dayOfData =  <?php echo json_encode($dataDayOfs) ?>;
	var permissionData =  <?php echo json_encode($dataPermissions) ?>;
	var assignmentData =  <?php echo json_encode($dataAssignments) ?>;
	
    var dayOfDataCount =  <?php echo json_encode($dataCountTransDayOfs) ?>;
	var assignDataCount =  <?php echo json_encode($dataCountTransAssigns) ?>;
	var permDataCount =  <?php echo json_encode($dataCountTransPerms) ?>;	
    var dayOfDataLabel =  <?php echo json_encode($labelMonths) ?>;	
    var areaChartCanvas = $('#areaChart').get(0).getContext('2d')

    var areaChartData = {
	  labels  : dayOfDataLabel.labelMonth,
      datasets: [
        {
          label               : 'Cuti',
          backgroundColor     : 'rgba(60,141,188,0.9)',
          borderColor         : 'rgba(60,141,188,0.8)',
          pointRadius          : false,
          pointColor          : '#3b8bba',
          pointStrokeColor    : 'rgba(60,141,188,1)',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(60,141,188,1)',
          data                : dayOfDataCount.dataCountDayOf
        },
	    {
          label               : 'Izin',
          backgroundColor     : 'rgba(255, 153, 51, 1)',
          borderColor         : 'rgba(255, 153, 51, 1)',
          pointRadius         : false,
          pointColor          : 'rgba(255, 153, 51, 1)',
          pointStrokeColor    : '#c1c7d1',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(255, 153, 51, 1)',
          data                : permDataCount.dataCountPerm
        },

	    {
          label               : 'Dinas',
          backgroundColor     : 'rgba(153, 204, 102, 1)',
          borderColor         : 'rgba(153, 204, 102, 1)',
          pointRadius         : false,
          pointColor          : 'rgba(153, 204, 102, 1)',
          pointStrokeColor    : '#c1c7d1',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(153, 204, 102, 1)',
          data                : assignDataCount.dataCountAssign
        },			

      ]
    }

    var areaChartOptions = {
      maintainAspectRatio : false,
      responsive : true,
      legend: {
        display: false
      },
      scales: {
        xAxes: [{
          gridLines : {
            display : false,
          }
        }],
        yAxes: [{
          gridLines : {
            display : false,
          }
        }]
      }
    }

    new Chart(areaChartCanvas, {
      type: 'line',
      data: areaChartData,
      options: areaChartOptions
    })

    //-------------
    //- LINE CHART -
    //--------------
    var lineChartCanvas = $('#lineChart').get(0).getContext('2d')
    var lineChartOptions = $.extend(true, {}, areaChartOptions)
    var lineChartData = $.extend(true, {}, areaChartData)
    lineChartData.datasets[0].fill = false;
    lineChartData.datasets[1].fill = false;
    lineChartOptions.datasetFill = false

    var lineChart = new Chart(lineChartCanvas, {
      type: 'line',
      data: lineChartData,
      options: lineChartOptions
    })

	//DONUT CHART - Cuti By Department
    var dayOfDeptChartCanvas = $('#donutChart').get(0).getContext('2d')
    var dayOfDeptChartData        = {
      labels: dayOfData.label,
      datasets: [
        {
          data: dayOfData.data,
          backgroundColor : ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de'],
        }
      ]
    }
    var dayOfDeptOptions     = {
      maintainAspectRatio : false,
      responsive : true,
    }
	
	//Peralihan Donut & Pie
    new Chart(dayOfDeptChartCanvas, {
      type: 'doughnut',
      data: dayOfDeptChartData,
      options: dayOfDeptOptions
    })
	
	//DONUT CHART ASSIGNMENT
    var assignDeptChartCanvas = $('#assignChart').get(0).getContext('2d')
    var assignDeptChartData        = {
      labels: assignmentData.label,
      datasets: [
        {
          data: assignmentData.data,
          backgroundColor : ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de'],
        }
      ]
    }
    var assignDeptOptions     = {
      maintainAspectRatio : false,
      responsive : true,
    }
	
	//Peralihan Donut & Pie
    new Chart(assignDeptChartCanvas, {
      type: 'doughnut',
      data: assignDeptChartData,
      options: assignDeptOptions
    })	
		
	//PIE CHART
    var permDeptChartCanvas = $('#permChart').get(0).getContext('2d')
	
    var permDeptChartData        = {
      labels: permissionData.label,
      datasets: [
        {
          data: permissionData.data,
          backgroundColor : ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de'],
        }
      ]
    }	
	
    var pieOptions     = {
      maintainAspectRatio : false,
      responsive : true,
    }
	//Peralihan Donut & Pie
    new Chart(permDeptChartCanvas, {
      type: 'pie',
      data: permDeptChartData,
      options: pieOptions
    })
	
	//BAR CHART
    var barGetChartData = {
     labels  : dayOfDataLabel.labelMonth,
      datasets: [
        {
          label               : 'Cuti',
          backgroundColor     : 'rgba(60,141,188,0.9)',
          borderColor         : 'rgba(60,141,188,0.8)',
          pointRadius          : false,
          pointColor          : '#3b8bba',
          pointStrokeColor    : 'rgba(60,141,188,1)',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(60,141,188,1)',
          data                : dayOfDataCount.dataCountDayOf
        },
	    {
          label               : 'Izin',
          backgroundColor     : 'rgba(255, 153, 51, 1)',
          borderColor         : 'rgba(255, 153, 51, 1)',
          pointRadius         : false,
          pointColor          : 'rgba(255, 153, 51, 1)',
          pointStrokeColor    : '#c1c7d1',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(255, 153, 51, 1)',
          data                : permDataCount.dataCountPerm
        },

	    {
          label               : 'Dinas',
          backgroundColor     : 'rgba(153, 204, 102, 1)',
          borderColor         : 'rgba(153, 204, 102, 1)',
          pointRadius         : false,
          pointColor          : 'rgba(153, 204, 102, 1)',
          pointStrokeColor    : '#c1c7d1',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(153, 204, 102, 1)',
          data                : assignDataCount.dataCountAssign
        },			

      ]
    }
    //-------------
    //- BAR CHART -
    //-------------
    var barChartCanvas = $('#barChart').get(0).getContext('2d')
    var barChartData = $.extend(true, {}, barGetChartData)
    var temp0 = barGetChartData.datasets[0]
    var temp1 = barGetChartData.datasets[1]
    barChartData.datasets[0] = temp0
    barChartData.datasets[1] = temp1

    var barChartOptions = {
      responsive              : true,
      maintainAspectRatio     : false,
      datasetFill             : false
    }

    new Chart(barChartCanvas, {
      type: 'bar',
      data: barChartData,
      options: barChartOptions
    })

    //---------------------
    //- STACKED BAR CHART -
    //---------------------
    var stackedBarChartCanvas = $('#stackedBarChart').get(0).getContext('2d')
    var stackedBarChartData = $.extend(true, {}, barChartData)

    var stackedBarChartOptions = {
      responsive              : true,
      maintainAspectRatio     : false,
      scales: {
        xAxes: [{
          stacked: true,
        }],
        yAxes: [{
          stacked: true
        }]
      }
    }

    new Chart(stackedBarChartCanvas, {
      type: 'bar',
      data: stackedBarChartData,
      options: stackedBarChartOptions
    })
  })
</script>
@endpush
