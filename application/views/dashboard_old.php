<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

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
							                <li class="nav-item active">
							                    <a class="nav-link" data-toggle="tab" href="#kt_tab_pane_3_3" >
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
							                <li class="nav-item active">
							                    <a class="nav-link" data-toggle="tab" href="#earn_day" >
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
							                <li class="nav-item active">
							                    <a class="nav-link" data-toggle="tab" href="#claim_day" >
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
							                <li class="nav-item active">
							                    <a class="nav-link" data-toggle="tab" href="#redeem_day" >
							                        <span class="nav-icon"></span>
							                        <span class="nav-text">Day</span>
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

			<!--begin::Advance Table Widget 4-->
			<div class="card card-custom card-shadowless gutter-b">
			    <!--begin::Header-->
			    <div class="card-header border-0 py-5">
			        <h3 class="card-title align-items-start flex-column">
			            <span class="card-label font-weight-bolder text-dark">Member</span>
			            <span class="text-muted mt-3 font-weight-bold font-size-sm">Statistics</span>
			        </h3>
			        <div class="card-toolbar">
			        	<canvas id="myChart" width="400" height="100"></canvas>
			          <!--   <ul class="nav nav-pills nav-pills-sm nav-dark-75" role="tablist">
			                <li class="nav-item">
			                    <a class="nav-link py-2 px-4" data-toggle="tab" href="#kt_charts_widget_2_chart_tab_1">
			                        <span class="nav-text font-size-sm">Month</span>
			                    </a>
			                </li>
			                <li class="nav-item">
			                    <a class="nav-link py-2 px-4" data-toggle="tab" href="#kt_charts_widget_2_chart_tab_2">
			                        <span class="nav-text font-size-sm">Week</span>
			                    </a>
			                </li>
			                <li class="nav-item">
			                    <a class="nav-link py-2 px-4 active" data-toggle="tab" href="#kt_charts_widget_2_chart_tab_3">
			                        <span class="nav-text font-size-sm">Day</span>
			                    </a>
			                </li>
			            </ul> -->
			        </div>
			        <div class="chart-container">
    <div class="bar-chart-container">
      <canvas id="bar-chart"></canvas>
    </div>
  </div>

			        <!-- <div class="card-toolbar">
			            <a href="#" class="btn btn-info font-weight-bolder font-size-sm mr-3">New Report</a>
			            <a href="#" class="btn btn-danger font-weight-bolder font-size-sm">Create</a>
			        </div> -->
			    </div>
			    <!--end::Header-->
			</div>
			<!--end::Advance Table Widget 4-->
			<!--end::Dashboard-->
		</div>
		<!--end::Container-->
	</div>
<!-- end:: Content -->

<script src="<?=base_url()?>assets/js/scripts.bundle.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.js"></script>
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script> 

<script>
$(function(){
      //get the bar chart canvas
      var cData = <?php echo $chart_data ?>;
      var ctx = $("#bar-chart");
 
      //bar chart data
      var data = {
        labels: cData.label,
        datasets: [
          {
            label: cData.label,
            data: cData.data,
            backgroundColor: [
              "#DEB887",
              "#A9A9A9",
              "#DC143C",
              "#F4A460",
              "#2E8B57",
              "#1D7A46",
              "#CDA776",
              "#CDA776",
              "#989898",
              "#CB252B",
              "#E39371",
            ],
            borderColor: [
              "#CDA776",
              "#989898",
              "#CB252B",
              "#E39371",
              "#1D7A46",
              "#F4A460",
              "#CDA776",
              "#DEB887",
              "#A9A9A9",
              "#DC143C",
              "#F4A460",
              "#2E8B57",
            ],
            borderWidth: [1, 1, 1, 1, 1,1,1,1, 1, 1, 1,1,1]
          }
        ]
      };
 
      //options
      var options = {
        responsive: true,
        title: {
          display: true,
          position: "top",
          text: "Monthly Registered Users Count",
          fontSize: 18,
          fontColor: "#111"
        },
        legend: {
          display: true,
          position: "bottom",
          labels: {
            fontColor: "#333",
            fontSize: 16
          }
        }
      };
 
      //create bar Chart class object
      var chart1 = new Chart(ctx, {
        type: "bar",
        data: data,
        options: options
      });
 
  });
// var ctx = document.getElementById('myChart').getContext('2d');
// var myChart = new Chart(ctx, {
//     type: 'bar',
//     data: {
//         labels: ['Jan', 'Feb', 'March', 'Apr', 'May', 'June', 'July', 'Aug', 'Sept', 'Oct', 'Nov', 'Dec'],
//         datasets: [{
//             label: '# of member',
//             data: [<?= $member_month->Count ?>, 19, 3, 5, 2, 3, 6, 9, 15, 19, 3, 5],
//             backgroundColor: [
//                 'rgba(255, 99, 132, 0.2)',
//                 'rgba(54, 162, 235, 0.2)',
//                 'rgba(255, 206, 86, 0.2)',
//                 'rgba(75, 192, 192, 0.2)',
//                 'rgba(153, 102, 255, 0.2)',
//                 'rgba(255, 159, 64, 0.2)',
//                 'rgba(54, 162, 235, 0.2)',
//                 'rgba(255, 206, 86, 0.2)',
//                 'rgba(75, 192, 192, 0.2)',
//                 'rgba(255, 99, 132, 0.2)',
//                 'rgba(54, 162, 235, 0.2)',
//                 'rgba(255, 206, 86, 0.2)'

//             ],
//             borderColor: [
//                 'rgba(255, 99, 132, 1)',
//                 'rgba(54, 162, 235, 1)',
//                 'rgba(255, 206, 86, 1)',
//                 'rgba(75, 192, 192, 1)',
//                 'rgba(153, 102, 255, 1)',
//                 'rgba(255, 159, 64, 1)',
//                 'rgba(54, 162, 235, 1)',
//                 'rgba(255, 206, 86, 1)',
//                 'rgba(75, 192, 192, 1)',
//                 'rgba(255, 99, 132, 1)',
//                 'rgba(54, 162, 235, 1)',
//                 'rgba(255, 206, 86, 1)'
//             ],
//             borderWidth: 1
//         }]
//     },
//     options: {
//         scales: {
//             yAxes: [{
//                 ticks: {
//                     beginAtZero: true
//                 }
//             }]
//         }
//     }
// });
</script>