<style type="text/css">
	.capitalize {
  	text-transform: capitalize;
	}
</style>

<div class="kt-subheader-search">
	<div class="kt-container  kt-container--fluid">
		<h3 class="kt-subheader-search__title">
			Add Regular Voucher
			<span class="kt-subheader-search__desc"></span>
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
						Add New Regular Voucher
					</h3>
				</div>
			</div>
			<div class="kt-portlet__body">
					<div class="kt-grid">
	            		<div class="kt-grid__item kt-grid__item--middle">
		                    <div class="row">
				            		<div class="col-md-2">
										<strong>Voucher Name <?=COMPULSORY;?></strong>
										<input type="text" class="form-control capitalize" id="voucher_name" name="voucher_name" placeholder="Voucher Name" required="">
									</div>
									
									<div class="col-md-4">
			                        <div class="form-group">
			                            <strong>Date <?=COMPULSORY;?></strong>
					                        <div class="input-daterange input-group" id="kt_datepicker_5">
												<input type="text" class="form-control" id="start_date" name="start_date" required="">
												<div class="input-group-append">
													<span class="input-group-text"><i class="la la-ellipsis-h"></i></span>
												</div>
												<input type="text" class="form-control" id="end_date" name="end_date" required="">
											</div>
			                        </div>
			                    </div>
									<!-- <div class="col-md-2">
										<strong>Voucher Code <?=COMPULSORY;?></strong>
										<input type="text" class="form-control" id="voucher_code" name="voucher_code" placeholder="Voucher Code" required="">
									</div> -->
									
									<!-- <div class="col-md-2">
										<strong>Quantity <?=COMPULSORY;?></strong>
										<input type="number" class="form-control" id="quantity" name="quantity" placeholder="Quantity" required="">
									</div> -->
							</div>
							<div class="form-group row">
								<div class="col-md-10">
										<strong>Description <?=COMPULSORY;?></strong>
										<textarea type="text" class="form-control" id="description" name="description" placeholder="Description" required=""></textarea>
									</div>
							</div>
							<div class="row">
								
				            	<div class="0 select_voucher_type col-md-2">
										<strong>Voucher Value</strong>
										<input type="number" min="1" class="form-control" id="voucher_value" name="voucher_value" placeholder="Voucher Value">
									</div>
									<div class="0 select_voucher_type col-md-2">
										<strong>Point Redemption</strong>
										<input type="number" min="1" class="form-control" id="exchange_point" name="exchange_point" placeholder="Point Redemption">
									</div>
									<div class="0 select_voucher_type col-md-3">
									<strong>Voucher Visual(Before Used) <?=COMPULSORY;?></strong>
									
									<input type="file" class="form-control form-control-sm" id="voucher_img_before" name="voucher_img_before" accept=".png, .jpg, .jpeg">
									<div>
	                                    <span>Allowed type: png | jpg | jpeg</span><br>
	                                    <span style="float: left;">(Max: 13MB, Height:600px Width:300px)</span>
	                                </div>
								</div>
								<div class="0 select_voucher_type col-md-3">
									<strong>Voucher Visual(After Used) <?=COMPULSORY;?></strong>
									<input type="file" class="form-control form-control-sm" id="voucher_img_after" name="voucher_img_after" placeholder="Voucher Visual(After Used)" accept=".png, .jpg, .jpeg">
									<div>
	                                   <span>Allowed type: png | jpg | jpeg</span><br>
	                                   <span style="float: left;">(Max: 13MB, Height:600px Width:300px)</span>
	                                </div>
								</div> 
			                </div><br>
			        </div>
				</div>
			</div>
			<div class="kt-portlet__foot text-right">
						<input type="hidden" id="ids" name="ids" value="" />
		                <a href="<?=site_url('voucher')?>" class="btn btn-brand btn-bold btn-font-sm btn-sm" id="btn_cancel" name="btn_cancel">Cancel
						</a>
		                <button type="submit" class="btn btn-success btn-bold btn-font-sm btn-sm btn-sm" id="btn_save" name="btn_save"><i class="fa fa-save"></i>Save</button>
			</div>
		</div>

		<input type="hidden" id="voucher_type" name="voucher_type" value="0" />

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
        url: '<?php echo site_url('voucher/Voucher_Controller/summernote_sync_image')?>',
        cache: false,
        contentType: false,
        processData: false,
        success: function(url) {
            console.log('url', url);
            $(el).summernote('editor.insertImage', url);
        }
    });
}
$('.kt-selectpicker').selectpicker();
function load_datepicker()
{
    var next_month = new Date();
    next_month.setDate(next_month.getDate() + 30);
    // set default today date
    $("#start_date").datepicker().datepicker("setDate", new Date());
    $("#end_date").datepicker().datepicker("setDate", next_month);
}

$(function() {

    $('#kt_datepicker_5').datepicker({
       format: "dd-M-yyyy",
        toggleActive: true,
        startDate: new Date(),
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

$(function(){

	$('.select2_field').select2();

    $('#form').on('submit', function(e) {
	    e.preventDefault();
	    $('.div_error_msg').removeClass('alert alert-danger').html('');
	   
	    var error_no = 0,
	        error_msg = [];
	        
	    var desc = $('#description').val().trim();
	    if(desc == '')
			{
				error_no = error_no+1;
				error_msg.push("Description is required.");
			}

	    if (error_no > 0) {
	        Swal.fire({
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
	            url: "<?=site_url('voucher/insert')?>",
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
	                        location.href = "<?=site_url('voucher')?>";
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
	                        location.href = "<?=site_url('voucher/create')?>";
	                         loading_off();
	                    });
	                }
	            }
	        });
	    }
	});
});

</script>