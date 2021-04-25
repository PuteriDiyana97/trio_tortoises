<!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"> -->

<div class="kt-subheader-search">
	<div class="kt-container  kt-container--fluid">
		<h3 class="kt-subheader-search__title">
			Dashboard
			<span class="kt-subheader-search__desc"></span>
		</h3>
	</div>
</div>

<!-- begin:: Content -->
<div class="d-flex flex-column-fluid">
		<!--begin::Container-->
		<div class=" container ">
			<!--begin::Dashboard-->
			<!--begin::Row-->
			<div class="row">
				<div class="col-lg-3">
					<!--begin::List Widget 8-->
					<div class="card card-custom card-stretch card-shadowless gutter-b">
					    <!--begin::Header-->
					        <div class="card card-custom gutter-b">
							    <div class="card-header card-header-tabs-line">
							        <div class="card-title">
							            <h3 class="card-label"><i class="fas fa-users"></i> Member</h3>
							        </div>
							        <div class="card-toolbar">
							            <ul class="nav nav-tabs nav-bold nav-tabs-line">
							            	<li class="nav-item">
							                    <a class="nav-link" data-toggle="tab" href="#kt_tab_pane_2_3">
							                        <span class="nav-icon"></span>
							                        <span class="nav-text">Month</span>
							                    </a>
							                </li>
							                <li class="nav-item">
							                    <a class="nav-link" data-toggle="tab" href="#kt_tab_pane_1_3">
							                        <span class="nav-icon"></i></span>
							                        <span class="nav-text">Week</span>
							                    </a>
							                </li>
							                <li class="nav-item ">
							                    <a class="nav-link active" data-toggle="tab" href="#kt_tab_pane_3_3" >
							                        <span class="nav-icon"></span>
							                        <span class="nav-text">Day</span>
							                    </a>
							                 </li>
							            </ul>
							        </div>
							    </div>
							    <div class="card-body">
							        <div class="tab-content">
							        	<div class="tab-pane fade" id="kt_tab_pane_2_3" aria-labelledby="kt_tab_pane_2_3">
							                <center><h2><?= $member_month->Count ?></h2></center>
							            </div>
							            <div class="tab-pane fade " id="kt_tab_pane_1_3" aria-labelledby="kt_tab_pane_1_3">
							                <center><h2><?= $member_week->Count ?></h2></center>
							            </div>
							            <div class="tab-pane fade show active" id="kt_tab_pane_3_3" aria-labelledby="kt_tab_pane_3_3">
							                <center><h2><?= $member_day->Count ?></h2></center>
							            </div>
							        </div>
							    </div>
							</div>
					    <!--end::Header-->
					</div>
					<!--end: Card-->
					<!--end::List Widget 8-->
				</div>
			    <div class="col-lg-3">
					<!--begin::List Widget 3-->
					<div class="card card-custom card-stretch card-shadowless gutter-b">
					    <!--begin::Header-->
					    <div class="card card-custom gutter-b">
							    <div class="card-header card-header-tabs-line">
							        <div class="card-title">
							            <h3 class="card-label"><i class="fas fa-hand-holding-usd"></i> Total Earned</h3>
							        </div>
							        <div class="card-toolbar">
							            <ul class="nav nav-tabs nav-bold nav-tabs-line">
							            	<li class="nav-item">
							                    <a class="nav-link" data-toggle="tab" href="#earn_month">
							                        <span class="nav-icon"></span>
							                        <span class="nav-text">Month</span>
							                    </a>
							                </li>
							                <li class="nav-item">
							                    <a class="nav-link" data-toggle="tab" href="#earn_week">
							                        <span class="nav-icon"></i></span>
							                        <span class="nav-text">Week</span>
							                    </a>
							                </li>
							                <li class="nav-item">
							                    <a class="nav-link active" data-toggle="tab" href="#earn_day" >
							                        <span class="nav-icon"></span>
							                        <span class="nav-text">Day</span>
							                    </a>
							                 </li>
							            </ul>
							        </div>
							    </div>
							    <div class="card-body">
							        <div class="tab-content">
							        	<div class="tab-pane fade" id="earn_month" aria-labelledby="earn_month">
							                <center><h2><?= $earn_month->Count ?> pts</h2></center>
							            </div>
							            <div class="tab-pane fade " id="earn_week" aria-labelledby="earn_week">
							                <center><h2><?= $earn_week->Count ?> pts</h2></center>
							            </div>
							            <div class="tab-pane fade show active" id="earn_day" aria-labelledby="earn_day">
							                <center><h2><?= $earn_day->Count ?> pts</h2></center>
							            </div>
							        </div>
							    </div>
							</div>
					    <!--end::Header-->
					</div>
					<!--end::List Widget 3-->
				</div>
			 	<div class="col-lg-3">
					<!--begin::List Widget 3-->
					<div class="card card-custom card-stretch card-shadowless gutter-b">
					    <!--begin::Header-->
					     <div class="card card-custom gutter-b">
							    <div class="card-header card-header-tabs-line">
							        <div class="card-title">
							            <h3 class="card-label"><i class="fas fa-ticket-alt"></i> Voucher Claim</h3>
							        </div>
							        <div class="card-toolbar">
							            <ul class="nav nav-tabs nav-bold nav-tabs-line">
							            	<li class="nav-item">
							                    <a class="nav-link" data-toggle="tab" href="#claim_month">
							                        <span class="nav-icon"></span>
							                        <span class="nav-text">Month</span>
							                    </a>
							                </li>
							                <li class="nav-item">
							                    <a class="nav-link" data-toggle="tab" href="#claim_week">
							                        <span class="nav-icon"></i></span>
							                        <span class="nav-text">Week</span>
							                    </a>
							                </li>
							                <li class="nav-item ">
							                    <a class="nav-link active" data-toggle="tab" href="#claim_day" >
							                        <span class="nav-icon"></span>
							                        <span class="nav-text">Day</span>
							                    </a>
							                 </li>
							            </ul>
							        </div>
							    </div>
							    <div class="card-body">
							        <div class="tab-content">
							        	<div class="tab-pane fade" id="claim_month" role="tabpanel" aria-labelledby="claim_month">
							                <center><h2>RM <?= $claim_month->Count ?></h2></center>
							            </div>
							            <div class="tab-pane fade " id="claim_week" role="tabpanel" aria-labelledby="claim_week">
							                <center><h2>RM <?= $claim_week->Count ?></h2></center>
							            </div>
							            <div class="tab-pane fade show active" id="claim_day" role="tabpanel" aria-labelledby="claim_day">
							                <center><h2>RM <?= $claim_day->Count ?></h2></center>
							            </div>
							        </div>
							    </div>
							</div>
					    <!--end::Header-->
					</div>
					<!--end::List Widget 3-->
				</div>
				<div class="col-lg-3">
					<!--begin::List Widget 3-->
					<div class="card card-custom card-stretch card-shadowless gutter-b">
					    <!--begin::Header-->
					    <div class="card card-custom gutter-b">
							    <div class="card-header card-header-tabs-line">
							        <div class="card-title">
							            <h3 class="card-label"><i class="fas fa-ticket-alt"></i> Voucher Redeem</h3>
							        </div>
							        <div class="card-toolbar">
							            <ul class="nav nav-tabs nav-bold nav-tabs-line">
							            	<li class="nav-item">
							                    <a class="nav-link" data-toggle="tab" href="#redeem_month">
							                        <span class="nav-icon"></span>
							                        <span class="nav-text">Month</span>
							                    </a>
							                </li>
							                <li class="nav-item">
							                    <a class="nav-link" data-toggle="tab" href="#redeem_week">
							                        <span class="nav-icon"></i></span>
							                        <span class="nav-text">Week</span>
							                    </a>
							                </li>
							                <li class="nav-item">
							                    <a class="nav-link active" data-toggle="tab" href="#redeem_day" >
							                        <span class="nav-icon"></span>
							                        <span class="nav-text active">Day</span>
							                    </a>
							                 </li>
							            </ul>
							        </div>
							    </div>
							    <div class="card-body">
							        <div class="tab-content">
							        	<div class="tab-pane fade" id="redeem_month" aria-labelledby="redeem_month">
							                <center><h2>RM <?= $redeem_month->Count ?></h2></center>
							            </div>
							            <div class="tab-pane fade " id="redeem_week" aria-labelledby="redeem_week">
							                <center><h2>RM <?= $redeem_week->Count ?></h2></center>
							            </div>
							            <div class="tab-pane fade show active" id="redeem_day" aria-labelledby="redeem_day">
							                <center><h2>RM <?= $redeem_day->Count ?></h2></center>
							            </div>
							        </div>
							    </div>
							</div>
					    <!--end::Header-->
					</div>
					<!--end::List Widget 3-->
				</div>
			</div><br>
			<!--end::Row-->

			<div class="row">
				<div class="col-lg-6">
					<!--begin::List Widget 8-->
					<div class="card card-custom card-stretch card-shadowless gutter-b">
					    <!--begin::Header-->
					        <div class="card card-custom gutter-b">
							    <div class="card-header">
							        <div class="card-title">
							            <h3 class="card-label"><i class="flaticon2-pie-chart"></i> Gender</h3>
							        </div>
							    </div>    
							    <div id="gender_piechart" style="width: 100%; height: 280px;"></div>							
							</div>
					    <!--end::Header-->
					</div>
					<!--end: Card-->
					<!--end::List Widget 8-->
				</div>
			    <div class="col-lg-6">
					<!--begin::List Widget 3-->
					<div class="card card-custom card-stretch card-shadowless gutter-b">
					    <!--begin::Header-->
					    <div class="card card-custom gutter-b">
							    <div class="card-header">
							        <div class="card-title">
							            <h3 class="card-label"><i class="flaticon2-pie-chart"></i> Nationality</h3>
							        </div>
							    </div>    
							    <div id="nationality_piechart" style="width: 100%; height: 280px;"></div>
						</div>
					    <!--end::Header-->
					</div>
					<!--end::List Widget 3-->
				</div>
			</div><br>

			<!--begin::Total Spending Point-->
			<div class="card card-custom card-shadowless gutter-b">
			    <!--begin::Header-->
			    <div class="card card-custom gutter-b">
							    <div class="card-header card-header-tabs-line">
							         <h3 class="card-title align-items-start flex-column">
							         	<h3 class="card-label"><i class="flaticon2-pie-chart"></i> Total Spending Point</h3>
							        </h3>
							        <div class="card-toolbar">
							            <ul class="nav nav-tabs nav-bold nav-tabs-line">
							            	<li class="nav-item">
							                    <a class="nav-link" data-toggle="tab" href="#point_used_gender">
							                        <span class="nav-text">Gender</span>
							                    </a>
							                    
							                </li>
							                <li class="nav-item ">
							                    <a class="nav-link active" data-toggle="tab" href="#point_used_nationality" >
							                        <span class="nav-text">Nationality</span>
							                    </a>
							                    
							                 </li>
							            </ul>
							        </div>
							    </div>
							    <div class="card-body">
							        <div class="tab-content">
							        	<div class="tab-pane fade show active" id="point_used_nationality" aria-labelledby="point_used_nationality">
							            	<center><h2 id="total_spend_nationality" style="width: 100%; height: 280px;"></h2></center>
							            </div>
							        	<div class="tab-pane fade active" id="point_used_gender" aria-labelledby="point_used_gender">
									        <center><h2 id="total_spend_gender" style="width: 100%; height: 280px;"></h2></center>
							            </div>
							        </div>
							    </div>
							</div>
			    <!--end::Header-->
			</div><br>
			<!--end::Total Spending Point-->

			<!--begin::Statistics-->
			<div class="card card-custom card-shadowless gutter-b">
			    <!--begin::Header-->
			    <div class="card card-custom gutter-b">
							    <div class="card-header card-header-tabs-line">
							         <h3 class="card-title align-items-start flex-column">
							            <span class="card-label"><i class="flaticon2-graph"></i> Statistics</span>
							        </h3>
							        <div class="card-toolbar">
							            <ul class="nav nav-tabs nav-bold nav-tabs-line">
							            	<li class="nav-item">
							                    <a class="nav-link" data-toggle="tab" href="#statistic_month">
							                        <span class="nav-text">Month</span>
							                    </a>
							                </li>
							            </ul>
							        </div>
							    </div>
							    <div class="card-body">
							        <div class="tab-content">
							        	<div class="tab-pane fade show active" id="statistic_month" aria-labelledby="statistic_month">
									        <div id="line_date_wise" style="width: 100%; height: 500px; margin: 0 auto"></div>
							            </div>
							        </div>
							    </div>
							</div>
			    <!--end::Header-->
			</div>
			<!--end::Statistics-->
			<!--end::Dashboard-->
		</div>
		<!--end::Container-->
	</div>
