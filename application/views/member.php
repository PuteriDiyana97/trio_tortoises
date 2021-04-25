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
										<div class="col-md-2">
											<label>Name</label>
											<input type="text" class="form-control form-control-sm turn_uppercase" id="filter_name" name="filter_name" placeholder="Name" value="">
										</div>
										<div class="col-md-2">
											<label>Phone Number</label>
											<input type="text" class="form-control form-control-sm" id="filter_contact" name="filter_contact" placeholder="Phone Number" value="">
										</div>
										<div class="col-md-2">
											<label>Membership Type</label>
											<select class="form-control form-control-sm kt-selectpicker" id="filter_membership_type" name="filter_membership_type" data-size="5" data-live-search="true" value="">
												<option data-content="" value="">Membership Type</option>
												<option data-content="Star Glory Lite(SGL)" value="1">Star Glory Lite(SGL)</option>
												<option data-content="Star Glory Silver(SGS)" value="2">Star Glory Silver(SGS)</option>	
												<option data-content="Star Glory Gold(SGG)" value="3">Star Glory Gold(SGG)</option>
												<option data-content="Star Glory VIP(SGV)" value="4">Star Glory VIP(SGV)</option>	
											</select>
										</div>
										<div class="col-md-2">
											<label>Country</label>
											<input type="text" class="form-control form-control-sm" id="filter_country" name="filter_country" placeholder="Country" value="">
										</div>
										<div class="col-md-4">
				                            <label>Date</label>
						                        <div class="input-daterange input-group" id="kt_datepicker_5">
													<input type="text" class="form-control form-control-sm" id="filter_date_start" name="filter_date_start">
													<div class="input-group-append">
														<span class="input-group-text"><i class="la la-ellipsis-h"></i></span>
													</div>
													<input type="text" class="form-control form-control-sm" id="filter_date_end" name="filter_date_end">
												</div>
				                    	</div>
				                    </div>
				                    <div class="row">
				                    	<div class="col-md-3" ><br>
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
							<th class="text-center">Registration Date</th>
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

<!--begin::Page Scripts(used by this page) -->

<script type="text/javascript">
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

		"scrollY": false,
		"scrollX": true,
		"scrollCollapse": true,
	    "processing": true, 
	    "serverSide": true, 
	     
	    "ajax": {
	        "url": "<?=site_url('member/list')?>",
	        "type": "POST",
	        data: function (d) {
                d.filter_name = $('#filter_name').val();
                d.filter_contact = $('#filter_contact').val();
                d.filter_membership_type = $('#filter_membership_type').val();
                d.filter_date_start = $('#filter_date_start').val();
                d.filter_date_end   = $('#filter_date_end').val();
               console.log(d.filter_date_start);
                d.filter_country = $('#filter_country').val();
	        },
	    },
	    //list before next page
	    "pageLength": 50,
	    "language": {
	        "emptyTable": "No data available in the table",
	        "processing": '<div class="alert alert-default" style="color:#ddad4b"><i class="fa fa-circle-o-notch fa-spin fa-1x fa-fw"></i><b>Processing...</b></div>'
	    },

		"searching": true, //disable searching
		"bLengthChange": true, //disable show entries
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
	    order: [[ 9, "DESC" ]],
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
        $('#filter_membership_type').val('');
        $('#filter_country').val('');
        $('#filter_date_start').val('');
        $('#filter_date_end').val('');

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

    
});

</script>