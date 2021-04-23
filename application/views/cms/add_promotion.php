<style type="text/css">
	.capitalize {
  text-transform: capitalize;
}
</style>
<div class="kt-subheader-search">
	<div class="kt-container  kt-container--fluid">
		<h3 class="kt-subheader-search__title">
			Promotion
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
						Add New Promotion
					</h3>
				</div>
			</div>
			<div class="kt-portlet__body">

				<div class="kt-grid">
            		<div class="kt-grid__item kt-grid__item--middle">
	                    <div class="row">
			            		<div class="col-md-3">
									<strong>Promotion Title <?=COMPULSORY;?></strong>
									<input type="text" class="form-control capitalize" id="title" name="title" placeholder="Promotion Title" required="">
								</div>
								
								<div class="col-md-3">
									<strong>Banner <?=COMPULSORY;?></strong>
									<input type="file" class="form-control form-control-sm" id="banner" name="banner" placeholder="Banner" required="">
									<div>
                                        <span>Allowed type: png | jpg | jpeg</span><br>
                                    <span style="float: left;">(Max: 13MB, Height:700px Width:300px)</span>
                                    </div>
								</div>
								<div class="col-md-3">
		                        <div class="form-group">
		                            <strong>Date <?=COMPULSORY;?></strong>
				                        <div class="input-daterange input-group" id="kt_datepicker_5">
											<input type="text" class="form-control form-control-sm" id="start_date" name="start_date" required="">
											<div class="input-group-append">
												<span class="input-group-text"><i class="la la-ellipsis-h"></i></span>
											</div>
											<input type="text" class="form-control form-control-sm" id="expiry_date" name="expiry_date" required="">
										</div>
		                        </div>
		                    </div>
							<div class="col-md-3">
								<strong>Category <?=COMPULSORY;?></strong>
								<select class="form-control form-control-sm kt-selectpicker" id="category_set" name="category_set" data-size="7" data-live-search="true" required="">
								<option value="">Select Promotion Category</option>
								<?php foreach($category_list as $category){ ?>
								<option value="<?php echo $category->id ?>"><?php echo $category->category ?></option>
								<?php }?>
								</select>
							</div>
						</div><br>
			            <div class="row">
							<div class="col-md-12">
									<strong>Description <?=COMPULSORY;?></strong>
									<textarea class="form-control" id="description" name="description"></textarea>
								</div>
	                    </div><br>
		        </div>
			</div>
		</div>
		<div class="kt-portlet__foot text-right">
					<input type="hidden" id="ids" name="ids" value="" />
	                <a href="<?=site_url('promotion')?>" class="btn btn-brand btn-bold btn-font-sm btn-sm" id="btn_cancel" name="btn_cancel">Cancel
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
        url: '<?php echo site_url('cms/Promotion_Controller/summernote_sync_image')?>',
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
    $("#expiry_date").datepicker().datepicker("setDate", next_month);
}

$(function() {

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
	$('.kt-selectpicker').selectpicker();
	
	$(document).ready(function() {
    $('.select_category').select2();
  	});

    $('#form').on('submit', function(e) {
	    e.preventDefault();
	    $('.div_error_msg').removeClass('alert alert-danger').html('');
	   
	    var error_no = 0,
	        error_msg = [];

	    var desc = $('#description').val().trim();
	    if(desc == '')
			{
				error_no = error_no+1;
				error_msg.push("Please check your information.");
			}

	    if (error_no > 0) {
	        swal.fire({
	            title: "Warning!",
	            text: "Description is required.",
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
	            url: "<?=site_url('promotion/insert')?>",
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
	                        $('#form').modal('hide');
	                        location.href = "<?=site_url('promotion')?>";
	                         loading_off();
	                    });

	                }
	                else
	                {
	                     swal.fire({
	                        title: data.status_message,
	                        text: "",
	                        type: "error"
	                    }).then(function() {
	                        $('#form').modal('hide');
	                        location.href = "<?=site_url('promotion/create')?>";
	                         loading_off();
	                    });
	                }
	            }
	        });
	    }
	});
});

</script>