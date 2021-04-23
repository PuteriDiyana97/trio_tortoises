<div class="kt-subheader-search">
	<div class="kt-container  kt-container--fluid">
		<h3 class="kt-subheader-search__title">
			Birthday Voucher
			<span class="kt-subheader-search__desc"></span>
		</h3>
	</div>
</div>
<style type="text/css">
	.capitalize {
  text-transform: capitalize;
}
</style>
<!-- begin:: Content -->
<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
	<form class="kt-form" id="form_filter" name="form_filter" action="" method="post" enctype="multipart/form-data">
		<div class="kt-portlet kt-portlet--mobile">
			<div class="kt-portlet__head">
				<div class="kt-portlet__head-label">
					<h3 class="kt-portlet__head-title">
						Birthday Voucher List
					</h3>
				</div>
				<div class="kt-portlet__head-toolbar">
					<div class="kt-portlet__head-wrapper">
						<div class="kt-portlet__head-actions">
							<a href="<?=site_url('birthday_voucher/create')?>" class="btn btn-brand btn-bold btn-font-sm btn-sm" id="btn_add" name="btn_add">
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
		                        	<div class="form-group">
		                        		<label>Voucher Name</label>
									<input type="text" class="form-control form-control-sm capitalize" id="filter_name" name="filter_name" placeholder="Voucher Name">
		                        	</div>
		                        </div>
		                        <div class="col-md-3">
											<label>Month</label>
											<select class="form-control kt-selectpicker" id="filter_month" name="filter_month" data-size="4" data-live-search="true">
												<option data-content="" value="">Select Month</option>
												<option data-content="January" value="1" >January</option>
												<option data-content="February" value="2">February</option>	
												<option data-content="March" value="3">March</option>
												<option data-content="April" value="4" >April</option>	
												<option data-content="May" value="5" >May</option>
												<option data-content="June" value="6">June</option>	
												<option data-content="July" value="7">July</option>
												<option data-content="August" value="8" >August</option>	
												<option data-content="September" value="9">September</option>
												<option data-content="October" value="10">October</option>	
												<option data-content="November" value="11">November</option>
												<option data-content="December" value="12" >December</option>	
											</select>
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
					</div>
					</div>
				</div><br>
					<!--begin: Datatable -->
					<table class="table table-striped- table-bordered table-hover table-checkable data_table_server" id="data_table_server">
						<thead>
							<tr>
								<th class="text-center no-sort">No</th>
								<th class="text-center">Voucher Name</th> 
								<th class="text-center">Voucher Value (RM)</th>
								<th class="text-center">Month</th>
								<th class="text-center no-sort">Action</th>
							</tr>
						</thead>
					</table>

					<input type="hidden" id="selected_id" name="selected_id" value="" />

					<!--end: Datatable -->
				</div>
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
	                <h5 class="modal-title" id="modal_title">Voucher</h5>
	                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	                </button>
	            </div>
	            <div class="modal-body modal_info">
	            	<input type="hidden" id="ids" name="ids" value="" />
                    <div class="form-group row">
	            		<div class="col-md-6">
							<label>Voucher Name</label>
							<input type="text" class="form-control capitalize" id="voucher_name" name="voucher_name" placeholder="Voucher Name">
						</div>
						<div class="col-md-6">
							<label>Voucher Value</label>
							<input type="number" class="form-control" min="1"  id="voucher_value" name="voucher_value" placeholder="Voucher Value" required="">
						</div>
					</div>
					<div class="form-group row">
						<div class="col-md-6">
			                        <label>Month</label>
					                <select class="form-control kt-selectpicker" id="month" name="month" data-size="4" data-live-search="true">
										<option data-content="January" value="1" >January</option>
										<option data-content="February" value="2">February</option>	
										<option data-content="March" value="3">March</option>
										<option data-content="April" value="4" >April</option>	
										<option data-content="May" value="5" >May</option>
										<option data-content="June" value="6">June</option>	
										<option data-content="July" value="7">July</option>
										<option data-content="August" value="8" >August</option>	
										<option data-content="September" value="9">September</option>
										<option data-content="October" value="10">October</option>	
										<option data-content="November" value="11">November</option>
										<option data-content="December" value="12" >December</option>	
									</select>
			            </div>
					</div>
					<div class="form-group row">
						<div class="col-md-12">
							<label>Description </label>
							<textarea type="text" class="form-control " id="description" name="description" placeholder="Description" required=""></textarea>
						</div>
					</div><br>
					<div class="row">
						<div class="col-md-6 v_before">
							<label>Current Voucher Visual(Before Used)</label><br>
							<center><div class="col-lg-6 col-md-6" id="img_show"></div></center>
						</div>
						<div class="col-md-6 v_after">
							<label>Current Voucher Visual(After Used)</label><br>
							<center><div class="col-lg-6 col-md-6" id="img_show_after"></div></center>
						</div>
						
					</div><br>
					<div class="form-group row">
						<div class="col-lg-6 col-md-6">
							<label>New Voucher Visual(Before Used)</label>
							<input type="file" class="form-control form-control-sm" id="voucher_img_before" name="voucher_img_before">
							<div>
                                <span>Allowed type: png | jpg | jpeg</span><br>
                                <span style="float: left;">(Max: 13MB, Height:600px Width:300px)</span>
                            </div>
						</div>
						<div class="col-lg-6 col-md-6">
							<label>New Voucher Visual(After Used)</label>
							<input type="file" class="form-control form-control-sm" id="voucher_img_after" name="voucher_img_after">
							<div>
                                <span>Allowed type: png | jpg | jpeg</span><br>
                                <span style="float: left;">(Max: 13MB, Height:600px Width:300px)</span>
                            </div>
						</div>
					</div>  

	            </div>
	            <div class="modal-footer">
					
	                <button type="button" class="btn btn-secondary btn-bold btn-font-sm btn-sm btn-sm" id="btn_close" name="btn_close" data-dismiss="modal">Close</button>
	                <button type="submit" class="btn btn-success btn-bold btn-font-sm btn-sm btn-sm" id="btn_save" name="btn_save"><i class="fa fa-save"></i>Save</button>
	            </div>
	        </div>
	    </div>
	</div>
