<div class="kt-subheader-search">
	<div class="kt-container  kt-container--fluid">
		<h3 class="kt-subheader-search__title">
			Setting User
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
						User List
					</h3>
				</div>
				<div class="kt-portlet__head-toolbar">
					<div class="kt-portlet__head-wrapper">
						<div class="kt-portlet__head-actions">
							<a href="<?=site_url("user/create")?>" class="btn btn-brand btn-bold btn-font-sm btn-sm">
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
	                        <div class="col-lg-4 col-md-4">
								<label>Name</label>
								<input type="text" class="form-control form-control-sm" id="filter_name" name="filter_name" placeholder="Name" value="">
	                        </div>
	                        <div class="col-lg-4 col-md-4">
								<label>User Type</label>
								<select class="form-control kt-selectpicker" id="filter_user_type" name="filter_user_type" data-size="5" data-live-search="true" required="">
								<option data-content="" value="">User Type</option>
								<option data-content="Admin" value="2">Admin</option>
								<option data-content="Operator" value="3">Operator</option>	
								</select>
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
					<thead><br>
						<tr>
							<th class="text-center no-sort">No</th>
							<th class="text-center">Type</th>
							<th class="text-center">Name</th>
							<th class="text-center">Email</th>
							<th class="text-center">Mobile Number</th>
							<th class="text-center">Last Login</th>
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
<form action="<?=site_url('user/save')?>" method="POST" id="form_modal" name="form_modal" enctype="multipart/form-data">
	<div class="modal fade" id="modal_form" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	    <div class="modal-dialog modal-lg" role="document">
	        <div class="modal-content">
	            <div class="modal-header">
	                <h5 class="modal-title" id="modal_title">Setting User</h5>
	                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	                </button>
	            </div>
	            <div class="modal-body">

                    <div class="form-group row">
						<div class="col-lg-6 col-md-6">
							<label>User Type <?=COMPULSORY;?></label>
							<select class="form-control kt-selectpicker" id="gender" name="gender" data-size="7" data-live-search="true" required="">
									<option data-content="" value="">Select User Type</option>
									<option data-content="Superadmin" value="Superadmin">Superadmin</option>
									<option data-content="Admin" value="Admin">Admin</option>	
							</select>
						</div>
	            		<div class="col-lg-6 col-md-6">
							<label>Login Username <?=COMPULSORY;?></label>
							<input type="text" class="form-control form-control-sm" id="user_name" name="user_name" placeholder="Login Username" value="">
						</div>
					</div>
					
                    <div class="form-group row">	
						<div class="col-lg-6 col-md-6">
							<label>Password <?=COMPULSORY;?></label>
							<input type="password" class="form-control form-control-sm" id="user_password" name="user_password" placeholder="Password" value="">
						</div>
						<div class="col-lg-6 col-md-6">
							<label>Confirm Password <?=COMPULSORY;?></label>
							<input type="password" class="form-control form-control-sm" id="user_password_confirmation" name="user_password_confirmation" placeholder="Confirm Password" value="">
						</div>
					</div>

                    <div class="form-group row">
						<div class="col-lg-6 col-md-6">
							<label>Full	 Name <?=COMPULSORY;?></label>
							<input type="text" class="form-control form-control-sm turn_uppercase" id="full_name" name="full_name" placeholder="Full Name" value="">
						</div>
						<div class="col-lg-6 col-md-6">
							<label>Email <?=COMPULSORY;?></label>
							<input type="text" class="form-control form-control-sm" id="email" name="email" placeholder="Email" value="">
						</div>
					</div>

					<div class="form-group row">
						<div class="col-lg-6 col-md-6">
							<label>Mobile No.</label>
							<input type="text" class="form-control form-control-sm" id="mobile_no" name="mobile_no" placeholder="Mobile No." value="">
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
                url: "<?php echo site_url("user/delete");?>",
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
		$('#user_type_id').val('').trigger('change');
		$('#user_name').val('');
		$('#user_password').val('');
		$('#user_password_confirmation').val('');
		$('#full_name').val('');
		$('#email').val('');
		$('#mobile_no').val('');

		$('#user_type_id').prop('disabled', false);
		$('#user_name').prop('disabled', false);

		$('#ids').val('');

		$('#modal_title').text('Setting User');
    });

    var data_table_server = $('.data_table_server').DataTable({ 

		"scrollY": false,
		"scrollX": true,
		"scrollCollapse": true,
	    "processing": true, 
	    "serverSide": true, 
	     
	    "ajax": {
	        "url": "<?=site_url('user/list')?>",
	        "type": "POST",
	        data: function (d) {
                d.filter_name = $('#filter_name').val();
                d.filter_user_type = $('#filter_user_type').val();
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
	    	$( row ).find('td:eq(0)').addClass('text-center');
	    },
	    order: [[ 0, "ASC" ]],
	    // "columnDefs": [
	    // { 
	    //     "targets": [ 0 ], 
	    //     "orderable": false, 
	    // },
	    //],

	});

	var arr_cb_val = [];
    // when click cb_single
	$('.data_table_server').on('change','.cb_single',function(){
		
		// one of the cb_single is checked, then uncheck cb_all
        if (!$(this).prop("checked"))
        {
            $("#cb_all").prop("checked",false);
        }         

        // when total checked cb_single equal to total checkbox, then check cb_all
        var cb_total = $('.cb_single').length;
        var cb_checked = $('.cb_single:checked').length;

		if ( cb_checked == cb_total )
		{
			$("#cb_all").prop("checked", true);
		}

		// clear cb_val array
        arr_cb_val = [];

        $.each($(".cb_single:checked"), function(){            
            arr_cb_val.push($(this).val());
        });

        $("#selected_id").val( arr_cb_val.join(", ") );
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
        $('#filter_user_type').val('').trigger('change');
        $('#selected_id').val('');

        e.preventDefault();
        data_table_server.draw();   
    });

	// when click button new
	$('#btn_add').on('click',function(){

		$('#modal_title').text('Create User');
		$('#modal_form').modal('show');
	});

	// when click button view
	// $('.data_table_server').on('click','.btn_view',function(){
		
	// 	loading_on();

	// 	var ids = $(this).attr('ids');

	// 	var dataString = "ids="+ids;
 //        // console.log(dataString);
	//     $.ajax({
	//         type    : "POST",
	//         url     : "<?=site_url('user/details')?>",
	//         data    : dataString,
	//         dataType: 'json',
	//         cache   : false,
	//         success : function(data)
	//         {
	//         	// console.log("data",data);

	//         	if ( data.length != '0' )
	//         	{
	//         		$('#user_type_id').val(data.user_type_id).trigger('change');
	// 				$('#user_name').val(data.user_name);
	// 				$('#user_password').val('');
	// 				$('#user_password_confirmation').val('');
	// 				$('#full_name').val(data.full_name);
	// 				$('#email').val(data.email);
	// 				$('#mobile_no').val(data.mobile_no);

	// 				$('#user_type_id').prop('disabled', true);
	// 				$('#user_name').prop('disabled', true);

	// 				$('#ids').val(ids);

	// 	        	loading_off();

	// 				$('#modal_title').text('Edit User');
	// 	        	$('#modal_form').modal('show');
	// 	        }
	// 	        else
	// 	        {
	//                 loading_off();

	//                 swal.fire({
 //                        title: 'Selected data not found',
 //                        text: '',
 //                        type: 'error',
 //                        allowOutsideClick: false
 //                    }).then(function () {
 //                    });
	// 	        }
	//         }
	//     });

	// });

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

});

</script>