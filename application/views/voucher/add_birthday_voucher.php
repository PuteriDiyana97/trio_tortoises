<style type="text/css">
	.capitalize {
  	text-transform: capitalize;
	}
</style>
<div class="kt-subheader-search">
	<div class="kt-container  kt-container--fluid">
		<h3 class="kt-subheader-search__title">
			Voucher
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
						Add Birthday Voucher
					</h3>
				</div>
			</div>
			<div class="kt-portlet__body">

				<div class="kt-grid">
            		<div class="kt-grid__item kt-grid__item--middle">
	                    <div class="row">
			            		<div class="col-md-3">
									<strong>Voucher Name <?=COMPULSORY;?></strong>
									<input type="text" class="form-control capitalize" id="voucher_name" name="voucher_name" placeholder="Voucher Name" required="">
								</div>
								<div class="col-md-3">
									<strong>Voucher Value (RM)<?=COMPULSORY;?></strong>
									<input type="number" min="1" class="form-control" id="voucher_value" name="voucher_value" placeholder="Voucher Value" required="">
								</div>
								<div class="col-md-3">
			                        <div class="form-group">
			                        <strong>Month <?=COMPULSORY;?></strong>
					                <select class="form-control kt-selectpicker" id="month" name="month" data-size="4" data-live-search="true" required="">
										<option value="">Select Month</option>
										<option data-content="January" value="1">January</option>
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
								
								
								<!-- <div class="col-md-2">
									<strong>Voucher Code <?=COMPULSORY;?></strong>
									<input type="text" class="form-control" id="voucher_code" name="voucher_code" placeholder="Voucher Code" required="">
								</div> -->
						</div>
						<div class="row">
							<div class="col-md-9">
									<strong>Description <?=COMPULSORY;?></strong>
									<textarea type="text" class="form-control " id="description" name="description" placeholder="Description" required=""></textarea>
							</div>
						</div><br>
			            <div class="row">
			            	
							<div class="col-md-3">
								<strong>Voucher Visual(Before Used) <?=COMPULSORY;?></strong>
								<input type="file" class="form-control form-control-sm" id="voucher_img_before" name="voucher_img_before" accept=".png, .jpg, .jpeg, .gif" required="">
								<div>
                                    <span>Allowed type: png | jpg | jpeg</span>
                                    <span style="float: left;">(Max: 13MB, Height:600px Width:300px)</span>
                                </div>
							</div>
							<div class="col-md-3">
								<strong>Voucher Visual(After Used) <?=COMPULSORY;?></strong>
								<input type="file" class="form-control form-control-sm" id="voucher_img_after" name="voucher_img_after" placeholder="Voucher Visual(After Used)" accept=".png, .jpg, .jpeg, .gif" required="">
								<div>
                                    <span>Allowed type: png | jpg | jpeg</span>
                                    <span style="float: left;">(Max: 13MB, Height:600px Width:300px)</span>
                                </div>
							</div> 
			            </div>
			            <input type="hidden" id="voucher_type" name="voucher_type" value="1" />
		        </div>
			</div>
		</div>
		<div class="kt-portlet__foot text-right">
					<input type="hidden" id="ids" name="ids" value="" />
	                <a href="<?=site_url('birthday_voucher/birthday')?>" class="btn btn-brand btn-bold btn-font-sm btn-sm" id="btn_cancel" name="btn_cancel">Cancel
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
    $("#start_date").datepicker().datepicker("setDate", last_month);
    $("#end_date").datepicker().datepicker("setDate", new Date());
}
$('.kt-selectpicker').selectpicker();
$(function() {

    $('#kt_datepicker_5').datepicker({
    	 rtl: KTUtil.isRTL(),
        format: "dd-M-yyyy",
        toggleActive: true,
        orientation: "bottom left"

    }).on('keydown', function(e) {
        e.preventDefault();
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
	            url: "<?=site_url('birthday_voucher/insert')?>",
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
	                        location.href = "<?=site_url('birthday_voucher/birthday')?>";
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
	                        location.href = "<?=site_url('birthday_voucher/create')?>";
	                         loading_off();
	                    });
	                }
	            }
	        });
	    }
	});
});

</script>