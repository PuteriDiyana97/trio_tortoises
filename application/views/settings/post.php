<div class="kt-subheader-search">
	<div class="kt-container  kt-container--fluid">
		<h3 class="kt-subheader-search__title">
			Abouts
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
						List of Abouts
					</h3>
				</div>
				<div class="kt-portlet__head-toolbar">
					<div class="kt-portlet__head-wrapper">
						<div class="kt-portlet__head-actions">
							<a href="javascript:void(0)" class="btn btn-brand btn-bold btn-font-sm btn-sm" id="btn_add" name="btn_add">
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
	                        <div class="col-lg-4 col-md-4">
								<label>Abouts</label>
								<input type="text" class="form-control form-control-sm" id="filter_post" name="filter_post" placeholder="Post" value="">
	                        </div>
	                    </div>
	                </div>
		        </div>
		        <!--end: Filter -->

				<!--begin: Datatable -->
				<table class="table table-striped- table-bordered table-hover table-checkable data_table_server" id="data_table_server">
					<thead>
						<tr>
							<th class="text-center no-sort">No</th>
							<th class="text-center">Title</th>
							<th class="text-center no-sort">Description</th>
							<th class="text-center no-sort">Banner</th>
							<th class="text-center">Last Updated date</th>
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
<form action="<?=site_url('post/save')?>" method="POST" id="form_modal" name="form_modal" enctype="multipart/form-data">
	<div class="modal fade" id="modal_form" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	    <div class="modal-dialog modal-lg" role="document">
	        <div class="modal-content">
	            <div class="modal-header">
	                <h5 class="modal-title" id="modal_title">Post</h5>
	                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	                </button>
	            </div>
	            <div class="modal-body">
	            	<div class="form-group row">\>
	            		<div class="col-md-3">
							<label>Title</label>
							<input type="text" class="form-control form-control-sm" id="title" name="title" placeholder="Title">
						</div>
						<div class="col-md-6">
							<label>Description</label>
							<textarea type="text" class="form-control form-control-sm" id="description" name="description" placeholder="Descriptions"></textarea>
						</div>
					</div>
					<div class="form-group row">	
						<div class="col-lg-6 col-md-6">
							<label>Banner</label>
							<input type="file" class="form-control form-control-sm" id="banner" name="banner" placeholder="Banner">
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
                url: "<?php echo site_url("post/delete");?>",
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
		$('#ids').val('');

		$('#modal_title').text('Post');
    });

    var data_table_server = $('.data_table_server').DataTable({ 

		"scrollY": '50vh',
		"scrollX": true,
		"scrollCollapse": true,
	    "processing": true, 
	    "serverSide": true, 
	     
	    "ajax": {
	        "url": "<?=site_url('post/list')?>",
	        "type": "POST",
	        data: function (d) {
                d.filter_post = $('#filter_post').val();
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

    // when click button search
    $('#btn_search').on('click',function(e){

        $('#selected_id').val('');

        e.preventDefault();
        data_table_server.draw();
    });

    // when click button reset
    $('#btn_reset').on('click',function(e){

        $('#filter_post').val('');
        $('#selected_id').val('');

        e.preventDefault();
        data_table_server.draw();   
    });

	// when click button new
	$('#btn_add').on('click',function(){

		$('#modal_title').text('Create Post');
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
	        url     : "<?=site_url('post/details')?>",
	        data    : dataString,
	        dataType: 'json',
	        cache   : false,
	        success : function(data)
	        {
	        	// console.log("data",data);

	        	if ( data.length != '0' )
	        	{
	        		$('#user_type_id').val(data.user_type_id).trigger('change');
					$('#post').val(data.post);

					$('#ids').val(ids);

		        	loading_off();

					$('#modal_title').text('Edit User');
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

</script>