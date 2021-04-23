<div class="kt-subheader-search">
	<div class="kt-container  kt-container--fluid">
		<h3 class="kt-subheader-search__title">
			Master Voucher
			<span class="kt-subheader-search__desc"></span>
		</h3>
	</div>
</div>

<!-- begin:: Content -->
<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
	<form class="kt-form" id="form_filter" name="form_filter" action="" method="post" enctype="multipart/form-data">
		<div class="kt-portlet kt-portlet--mobile">
			<div class="kt-portlet__head">
				<div class="kt-portlet__head-label">
					<h3 class="kt-portlet__head-title">
						Report List
					</h3>
				</div>
			</div>
			<div class="kt-portlet__body">
				<div class="accordion accordion-solid accordion-toggle-plus" id="accordionExample3">
					<div class="card">
						<div class="card-header" id="headingThree3">
							<div class="card-title collapsed" data-toggle="collapse" data-target="#collapseThree3" aria-expanded="false">
								Advance Filter
							</div>
						</div>
						<div id="collapseThree3" class="collapse" data-parent="#accordionExample3" style=""><br>
							<!--start: Filter -->
							<div class="kt-grid">
			            		<div class="kt-grid__item kt-grid__item--middle">
				                    <div class="row">
				                        <div class="col-md-3">
											<strong>Member ID</strong>
											<input type="text" class="form-control form-control-sm" id="filter_id" name="filter_id" placeholder="Member ID" value="">
				                        </div>
				                        <div class="col-md-3">
											<strong>Voucher Name</strong>
											<input type="text" class="form-control form-control-sm" id="filter_name" name="filter_name" placeholder="Voucher Name" value="">
				                        </div>
				                        <div class="col-md-3">
											<strong>Voucher Redeemed Outlet Code</strong>
											<input type="text" class="form-control form-control-sm" id="filter_outlet_code" name="filter_outlet_code" placeholder="Voucher Redeemed Outlet Code" value="">
				                        </div>
				                        <div class="col-md-3"><br>
					                    	<button type="button" class="btn btn-sm btn-default btn-bold btn-font-sm btn-sm" id="btn_search" name="btn_search">
					                    		<i class="fa fa-search"></i> Search
					                    	</button>
					                    	<button type="button" class="btn btn-sm btn-dark btn-bold btn-font-sm btn-sm" id="btn_reset" name="btn_reset">
					                    		<i class="fa fa-eraser"></i> Reset
					                    	</button>
				                    	</div>
				                    </div>
				                </div>
					        </div>
					        <!--end: Filter -->
						</div>
					</div>
				</div><br>
				<div class="kt-portlet__head-actions">
					<label>Download Report:</label>
					<a href="javascript:void(0)" class="btn btn-brand btn-bold btn-font-sm btn-sm" id="btn_export" name="btn_export">
					<i class="fa fa-download"></i> Master Voucher
					</a>
				</div><br>
				
				<!--begin: Datatable -->
				<table class="table table-striped- table-bordered table-hover table-checkable data_table_server" id="data_table_server">
					<thead>
						<tr>
							<th class="text-center no-sort">No</th>
							<th class="text-center">Member ID</th>
							<th class="text-center">Member Name</th>
							<th class="text-center no-sort">Points Claimed</th>
							<th class="text-center no-sort">Points Claimed Date</th>
							<th class="text-center no-sort">Voucher Name</th>
							<th class="text-center no-sort">Voucher Value</th>
							<th class="text-center no-sort">Voucher Redeemed Date</th>
							<th class="text-center no-sort">Voucher Redeemed Outlet Code</th>
						</tr>
					</thead>
				</table>

				<input type="hidden" id="selected_id" name="selected_id" value="" />

				<!--end: Datatable -->
			</div>
		</div>
	</form>
</div>

<!--begin::Page Scripts(used by this page) -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<script type="text/javascript">
	$(function()
{
        $('#btn_export').on('click',function(){

        var filter_date_start = $('#filter_date_start').val();
        var filter_date_end   = $('#filter_date_end').val();
        
        var dataString = "fds="+filter_date_start+"&fde="+filter_date_end;
        console.log('datastring',dataString);
        Swal.fire({
            title: '<div class="progress progress-md"><div class="progress-bar progress-bar-inverse progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;"><span class="sr-only">Processing</span></div></div>',
            text: 'File is downloading, please wait...',
            showCloseButton: false,
            showCancelButton: false,
            showConfirmButton: false,
            allowOutsideClick: false
        }).then(function () {
        });
       
        $.ajax({
                type: "POST",
                url: "<?=site_url('voucher_export');?>",
                data: dataString,
                cache: false,
                dataType: 'json',
                success: function(data)
                {
                    // console.log(data);

                    if ( data.filesave == 1 )
                    {
                        Swal.fire({
                            title: 'File Download Completed!',
                            text: 'Please click Download to download file.',
                            type: 'success',
                            showCancelButton: true,
                            showCloseButton: false,
                            showConfirmButton: true,
                            confirmButtonText: '<i class="fa fa-download"></i> Download',
                            confirmButtonColor: '#32c861',
                            allowOutsideClick: false
                        }).then(function (result) {
					        if (result.value) {
					          console.log('Downloaded',result);
					          	location.href = '<?=site_url("export_files/")?>'+data.filename;
					        }else{
								console.log('Cancelled');					        	
					        }
					      }
					    );

        //                 Swal.fire({
					   //    title: "Confirm?",
					   //    text: "Are you sure?",
					   //    type: "warning",
					   //    showCancelButton: true,
					   //    confirmButtonColor: "#DD6B55",
					   //    confirmButtonText: "Confirm",
					   //    cancelButtonText: "Back"
					   //    }
					   //  ).then(function (result) {
					   //      if (result.value) {
					   //        console.log('CONFIRMED2',result);
					   //        	location.href = '<?=site_url("export_files/")?>'+data.filename;
					   //      }else{
								// console.log('CANCELLED');					        	
					   //      }
					   //    }
					   //  );

                    }
                    else
                    {
                        Swal.fire({
                            title: 'File Download Fail!',
                            text: 'Please try again later.',
                            type: 'error',
                            showCancelButton: false,
                            showCloseButton: false,
                            showConfirmButton: true,
                            allowOutsideClick: false
                        }).then(function () {});
                    }
                },
                complete: function(data)
                {
                    // console.log(data);
                }
            });
         });
});
var data_table_server = $('.data_table_server').DataTable({ 

		"scrollY": '150vh',
		// "scrollX": true,
		// "scrollCollapse": true,
	    "processing": true, 
	    "serverSide": true, 
	     
	    "ajax": {
	        "url": "<?=site_url('report/master-voucher-list')?>",
	        "type": "POST",
	        data: function (d) {
	        	d.filter_id = $('#filter_id').val();
                d.filter_name = $('#filter_name').val();
                d.filter_outlet_code = $('#filter_outlet_code').val();
	        },
	    },
	    "pageLength": 30,
	    "language": {
	        "emptyTable": "No data available in the table"
	    },

		"searching": false, //disable searching
		"bLengthChange": false, //disable show entries
		"columnDefs": [ {
	          "targets": 'no-sort',
	          "orderable": false,
	    } ],
	    initComplete: function(setting,json){
	        $('.tooltips').tooltip();
	        $('table.table.table-hover.dataTable.no-footer,.dataTables_scrollHeadInner').css("min-width", "100%");
	        $(window).trigger('resize'); 
	    },
	    createdRow: function( row, data, dataIndex ) {
	    	$( row ).find('td:eq(0)').addClass('text-center');
	    },
	    order: [[ 3, "ASC" ]],

	});
</script>