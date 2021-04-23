<div class="kt-subheader-search">
	<div class="kt-container  kt-container--fluid">
		<h3 class="kt-subheader-search__title">
			Master Member
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
				                        <div class="col-md-2">
											<strong>Member ID</strong>
											<input type="text" class="form-control form-control-sm" id="filter_id" name="filter_id" placeholder="Member ID" value="">
				                        </div>
				                        <!-- <div class="col-md-2">
											<strong>City</strong>
											<input type="text" class="form-control form-control-sm" id="filter_city" name="filter_city" placeholder="City" value="">
				                        </div>
				                        <div class="col-md-2">
											<strong>State</strong>
											<input type="text" class="form-control form-control-sm" id="filter_state" name="filter_state" placeholder="State" value="">
				                        </div> -->
				                        <div class="col-md-2">
											<strong>Country</strong>
											<input type="text" class="form-control form-control-sm" id="filter_country" name="filter_country" placeholder="Country" value="">
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
					<i class="fa fa-download"></i> Master Member
					</a>
				</div><br>
				<!--begin: Datatable -->
				<table class="table table-striped- table-bordered table-hover table-checkable data_table_server" id="data_table_server">
					<thead>
						<tr>
							<th class="text-center no-sort">No</th>
							<th class="text-center">Member ID</th>
							<th class="text-center">Member Name</th>
							<th class="text-center">Country</th>
							<th class="text-center">Current Points</th>
							<th class="text-center">Total Points</th>
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
                url: "<?=site_url('member_export');?>",
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

function delete_data(dataString)
{
	Swal.fire({
        title: 'Are you sure to delete selected record(s)?',
        text: '',
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#4cbe71',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes!',
        cancelButtonText: 'No, cancel!',
        confirmButtonClass: 'btn btn-success',
        cancelButtonClass: 'btn btn-danger m-l-10',
        buttonsStyling: true,
        reverseButtons: true,
        allowOutsideClick: false
        
    }).then(function(result) {

        if (result.value) 
        {
        	loading_on();
        
            $.ajax({
                type: "POST",
                url: "<?php echo site_url("member/delete");?>",
                data: dataString,
                cache: false,
                dataType: 'json',
                success: function(data)
                {
                	console.log(data);

                    var msg_title = 'Fail!';
                    var msg_content = 'Selected record(s) not deleted';
                    var msg_status = 'error';
                    
                    //successfully updated
                    if ( data.rst > 0 )
                    {
                        msg_title = 'Success!';
                        msg_content = 'Selected record(s) deleted';
                        msg_status = 'success';
                    }
                    
                    loading_off();

                    Swal.fire({
                        title: msg_title,
                        text: msg_content,
                        type: msg_status,
                        allowOutsideClick: false
                    }).then(function () {
                        $('.data_table_server').DataTable().draw();
                        $('#selected_id').val('');
                    });
                }
            });
        }
        
    }); 
}