</form>

<script src="<?=base_url()?>assets/js/scripts.bundle.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.11/summernote-lite.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.11/summernote-lite.js"></script>
<script type="text/javascript">
$("#description").summernote({
				        tabsize: 2,
				        height: 100,
				        callbacks: {
				            onImageUpload : function(files, editor, welEditable) {
				                for(var i = files.length - 1; i >= 0; i--) {
				                    sendFile(files[i], this);
				                }
				            }
				        }
				    });
function sendFile(file, el)
{
    var form_data = new FormData();
    form_data.append('file', file);
    $.ajax({
        data: form_data,
        type: "POST",
        url: '<?php echo site_url('voucher/Birthday_voucher_Controller/summernote_sync_image')?>',
        cache: false,
        contentType: false,
        processData: false,
        success: function(url) {
            console.log('url', url);
            $(el).summernote('editor.insertImage', url);
        }
    });
}

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
                url: "<?php echo site_url("birthday_voucher/delete");?>",
                data: dataString,
                cache: false,
                dataType: 'json',
                success: function(data)
                {
                	console.log(data);
                    if(data.status == 1)
	                {
	                    swal.fire({
	                        title: data.status_message,
	                        text: "",
	                        type: "success"
	                    }).then(function() {
	                        $('#form_modal').modal('hide');
	                        location.href = "<?=site_url('birthday_voucher/birthday')?>";
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
	                        location.href = "<?=site_url('birthday_voucher/birthday')?>";
	                         loading_off();
	                    });
	                }
                }
            });
        }
        
    }); 
}
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
	            url: "<?=site_url('birthday_voucher/update')?>",
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
	                        location.href = "<?=site_url('birthday_voucher/birthday')?>";
	                         loading_off();
	                    });

	                }
	                else
	                {
	                   //  console.log('get-participant-save suceess but fail',data);
	                    // alert('Action Participant fail.');

	                     swal.fire({
	                        title: "Error",
	                        html: data.status_message,
	                        type: "error"
	                    }).then(function() {
	                        // $('#form_modal').modal('hide');
	                        // location.href = "<?=site_url('birthday_voucher/birthday')?>";
	                         loading_off();
	                    });

	                }
	            }
	        });
	    }
	});
$(function(){
	$('.kt-selectpicker').selectpicker();

    $('.date_picker').datepicker({
        todayHighlight: true,
        autoclose: true,
        format: "yyyy-mm-dd",
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

		$(this).removeData();

		$('#voucher_name').val('');
		$('#voucher_value').val('');
		$('#description').val('');
		//$('#quantity').val('');
		//$('#exchange_point').val('');
		$('#voucher_img_before').val('');
		$('#voucher_img_after').val('');
		$('#start_date').val('');
		$('#end_date').val('');

        $('#img_show').html('');
        $('#img_show_after').html('');
     //    $('#img_show').append('');
	    // $('#img_show_after').append('');

		$('#ids').val('');

		$('#modal_title').text('Voucher');
    });

    var data_table_server = $('.data_table_server').DataTable({ 

		"scrollY": false,
		"scrollX": true,
		"scrollCollapse": true,
	    "processing": true, 
	    "serverSide": true, 
	     
	    "ajax": {
	        "url": "<?=site_url('birthday_voucher/list')?>",
	        "type": "POST",
	        data: function (d) {
	        	d.filter_code = $('#filter_code').val();
                d.filter_name = $('#filter_name').val();
                d.filter_month = $('#filter_month').val();
	        },
	    },
	    //list before next page
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
	    	$( row ).find('td:eq(0),td:eq(5)').addClass('text-center');
	    },
	    order: [[ 1, "ASC" ]],
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
        $('#filter_month').val('');
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
	        url     : "<?=site_url('birthday_voucher/details')?>",
	        data    : dataString,
	        dataType: 'json',
	        cache   : false,
	        success : function(data)
	        {
	        	//console.log("data",data);

	        	if ( data.length != '0' )
	        	{
					$('#voucher_name').val(data.voucher_name);
					$('#voucher_value').val(data.voucher_value);
					$("#description").summernote("code", data.description);
					//$('#exchange_point').val(data.exchange_point);
					//$('#quantity').val(data.quantity);
					//$('#voucher_code').val(data.voucher_code);
					// $('#voucher_img_before').val(data.voucher_img_before);
					// $('#voucher_img_after').val(data.voucher_img_after);
					$('#start_date').val(data.start_date);
					$('#end_date').val(data.end_date);
					$('#month').selectpicker('val',data.month);

					if(data.voucher_img_before == 0)
				    {
				      $('#img_show').append('');
				    }
				    else
				    {
				      $('#img_show').append('<img width="100px" height="100px" src="<?=site_url()?>assets/upload_files/voucher/' + data.voucher_img_before + '" />');
				    }

				    if(data.voucher_img_after == 0)
				    {
				      $('#img_show_after').append('');
				    }
				    else
				    {
				      $('#img_show_after').append('<img width="100px" height="100px" src="<?=site_url()?>assets/upload_files/voucher/' + data.voucher_img_after + '" />'); 
				    }

					$('#ids').val(ids);

		        	loading_off();

					$('#modal_title').text('Edit Voucher');
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

});
</script>