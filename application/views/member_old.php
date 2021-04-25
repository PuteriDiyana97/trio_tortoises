<div class="kt-subheader-search">
	<div class="kt-container  kt-container--fluid">
		<h3 class="kt-subheader-search__title">
			Member
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
						Member List
					</h3>
				</div>
				<div class="kt-portlet__head-toolbar">
					<div class="kt-portlet__head-wrapper">
						<div class="kt-portlet__head-actions">
							<a href="<?=site_url('member/create')?>" class="btn btn-brand btn-bold btn-font-sm btn-sm" id="btn_add" name="btn_add">
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
										<div class="col-md-3">
											<label>Name</label>
											<input type="text" class="form-control form-control-sm turn_uppercase" id="filter_name" name="filter_name" placeholder="Name" value="">
										</div>
										<div class="col-md-2">
											<label>Phone Number</label>
											<input type="text" class="form-control form-control-sm" id="filter_contact" name="filter_contact" placeholder="Phone Number" value="">
										</div>
										<div class="col-md-2">
											<label>Membership Type</label>
											<select class="form-control kt-selectpicker" id="filter_member_status" name="filter_member_status" data-size="3" data-live-search="true" required="">
												<option data-content="" value="">Membership Type</option>
												<option data-content="Active" value="1">Active</option>
												<option data-content="Inactive" value="0">Inactive</option>	
											</select>
										</div>
										<div class="col-md-2">
											<label>Country</label>
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
		        <!--end: Filter -->
				<!--begin: Datatable -->
				<table class="table table-striped- table-bordered table-hover table-checkable data_table_server" id="data_table_server">

				<!-- <div id="example_filter" class="dataTables_filter"><label>Search:<input type="search" class="" placeholder="" aria-controls="example"></label></div> -->
					<thead><br>
						<tr>
							<th class="text-center no-sort">No</th>
							<th class="text-center">Name</th>
							<th class="text-center">Email</th>
							<th class="text-center">Mobile Number</th>
							<th class="text-center">State</th>
							<th class="text-center">Country</th>
							<th class="text-center">Current Point</th> <!-- join table -->
							<th class="text-center">Total Earn</th>
							<th class="text-center">Membership Type</th>
							<th class="text-center">Action</th>
						</tr>
					</thead>
					<!-- <tbody>
						<?php 
						$total=0;
						foreach ($member_data as $md) {
						$no ='#';
						?>
						<tr>
							<td><?= $no ?></td>
							<td><?= $md->name ?></td>
							<td><?= $md->email ?></td> 
							<td><?= $md->contact_no ?></td>
							<td><?= $md->state ?></td>
							<td><?= $md->country ?></td> 
							<td></td>
							<td></td>
							<td><?= $md->active ?></td> 
							<td></td>
						</tr>
					<?php } ?>
					</tbody> -->
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
	                <h5 class="modal-title" id="modal_title">Member</h5>
	                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	                </button>
	            </div>
	            <div class="modal-body">
                    <div class="form-group row">
						<div class="col-md-4">
							<strong>Full Name <?=COMPULSORY;?></strong>
							<input type="text" class="form-control form-control-sm turn_uppercase" id="full_name" name="full_name" placeholder="Full Name" required>
						</div>
						<div class="col-md-4">
							<strong>Mobile No.<?=COMPULSORY;?></strong>
							<input type="text" class="form-control form-control-sm" id="mobile_no" name="mobile_no" placeholder="Mobile No." value="" required="">
						</div>
						<div class="col-md-4">
							<strong>IC No. <?=COMPULSORY;?></strong>
							<input type="text" class="form-control form-control-sm" id="ic_no" name="ic_no" placeholder="IC No." value="" required="">
						</div>
					</div>

					<div class="form-group row">
						<div class="col-md-4">
							<strong>Email <?=COMPULSORY;?></strong>
							<input type="email" class="form-control form-control-sm" id="email" name="email" placeholder="Email" required>
						</div>
						<div class="col-md-4">
							<strong>Gender <?=COMPULSORY;?></strong>
							  <select class="form-control kt-selectpicker" id="gender" name="gender" data-size="7" data-live-search="true" required="">
								  <option data-content="" value="">Select Gender</option>
								  <option data-content="Female" value="Female">Female</option>
								  <option data-content="Male" value="Male">Male</option>	
							  </select>
						</div>

						<div class="col-md-4">
							<strong>Date of Birth <?=COMPULSORY;?></strong>
							    <div class="input-group date">
							         <input type="text" class="form-control kt_datepicker_4_3" placeholder="Date of Birth" id="kt_datepicker_4_3" name="dob"/>
										<div class="input-group-append">
											<span class="input-group-text">
												<i class="la la-check"></i>
											</span>
										</div>
								</div>		
						</div>
					</div>

					<div class="form-group row">
						<div class="col-md-4">
							<label>Address</label>
							<textarea type="text" class="form-control form-control-sm" id="address" name="address" placeholder="Address" value=""></textarea>
						</div>
						<div class="col-md-4">
							<label>City</label>
							<input type="text" class="form-control form-control-sm" id="city" name="city" placeholder="City" value="">
						</div>
						<div class="col-md-4">
							<label>State</label>
							<input type="text" class="form-control form-control-sm" id="state" name="state" placeholder="State" value="">
						</div>
						
					
					</div>
					<div class="form-group row">
						<div class="col-md-4">
							<label>Postcode</label>
							<input type="text" class="form-control form-control-sm" id="zipcode" name="zipcode" placeholder="Zipcode" value="">
						</div>
						<div class="col-md-4">
							<label>Country</label>
							<input type="text" class="form-control form-control-sm" id="country" name="country" placeholder="Country" value="">
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

                    var msg_title = 'Success!';
                    var msg_content = 'Selected record(s) deleted';
                    var msg_status = 'success';
                    
                    //successfully delete
                    if ( data.rst > 0 )
                    {
                        msg_title = 'Fail!';
                        msg_content = 'Selected record(s) not deleted';
                        msg_status = 'error';
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

		// "scrollY": '50vh',
		// "scrollX": true,
		// "scrollCollapse": true,
	    "processing": true, 
	    "serverSide": true, 
	     
	    "ajax": {
	        "url": "<?=site_url('member/list')?>",
	        "type": "POST",
	        data: function (d) {
                d.filter_name = $('#filter_name').val();
                d.filter_contact = $('#filter_contact').val();
                d.filter_member_status = $('#filter_member_status').val();
                console.log(d.filter_member_status);
                d.filter_country = $('#filter_country').val();
	        },
	    },
	    //list before next page
	    "pageLength": 30,
	    "language": {
	        "emptyTable": "No data available in the table"
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
	    order: [[ 1, "ASC" ]],
	    // "columnDefs": [
	    // { 
	    //     "targets": [ 0 ], 
	    //     "orderable": false, 
	    // },
	    //],

	});

	var arr_cb_val = [];
	
	// when click cb_all
    $("#cb_all").change(function(){
    	$(".cb_single").prop('checked', $(this).prop('checked'));

    	// clear selected_id array
    	arr_cb_val = [];

        $.each($(".cb_single:checked"), function(){            
            arr_cb_val.push($(this).val());
        });

        $("#selected_id").val( arr_cb_val.join(", ") );
	});

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
        $('#filter_contact').val('');
        $('#filter_member_status').val('');
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
	        url     : "<?=site_url('member/details')?>",
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
	            url: "<?=site_url('member/update')?>",
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
	                        location.href = "<?=site_url('member')?>";
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
	                        location.href = "<?=site_url('member')?>";
	                         loading_off();
	                    });

	                }
	            }
	        });
	        // console.log(dataString);
	        // $('#promo_setting').modal('hide');
	        // loading_off();
	    }
	});


});

</script>