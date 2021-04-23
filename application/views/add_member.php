<style>
	.capitalize {
  text-transform: capitalize;
}
</style>

<div class="kt-subheader-search">
	<div class="kt-container  kt-container--fluid">
		<h3 class="kt-subheader-search__title">
			Member
		</h3>
	</div>
</div>

<!-- begin:: Content -->
<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
	<form class="kt-form" id="form" name="form" method="post" enctype="multipart/form-data">
		<div class="kt-portlet kt-portlet--mobile">
			<div class="kt-portlet__head">
				<div class="kt-portlet__head-label">
					<h3 class="kt-portlet__head-title">
						Add New Member
					</h3>
				</div>
			</div>
			<div class="kt-portlet__body">

				<div class="kt-grid">
            		<div class="kt-grid__item kt-grid__item--middle">
	                    <div class="row">
								<div class="col-md-3">
									<strong>Full Name <?=COMPULSORY;?></strong>
									<input type="text" class="form-control form-control-sm capitalize" id="full_name" name="full_name" placeholder="Full Name" required>
								</div>
								<div class="col-md-3">
									<strong>IC Number/ Passport <?=COMPULSORY;?></strong>
									<input type="text" class="form-control form-control-sm" id="ic_no" name="ic_no" placeholder="IC No." value="" required="">
								</div>
								<div class="col-md-3">
									<strong>Mobile No.<?=COMPULSORY;?></strong>
									<input type="text" class="form-control form-control-sm" id="mobile_no" name="mobile_no" placeholder="example: +6013456789" value="" required="">
								</div>
								
			            </div><br>
			            <div class="row">
			            		<div class="col-md-3">
									<strong>Email <?=COMPULSORY;?></strong>
									<input type="email" class="form-control form-control-sm" id="email" name="email" placeholder="Email" required>
								</div>
								<div class="col-md-3">
									<strong>Gender <?=COMPULSORY;?></strong>
									<select class="form-control kt-selectpicker" id="gender" name="gender" data-size="7" data-live-search="true" required="">
											<option data-content="" value="">Select Gender</option>
											<option data-content="Female" value="Female">Female</option>
											<option data-content="Male" value="Male">Male</option>
									</select>
								</div>
								<div class="col-md-3">
									<strong>Race <?=COMPULSORY;?></strong>
									<select class="form-control kt-selectpicker" id="race" name="race" data-size="7" data-live-search="true" required="">
											<option data-content="" value="">Select Race</option>
											<option data-content="Indian" value="Indian">Indian</option>
											<option data-content="Chinese" value="Chinese">Chinese</option>
											<option data-content="Malay" value="Malay">Malay</option>
											<option data-content="Others" value="Others">Others</option>
											
									</select>
								</div>
			            </div><br>
			            <div class="row">

			            	<div class="col-md-3">
									<strong>Address <?=COMPULSORY;?></strong>
									<textarea type="text" class="form-control form-control-sm capitalize" id="address" name="address" placeholder="(Street name)" value="" required=""></textarea>
								</div>
								
								<div class="col-md-3">
									<strong>City <?=COMPULSORY;?></strong>
									<input type="text" class="form-control form-control-sm capitalize" id="city" name="city" placeholder="City" value="" required="">
								</div>
								<div class="col-md-3">
									<strong>Country <?=COMPULSORY;?></strong>
									
									<select class="form-control kt-selectpicker" id="country" name="country" data-size="4" data-live-search="true">
											<option value="">Select Country</option>
											<?php foreach ($country_list as $cl) { ?>
											<option value="<?= $cl->country ?>"><?= $cl->country ?></option>
											<?php } ?>
									</select>									
								</div>
			            </div><br>

			            <div class="row">
			            		<div class="col-md-3">
									<strong>Zipcode <?=COMPULSORY;?></strong>
									<input type="text" class="form-control form-control-sm" id="zipcode" name="zipcode" placeholder="Zipcode" value="" required="">
								</div>

								
								<div class="col-md-3">
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
								<div class="Malaysia select_country col-md-3">
									<strong>State <?=COMPULSORY;?></strong>
									<input type="text" class="form-control form-control-sm capitalize" id="state" name="state" placeholder="State" value="" required="">
								</div>
			            </div>
			            <input type="hidden"  id="point" name="point" value="300">
			            <input type="hidden"  id="profile_pic" name="profile_pic" value="default-profile.png">
			            <input type="hidden"  id="description" name="description" value="Welcome Point">
			            <input type="hidden"  id="status" name="status" value="1">
		        </div>
			</div>
		</div>
		
		<div class="kt-portlet__foot text-right">
					<input type="hidden" id="ids" name="ids" value="" />
	                <a href="<?=site_url('member')?>" class="btn btn-brand btn-bold btn-font-sm btn-sm" id="btn_cancel" name="btn_cancel">Cancel
					</a>
	                <button type="submit" class="btn btn-success btn-bold btn-font-sm btn-sm btn-sm" id="btn_save" name="btn_save"><i class="fa fa-save"></i>Save</button>
		</div>
	</div>
	</form>
