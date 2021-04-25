<div class="kt-subheader-search">
	<div class="kt-container  kt-container--fluid">
		<h3 class="kt-subheader-search__title">
			News
		</h3>
	</div>
</div>
<style>
.img_advs{
	transition: transform .2s;
	height:100px;
	max-width:100%;
}
.img_edit{
	height:100px;
	max-width:100%;
}
</style>
<!-- begin:: Content -->
<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
	<form class="kt-form" id="form_filter" name="form_filter" action="" method="post" enctype="multipart/form-data">
		<div class="kt-portlet kt-portlet--mobile">
			<div class="kt-portlet__head">
				<div class="kt-portlet__head-label">
					<h3 class="kt-portlet__head-title">
						List of News
					</h3>
				</div>
				<div class="kt-portlet__head-toolbar">
					<div class="kt-portlet__head-wrapper">
						<div class="kt-portlet__head-actions">
							<a href="<?=site_url('snews/create')?>" class="btn btn-brand btn-bold btn-font-sm btn-sm" id="btn_add" name="btn_add">
								<i class="fa fa-plus"></i>New
							</a>
						</div>
					</div>
				</div>
			</div>
			<div class="kt-portlet__body">
				<!--start: Filter -->
				<div class="kt-grid">
            		<div class="kt-grid__item kt-grid__item--middle">
	                    <div class="row">
	                        <div class="col-md-2">
								<label>Title</label>
								<input type="text" class="form-control form-control-sm" id="filter_title" name="filter_title" placeholder="Title">
	                        </div>
	                        <div class="col-lg-4"><br>
		                    	<button type="button" class="btn btn-sm btn-default btn-bold btn-font-sm btn-sm" id="btn_search" name="btn_search">
		                    		<i class="fa fa-search"></i> Search
		                    	</button>
		                    	<button type="button" class="btn btn-sm btn-dark btn-bold btn-font-sm btn-sm" id="btn_reset" name="btn_reset">
		                    		<i class="fa fa-eraser"></i> Reset
		                    	</button>
	                    	</div>
	                </div>
		        </div><br>
		        <!--end: Filter -->
				<!--begin: Datatable -->
				<table class="table table-striped- table-bordered table-hover table-checkable data_table_server" id="data_table_server">
					<thead>
						<tr>
							<th class="text-center no-sort">No</th>
							<th class="text-center">Title</th>
							<th class="text-center">Release Date</th>
							<th class="text-center">Expiry Date</th>
							<th class="text-center">Status</th>
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

<!--begin:: Modal-->
<form action="" method="POST" id="form_modal" name="form_modal" enctype="multipart/form-data">
	<div class="modal fade" id="modal_form" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	    <div class="modal-dialog modal-lg" role="document">
	        <div class="modal-content">
	            <div class="modal-header">
	                <h5 class="modal-title" id="modal_title">About Us</h5>
	                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	                </button>
	            </div>
	            <div class="modal-body">
	            	<div class="form-group row">
	            		<div class="col-md-3">
							<label>Title</label>
							<input type="text" class="form-control form-control-sm" id="title" name="title" placeholder="Title">
						</div>
						<div class="col-md-9">
							<label>Description</label>
							<textarea type="text" class="form-control form-control-sm" id="description" name="description" placeholder="Description"></textarea>
						</div>
					</div>
					<div class="form-group row">
						<div class="col-md-6">
							<label>Current Banner</label>
							<input type="" class="form-control form-control-sm" id="banner" name="banner" value="">
						</div>		
						<div class="col-md-6">
							<label>Banner</label>
							<input type="file" class="form-control form-control-sm" id="banner" name="banner" placeholder="Banner">
						</div>
					</div>  
					<div class="row">
						<div class="col-md-4">
							<label>Release Date</label>
							<input type="text" class="form-control date_picker" id="start_date" name="start_date" placeholder="Release Date">
						</div>
						<div class="col-md-4">
							<label>Expiry Date</label>
							<input type="text" class="form-control date_picker" id="expiry_date" name="expiry_date" placeholder="Expiry Date">
						</div>
						<div class="col-md-4">
							<label>Status</label><br>
                            <input type="radio" id="choice_status" name="choice_status" value="1">
                            <label for="push">Publish</label> &nbsp;
                            <input type="radio" id="choice_status" name="choice_status" value="0">
                            <label for="not_push">Not Publish</label><br>
						</div>
						
					</div><br>
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
                url: "<?php echo site_url("snews/delete");?>",
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

                    swal.fire({
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

    $('.date_picker').datepicker({
        todayHighlight: true,
        autoclose: true,
        format: "yyyy-mm-dd",
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
		$('#title').val('');
		$('#description').val('');
		$('#start_date').val('');
		$('#expiry_date').val('');
		$('#push_news').val('');
		$('#ids').val('');

		$('#modal_title').text('News');
    });

    var data_table_server = $('.data_table_server').DataTable({ 

		"scrollY": '50vh',
		"scrollX": true,
		"scrollCollapse": true,
	    "processing": true, 
	    "serverSide": true, 
	     
	    "ajax": {
	        "url": "<?=site_url('snews/list')?>",
	        "type": "POST",
	        data: function (d) {
	        	d.filter_title = $('#filter_title').val();
	        },
	    },
	    "pageLength": 100,
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
	    	$( row ).find('td:eq(0),td:eq(1),td:eq(2),td:eq(3),td:eq(4),td:eq(5)').addClass('text-center');
	    },
	    order: [[ 3, "ASC" ]],

	});

	// when click button new
	$('#btn_add').on('click',function(){

		$('#modal_title').text('Create News');
		$('#modal_form').modal('show');
	});

	// when click button search
    $('#btn_search').on('click',function(e){
        $('#selected_id').val('');

        e.preventDefault();
        data_table_server.draw();
    });

    // when click button reset
    $('#btn_reset').on('click',function(e){

        $('#filter_title').val('');
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
	        url     : "<?=site_url('snews/details')?>",
	        data    : dataString,
	        dataType: 'json',
	        cache   : false,
	        success : function(data)
	        {
	        	// console.log("data",data);

	        	if ( data.length != '0' )
	        	{
					$('#title').val(data.title);
					$('#description').val(data.description);
					$('#start_date').val(data.start_date);
					$('#expiry_date').val(data.expiry_date);
					$('#push_news').val(data.push_news);

					$('#ids').val(ids);

		        	loading_off();

					$('#modal_title').text('Edit News Detail');
		        	$('#modal_form').modal('show');
		        }
		        else
		        {
	                loading_off();

	                swal.fire({
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
	            url: "<?=site_url('snews/update')?>",
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
	                        location.href = "<?=site_url('snews')?>";
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
	                        location.href = "<?=site_url('snews')?>";
	                         loading_off();
	                    });

	                }
	            }
	        });
	        // console.log(dataString);
	    }
	});

</script>