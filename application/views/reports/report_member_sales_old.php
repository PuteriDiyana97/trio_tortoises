<div class="kt-subheader-search">
	<div class="kt-container  kt-container--fluid">
		<h3 class="kt-subheader-search__title">
			Master Sales
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
											<label>Member ID</label>
											<input type="text" class="form-control form-control-sm" id="filter_id" name="filter_id" placeholder="Member ID" value="">
				                        </div>
				                        <div class="form-group">
				                            <label>Date</label>
						                        <div class="input-daterange input-group" id="kt_datepicker_5">
													<input type="text" class="form-control form-control-sm" id="filter_date_start" name="filter_date_start">
													<div class="input-group-append">
														<span class="input-group-text"><i class="la la-ellipsis-h"></i></span>
													</div>
													<input type="text" class="form-control form-control-sm" id="filter_date_end" name="filter_date_end">
												</div>
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
					<i class="fa fa-download"></i> Master Sales
					</a>
				</div><br>
				<!--begin: Datatable -->
				<table class="table table-striped- table-bordered table-hover table-checkable data_table_server" id="data_table_server">
					<thead>
						<tr>
							<th class="text-center no-sort">No</th>
							<th class="text-center">Member ID</th>
							<th class="text-center">Member Name</th>
							<th class="text-center">Nationality</th>
							<th class="text-center">Total Points Used</th>
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
<script src="<?=base_url()?>assets/js/pages/crud/forms/widgets/bootstrap-datepicker.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<script type="text/javascript">
// when click button search
    $('#btn_search').on('click',function(e){
        $('#selected_id').val('');

        e.preventDefault();
        data_table_server.draw();
    });

    // when click button reset
    $('#btn_reset').on('click',function(e){

        $('#filter_title').val('');
        $('#filter_date_start').val('');
        $('#filter_date_end').val('');
        $('#selected_id').val('');

        e.preventDefault();
        data_table_server.draw();   
    });
function load_datepicker()
{
    var last_month = new Date();
    last_month.setDate(last_month.getDate() - 30);
    // set default today date
    $("#filter_date_start").datepicker().datepicker("setDate", last_month);
    $("#filter_date_end").datepicker().datepicker("setDate", new Date());
}

$(function() {

    $('#kt_datepicker_5').datepicker({
    	   // format: "dd/mm/yyyy",
        format: "dd/mm/yyyy",
        toggleActive: true,
        autoclose: true,
        orientation: "bottom left",
        templates: {
            leftArrow: '<i class="la la-angle-left"></i>',
            rightArrow: '<i class="la la-angle-right"></i>'
        }

    }).on('keydown', function(e) {
    	e.preventDefault();

    }).on('hide', function(e) {
		// to avoid from clear all input inside modal
	    e.preventDefault();
	    e.stopPropagation();
  	});

    load_datepicker();

});

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
                url: "<?=site_url('sales_export');?>",
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
	        "url": "<?=site_url('report/member-sales-list')?>",
	        "type": "POST",
	        data: function (d) {
                d.filter_id = $('#filter_id').val();
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