</div>
<!-- end:: Content -->

<!--begin::Page Scripts(used by this page) -->

<script src="<?=base_url()?>assets/js/scripts.bundle.js"></script>
<script src="<?=base_url()?>assets/js/pages/crud/forms/widgets/bootstrap-datepicker.js"></script>
<script type="text/javascript">
$(document).ready(function(){
    $("#country").change(function(){
        $(this).find("option:selected").each(function(){
            var optionValue = $(this).attr("value");
            if(optionValue){
                $(".select_country").not("." + optionValue).hide();
                $("." + optionValue).show();
            } else{
                $(".select_country").hide();
            }
        });
    }).change();

    $('#country').on('change',function(){
    	var selected_country = $(this).val();
    	console.log(selected_country);

    	if(selected_country == 'Malaysia' || selected_country == 'malaysia')
    	{
    		$('#state').prop('required',true);
    	}
    	else
    	{
    		$('#state').prop('required',false);
    	}
    });
});
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
		$('#city').val('');
		$('#address').val('');
		$('#postcode').val('');
		$('#state').val('');

		$('#ids').val('');

		$('#modal_title').text('Member');
    });

    var data_table_server = $('.data_table_server').DataTable({ 

		"scrollY": '50vh',
		"scrollX": true,
		"scrollCollapse": true,
	    "processing": true, 
	    "serverSide": true, 
	     
	    "ajax": {
	        "url": "<?=site_url('member/list')?>",
	        "type": "POST",
	        data: function (d) {
                d.filter_name = $('#filter_name').val();
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
        $('#selected_id').val('');

        e.preventDefault();
        data_table_server.draw();   
    });

	// when click button new
	$('#btn_add').on('click',function(){

		$('#modal_title').text('Create Member');
		$('#modal_form').modal('show');
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
	        	// console.log("data",data);

	        	if ( data.length != '0' )
	        	{
	        		$('#full_name').val(data.full_name);
					$('#point').val(data.point);
					$('#email').val(data.email);
					$('#mobile_no').val(data.mobile_no);
					$('#address').val(data.address);
					$('#postcode').val(data.postcode);
					$('#city').val(data.city);
					$('#state').val(data.state);

					$('#ids').val(ids);

		        	loading_off();

					$('#modal_title').text('Edit Member');
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

    $('#form').on('submit', function(e) {
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
	        var dataString = $('#form').serialize();
	        console.log(dataString);
	        $.ajax({
	            type: "POST",
	            url: "<?=site_url('member/insert')?>",
	            data: dataString,
	            dataType: 'json',
	            enctype: 'multipart/form-data',
	            processData: false,
	            contentType: false,
	            data: new FormData(this),
	            cache: false,
	            success: function(data) {
	              //  alert(data);
	                console.log("frm submit", data);

	                  if(data.status == 1)
	                {
	                    swal.fire({
	                        title: data.status_message,
	                        text: "",
	                        type: "success"
	                    }).then(function() {
	                        $('#form').modal('hide');
	                        location.href = "<?=site_url('member')?>";
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
	                        $('#form').modal('hide');
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