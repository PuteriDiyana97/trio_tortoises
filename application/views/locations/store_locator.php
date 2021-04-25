<style type="text/css">
	.capitalize {
        text-transform: capitalize;
      }
</style>
<div class="kt-subheader-search">
	<div class="kt-container  kt-container--fluid">
		<h3 class="kt-subheader-search__title">
			Store Locator
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
						Location List
					</h3>
				</div>
				<div class="kt-portlet__head-toolbar">
					<div class="kt-portlet__head-wrapper">
						<div class="kt-portlet__head-actions">
							<a href="<?=site_url('store-location/create')?>" class="btn btn-brand btn-bold btn-font-sm btn-sm" id="btn_add" name="btn_add">
								<i class="fa fa-plus"></i>New
							</a>
						</div>
					</div>
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
								<label>Store Name</label>
								<input type="text" class="form-control form-control-sm" id="filter_name" name="filter_name" placeholder="Store Name" value="">
	                        </div>
	                        <div class="col-md-4"><br>
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

				<!--begin: Datatable -->
				<table class="table table-striped- table-bordered table-hover table-checkable data_table_server" id="data_table_server">
					<thead>
						<tr>
							<th class="text-center no-sort">No</th>
							<th class="text-center">Store Name</th>
							<th class="text-center">Store Address</th>
							<th class="text-center no-sort">Open Time</th>
							<th class="text-center no-sort">Close Time</th>
							<th class="text-center no-sort">Action</th>
						</tr>
					</thead>
				</table>

				<input type="hidden" id="selected_id" name="selected_id" value="" />

				<!--end: Datatable -->
			</div>
		</div>
	</form>
</div>
<!-- end:: Content -->

<!--begin:: Modal edit-->
<form action="" method="POST" id="form_modal" name="form_modal" enctype="multipart/form-data">
	<div class="modal fade" id="modal_form" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	    <div class="modal-dialog modal-lg" role="document">
	        <div class="modal-content">
	            <div class="modal-header">
	                <h5 class="modal-title" id="modal_title">Store Locator</h5>
	                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	                </button>
	            </div>
	            <div class="modal-body">
                    <div class="form-group row">
						<div class="col-lg-6 col-md-6">
							<label>Store Name <?=COMPULSORY;?></label>
							<input type="text" class="form-control form-control-sm capitalize" id="store_name" name="store_name" placeholder="Store Name" required>
						</div>
						<div class="col-md-2"> 
                                          <strong for="open_hours">Open Time <?=COMPULSORY;?></strong>
                                          <!-- <input type="text" class="form-control" name="open_time" id="open_time" placeholder="Open Hours" required=""> -->
                                          <input class="form-control" id="kt_timepicker_1" name="open_time" readonly="" placeholder="Select time" type="text" required="">
                                    </div>
                                    <div class="col-md-2"> 
                                          <strong for="open_hours">Close Time <?=COMPULSORY;?></strong>
                                          <!-- <input type="text" class="form-control" name="close_time" id="close_time" placeholder="Close Hours" required=""> -->
                                          <input class="form-control" id="kt_timepicker_1" name="close_time" readonly="" placeholder="Select time" type="text" required="">
                                    </div>
					</div>

					<div class="form-group row">
						<div class="col-lg-6 col-md-6">
							<label>Attachment</label>
							<input type="file" class="form-control form-control-sm" id="attachment" name="attachment" placeholder="Attachment" value="">
						</div>
						<div class="col-lg-6 col-md-6">
							<label>Latitude</label>
							<input type="text" class="form-control form-control-sm" id="latitude" name="latitude" placeholder="Latitude" value="">
						</div>
					</div>
					<div class="form-group row">
						<div class="col-lg-6 col-md-6">
							<label>Longitude</label>
							<input type="text" class="form-control form-control-sm" id="longitude" name="longitude" placeholder="Longitude" value="">
						</div>
					</div>
	            </div>
	            <div class="modal-footer">
					<input type="hidden" id="ids" name="ids" value="" />
	                <button type="button" class="btn btn-secondary btn-bold btn-font-sm btn-sm btn-sm" id="btn_close" name="btn_close" data-dismiss="modal">Close</button>
	                <button type="submit" class="btn btn-success btn-bold btn-font-sm btn-sm btn-sm" id="btn_save" name="btn_save"><i class="fa fa-save"></i>Save</button>
	            </div>
	        </div>
	    </div>
	</div>