<!-- end:: Content -->


<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
//**Gender pie chart*****************************************************
	google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(genderChart);

    // window.onresize = lineChart();
     $(window).resize(function(){
     	google.charts.setOnLoadCallback(genderChart);
     });

      function genderChart() {

        var data = google.visualization.arrayToDataTable([

          ['Gender', 'Total'],
          <?php 
	             foreach ($gender as $row){
	             echo "['".$row->gender."',".$row->total."],";
	             }
	             ?>
        ]);

        var chart = new google.visualization.PieChart(document.getElementById('gender_piechart'));

        chart.draw(data);
      }
//**End gender pie chart*****************************************************

//**Nationality pie chart*****************************************************
	google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(nationalityChart);

    // window.onresize = lineChart();
     $(window).resize(function(){
     	google.charts.setOnLoadCallback(nationalityChart);
     });

      function nationalityChart() {

        var data = google.visualization.arrayToDataTable([
          ['Nationality', 'Total'],
          <?php 
	             foreach ($nationality as $row){
	             echo "['".$row->nationality."',".$row->total."],";
	             }
	             ?>
        ]);

        var chart = new google.visualization.PieChart(document.getElementById('nationality_piechart'));

        chart.draw(data);
      }
//**End nationality pie chart************************************************

//**total_spend_genderChart pie chart*****************************************************
	google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(total_spend_genderChart);

    // window.onresize = lineChart();
     $(window).resize(function(){
     	google.charts.setOnLoadCallback(total_spend_genderChart);
     });

      function total_spend_genderChart() {

        var data = google.visualization.arrayToDataTable([

          ['Point Used', 'Total'],
          <?php 
	             foreach ($total_spend_gender as $row){
	             echo "['".$row->gender."',".$row->point_used."],";
	             }
	             ?>
        ]);

        var chart = new google.visualization.PieChart(document.getElementById('total_spend_gender'));

        chart.draw(data);
      }
