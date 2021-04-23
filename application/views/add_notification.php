<style>
	.capitalize {
  text-transform: capitalize;
}
</style>

<div class="kt-subheader-search">
	<div class="kt-container  kt-container--fluid">
		<h3 class="kt-subheader-search__title">
			Notification
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
						Add New Notification
					</h3>
				</div>
			</div>
			<div class="kt-portlet__body">

				<div class="kt-grid">
            		<div class="kt-grid__item kt-grid__item--middle">
	                    <div class="row">
			            		<div class="col-md-3">
									<strong>Notification Title <?=COMPULSORY;?></strong>
									<input type="text" class="form-control capitalize" id="notification_title" name="notification_title" placeholder="Notification Title" required="">
								</div>
								<div class="col-md-3">
									<strong>Banner</strong>
									<input type="file" class="form-control" id="banner" name="banner">
									<div>
                                        <span>Allowed type: png | jpg | jpeg</span>
                                        <span style="float: left;">(Max: 13MB, Height:700px Width:400px)</span>
                                    </div>
								</div>
								<div class="col-md-3">
		                        <div class="form-group">
		                            <strong>Date <?=COMPULSORY;?></strong>
				                        <div class="input-daterange input-group" id="kt_datepicker_5">
											<input type="text" class="form-control" id="start_date" name="start_date" required="">
											<div class="input-group-append">
												<span class="input-group-text"><i class="la la-ellipsis-h"></i></span>
											</div>
											<input type="text" class="form-control" id="end_date" name="end_date">
										</div>
		                        </div>
		                    </div>
			            	<div class="col-md-3">
	                                <strong>Send To <?=COMPULSORY;?></strong><br>
	                                <select class="form-control kt-selectpicker assign_member" name="member[]" multiple="multiple" data-size="5" data-live-search="true" required="">
											<option value="All">All</option>
									<?php foreach($member_list as $data){ ?>
                      						<option value="<?php echo $data->contact_no ?>"><?php echo $data->name ?> (<?php echo $data->contact_no ?>)</option>
                        			<?php } ?> 
									</select>
	                        </div>
						</div><br>
						<div class="row">
								<div class="col-md-9">
									<strong>Short Description <?=COMPULSORY;?></strong>
									<input type="text" class="form-control" id="short_description" name="short_description" placeholder="Short Description" required="">
								</div>
						</div><br>
						<div class="row">
								<div class="col-md-9">
									<strong>Long Description <?=COMPULSORY;?></strong>
									<textarea class="form-control" id="long_description" name="long_description" placeholder="Long Description"></textarea>
								</div>
						</div>
		        </div>
			</div>
		</div>
		<div class="kt-portlet__foot text-right">
					<input type="hidden" id="ids" name="ids" value="" />
	                <a href="<?=site_url('notification')?>" class="btn btn-brand btn-bold btn-font-sm btn-sm" id="btn_cancel" name="btn_cancel">Cancel
					</a>
	                <button type="submit" class="btn btn-success btn-bold btn-font-sm btn-sm btn-sm" id="btn_save" name="btn_save"><i class="fa fa-save"></i>Save</button>
		</div>
	</div>
	</form>
</div>
<!-- end:: Content -->

<!--begin::Page Scripts(used by this page) -->

<link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.11/summernote-lite.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.11/summernote-lite.js"></script>
<script type="text/javascript">
$("#long_description").summernote({
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
        url: '<?php echo site_url('Notification_Controller/summernote_sync_image')?>',
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
    var next_month = new Date();
    next_month.setDate(next_month.getDate() + 30);
    // set default today date
    $("#start_date").datepicker().datepicker("setDate", new Date());
    $("#end_date").datepicker().datepicker("setDate", next_month);
}

$(function() {
	$('.assign_member').select2();
	$('.kt-selectpicker').selectpicker();
    $('#kt_datepicker_5').datepicker({
    	 rtl: KTUtil.isRTL(),
        format: "dd-M-yyyy",
        startDate: new Date(),
        toggleActive: true,
        orientation: "bottom left"

    }).on('keydown', function(e) {
        e.preventDefault();
    });

    load_datepicker();

});

$(function(){

	$('.select2_field').select2();

	  $('.date_picker').datepicker({
        todayHighlight: true,
        autoclose: true,
        format: "dd/mm/yyyy",
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

    $('#form').on('submit', function(e) {
	    e.preventDefault();
	    $('.div_error_msg').removeClass('alert alert-danger').html('');
	     var error_no = 0,
	        error_msg = [];

	    var long_desc = $('#long_description').val().trim();
	    if(long_desc == '')
			{
				error_no = error_no+1;
				error_msg.push("Long Description is required.");
			}
		console.log(error_no);
	   

	    if (error_no > 0) {
	        Swal.fire({
	            title: "Warning!",
	            text: "Long Description is required.",
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
	            url: "<?=site_url('notification/insert')?>",
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
	                        $('#form').modal('hide');
	                        location.href = "<?=site_url('notification')?>";
	                         loading_off();
	                    });

	                }
	                else
	                {
	                     Swal.fire({
	                        title: data.status_message,
	                        text: "",
	                        type: "error"
	                    }).then(function() {
	                        $('#form').modal('hide');
	                        location.href = "<?=site_url('notification')?>";
	                         loading_off();
	                    });
	                }
	            }
	        });
	    }
	});
});

</script>