</form>
<!--end:: Modal-->

<!--begin::Page Scripts(used by this page) -->

<script type="text/javascript">

function delete_data(dataString)
{
	swal.fire({
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
                url: "<?php echo site_url("store-location/delete");?>",
                data: dataString,
                cache: false,
                dataType: 'json',
                success: function(data)
                {
                	console.log(data);

                     msg_title = 'Success!';
                        msg_content = 'Selected record(s) deleted';
                        msg_status = 'success';
                    
                    //successfully updated
                    if ( data.rst > 0 )
                    {
                        var msg_title = 'Fail!';
	                    var msg_content = 'Selected record(s) not deleted';
	                    var msg_status = 'error';
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

    $('.date').datepicker({
        todayHighlight: true,
        autoclose: true,
        format: "dd-M-yyyy",
        orientation: "top left",
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
		$('#store_name').val('');
		$('#open_time').val('');
		$('#close_time').val('');
		$('#store_address').val('');
		// $('#').val('');

		$('#ids').val('');

		$('#modal_title').text('Store Locator');
    });

    var data_table_server = $('.data_table_server').DataTable({ 

		"scrollY": false,
		"scrollX": true,
		"scrollCollapse": true,
	    "processing": true, 
	    "serverSide": true, 
	     
	    "ajax": {
	        "url": "<?=site_url('store-location/list')?>",
	        "type": "POST",
	        data: function (d) {
                d.filter_name = $('#filter_name').val();
	        },
	    },
	    "pageLength": 50,
	    "language": {
	        "emptyTable": "No data available in the table",
	        "processing": '<div class="alert alert-default" style="color:#ddad4b"><i class="fa fa-circle-o-notch fa-spin fa-1x fa-fw"></i><b>Processing...</b></div>'
	    },

		"searching": true, //disable searching
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
	    	$( row ).find('td:eq(0),td:eq(1),td:eq(2),td:eq(3),td:eq(4),td:eq(5),td:eq(6),td:eq(7),td:eq(8),td:eq(9),td:eq(10)').addClass('text-center');
	    },
	    order: [[ 3, "ASC" ]],
	    // "columnDefs": [
	    // { 
	    //     "targets": [ 0 ], 
	    //     "orderable": false, 
	    // },
	    //],

	});

    // when click button search
    $('#btn_search').on('click',function(e){

        $('#selected_id').val('');

        e.preventDefault();
        data_table_server.draw();
    });

    // when click button reset
    $('#btn_reset').on('click',function(e){

        $('#filter_name').val('');
        $('#selected_id').val('');

        e.preventDefault();
        data_table_server.draw();   
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
            swal.fire({
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
	        swal.fire({
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
	            url: "<?=site_url('store-location/update')?>",
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
	                    swal.fire({
	                        title: data.status_message,
	                        text: "",
	                        type: "success"
	                    }).then(function() {
	                        $('#form_modal').modal('hide');
	                        location.href = "<?=site_url('store-locator')?>";
	                         loading_off();
	                    });

	                }
	                else
	                {
	                   //  console.log('get-participant-save suceess but fail',data);
	                    // alert('Action Participant fail.');

	                     swal.fire({
	                        title: data.status_message,
	                        text: "",
	                        type: "error"
	                    }).then(function() {
	                        $('#form_modal').modal('hide');
	                        location.href = "<?=site_url('store-locator')?>";
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