$(function(){

    $('.kt-selectpicker').selectpicker();

    $('.kt_datepicker_4_3').datepicker({
        todayHighlight: true,
        autoclose: true,
        format: "dd-M-yyyy",
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

    // clear field value inside modal
	$('#modal_form').on('hide.bs.modal',function(){
		$('#full_name').val('');
		$('#email').val('');
		$('#mobile_no').val('');
		$('#ic_no').val('');
		$('#gender').val('').trigger('change');
		$('#kt_datepicker_4_3').val('');
		$('#city').val('');
		$('#address').val('');
		$('#postcode').val('');
		$('#state').val('');
		$('#country').val('');

		$('#ids').val('');

		$('#modal_title').text('Member');
    });

    var data_table_server = $('.data_table_server').DataTable({ 

		"scrollY": '150vh',
		// "scrollX": true,
		// "scrollCollapse": true,
	    "processing": true, 
	    "serverSide": true, 
	     
	    "ajax": {
	        "url": "<?=site_url('report/master-member-list')?>",
	        "type": "POST",
	        data: function (d) {
                
                d.filter_id = $('#filter_id').val();
                d.filter_city = $('#filter_city').val();
                d.filter_state = $('#filter_state').val();
                d.filter_country = $('#filter_country').val();
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
	    order: [[ 2, "ASC" ]],

	});

	var arr_cb_val = [];
	


    // when click button search
    $('#btn_search').on('click',function(e){

        $('#selected_id').val('');

        e.preventDefault();
        data_table_server.draw();
    });

    // when click button reset
    $('#btn_reset').on('click',function(e){

        $('#filter_id').val('');
        $('#filter_city').val('');
        $('#filter_state').val('');
        $('#filter_country').val('');
        $('#selected_id').val('');

        e.preventDefault();
        data_table_server.draw();   
    });

	// when click button view
	$('.data_table_server').on('click','.btn_view',function(){
		
		loading_on();

		var ids = $(this).attr('ids');

		var dataString = "ids="+ids;
        // console.log(dataString);
	    $.ajax({
	        type    : "POST",
	        url     : "<?=site_url('report/master-member-details')?>",
	        data    : dataString,
	        dataType: 'json',
	        cache   : false,
	        success : function(data)
	        {
	        	 console.log("data",data);

	        	if ( data.length != '0' )
	        	{
	        		$('#full_name').val(data.name);
					$('#email').val(data.email);
					$('#mobile_no').val(data.contact_no);
					$('#gender').val(data.gender).trigger('change');
					$('#ic_no').val(data.ic_no);
					$('#kt_datepicker_4_3').val(data.date_of_birth);
					$('#address').val(data.address);
					$('#zipcode').val(data.zipcode);
					$('#city').val(data.city);
					$('#state').val(data.state);
					$('#country').val(data.country);

					$('#ids').val(ids);

		        	loading_off();

					$('#modal_title').text('Edit Member');
		        	$('#modal_form').modal('show');
		        }
		        else
		        {
	                loading_off();

	                Swal.fire({
                        title: 'Selected data not found',
                        text: '',
                        type: 'error',
                        allowOutsideClick: false
                    }).then(function () {
                    });
		        }
	        }
	    });

	});

	// when click btn_delete in each row
	$('.data_table_server').on('click','.btn_delete',function(){

        var ids = $(this).attr('ids');

        if ( ids != '' )
        {
            var dataString = "ids="+ids;

        	delete_data(dataString);
        }

    });

    // when click button delete multiple
    $('#btn_delete').on('click',function(){
        
        var ids = $('#selected_id').val();

        if ( ids == '' )
        {
            Swal.fire({
                title: 'Please select at least one record!',
                text: '',
                type: 'warning',
                timer: 1000,
                showCancelButton: false,
                showConfirmButton: false,
                // allowOutsideClick: false
            }).then(function(result) {
                if (result.dismiss === 'timer'){}
            });
        }
        else
        {
            var dataString = "ids="+ids;

        	delete_data(dataString);
        }

    });

    $('#form_modal').on('submit', function(e) {
	    e.preventDefault();
	    $('.div_error_msg').removeClass('alert alert-danger').html('');
	   
	    var error_no = 0,
	        error_msg = [];

	    if (error_no > 0) {
	        Swal.fire({
	            title: "Warning!",
	            text: "Please check your information.",
	            type: "warning"
	        }).then(function() {
	            $('.div_error_msg').addClass('alert alert-danger').html("<ul><li>" + error_msg.join(
	                "</li><li>") + "</li></ul>");
	        });
	        return false;
	    } else {
	        loading_on();
	        var dataString = $('#form_modal').serialize();
	        console.log(dataString);
	        $.ajax({
	            type: "POST",
	            url: "<?=site_url('report/master-member-update')?>",
	            data: dataString,
	            dataType: 'json',
	            enctype: 'multipart/form-data',
	            processData: false,
	            contentType: false,
	            data: new FormData(this),
	            cache: false,
	            success: function(data) {
	                //alert(data);
	                console.log("frm submit", data);

	                  if(data.status == 1)
	                {
	                    Swal.fire({
	                        title: data.status_message,
	                        text: "",
	                        type: "success"
	                    }).then(function() {
	                        $('#form_modal').modal('hide');
	                        location.href = "<?=site_url('report/master-member')?>";
	                         loading_off();
	                    });

	                }
	                else
	                {
	                   //  console.log('get-participant-save suceess but fail',data);
	                    // alert('Action Participant fail.');

	                     Swal.fire({
	                        title: data.status_message,
	                        text: "",
	                        type: "error"
	                    }).then(function() {
	                        $('#form_modal').modal('hide');
	                        location.href = "<?=site_url('report/master-member')?>";
	                         loading_off();
	                    });

	                }
	            }
	        });
	        // console.log(dataString);
	    }
	});


});

</script>