//**End total_spend_gender pie chart*****************************************************

//**total_spend_nationalityChart pie chart*****************************************************
	google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(total_spend_nationalityChart);

    // window.onresize = lineChart();
     $(window).resize(function(){
     	google.charts.setOnLoadCallback(total_spend_nationalityChart);
     });

      function total_spend_nationalityChart() {

        var data = google.visualization.arrayToDataTable([

          ['Point Used', 'Total'],
          <?php 
	             foreach ($total_spend_nationality as $row){
	             echo "['".$row->nationality."',".$row->point_used."],";
	             }
	             ?>
        ]);

        var chart = new google.visualization.PieChart(document.getElementById('total_spend_nationality'));

        chart.draw(data);
      }
//**End total_spend_nationalityChart pie chart*****************************************************

//**Statistics pie chart*****************************************************
	 google.charts.load('visualization', "1", {packages: ['corechart']});
     google.charts.setOnLoadCallback(lineChart);
     google.charts.setOnLoadCallback(daylineChart);

     // window.onresize = lineChart();
     $(window).resize(function(){
     	google.charts.setOnLoadCallback(lineChart);
     	google.charts.setOnLoadCallback(daylineChart);
     });

      //for month wise
	  function lineChart() {
	 
	        /* Define the chart to be drawn.*/
	        var data = google.visualization.arrayToDataTable([
	            ['Date', 'Users count per month'],
	            <?php 
	             foreach ($month_wise as $row){
	             echo "['".$row->day_date."',".$row->count."],";
	             }
	             ?>
	        ]);
	 
	        var options = {
	          title: 'Month Wise Registered Users Of Line Chart',

	          curveType: 'function',
	          legend: { position: 'bottom' },
	          vAxis: {format: '0'}
	        };
	        /* Instantiate and draw the chart.*/
	        var chart = new google.visualization.LineChart(document.getElementById('line_date_wise'));
	        chart.draw(data, options);
	  }

	  //for day wise
	  function daylineChart() {
	 
	        /* Define the chart to be drawn.*/
	        var data = google.visualization.arrayToDataTable([
	            ['Date', 'Users count per day'],
	            <?php 
	            // foreach ($day_wise as $row){
	             foreach ($new_day_wise as $row){
	             echo "['".$row->day_of_week."',".$row->count."],";
	             }
	             ?>
	        ]);
	 
	        var options = {
	          title: 'Day Wise Registered Users Of Line Chart',
	          curveType: 'function',
	          legend: { position: 'bottom' },
	          legend: { position: 'bottom' },
	          // xAxis: { labelString: 'Member'},
	          // yAxis: { labelString: 'Day'},
	          vAxis: {format: '0',viewWindow: {min: 0}}
	        };
	        /* Instantiate and draw the chart.*/
	        var chart = new google.visualization.LineChart(document.getElementById('line_day_wise'));
	        chart.draw(data, options);
	  }
//**End statistics pie chart*****************************************************
 
    </script>