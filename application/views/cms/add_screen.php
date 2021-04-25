<style>
	.capitalize {
  text-transform: capitalize;
}
</style>

<div class="kt-subheader-search">
	<div class="kt-container  kt-container--fluid">
		<h3 class="kt-subheader-search__title">
			Home Screen
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
						Add New Details
					</h3>
				</div>
			</div>
			<div class="kt-portlet__body">

				<div class="kt-grid">
            		<div class="kt-grid__item kt-grid__item--middle">
	                    <div class="row">
			            	<div class="col-md-9">
								<strong>Title <?=COMPULSORY;?></strong>
								<input type="text" class="form-control capitalize" id="title" name="title" placeholder="Title" required="">
							</div>
						</div><br>
						<!-- <div class="row">
							<div class="col-md-9">
								<strong>Description <?=COMPULSORY;?></strong>
								<textarea type="text" class="form-control" id="description" name="description" placeholder="Description" required=""></textarea>
							</div>
						</div><br> -->
						<div class="row">
							<div class="col-md-4">
								<strong>Banner <?=COMPULSORY;?></strong>
								<input type="file" class="form-control form-control-sm" id="banner" name="banner" placeholder="Banner" required="">
								<div>
                                     <span>Allowed type: jpg, png, jpeg</span><br>
                                     <span style="float: left;">(Max: 13MB, Height:700px Width:400px)</span>
                            	</div>
							</div>
						</div>
		        </div>
			</div>
		</div>
		<div class="kt-portlet__foot text-right">
					<input type="hidden" id="ids" name="ids" value="" />
	                <a href="<?=site_url('home-screen')?>" class="btn btn-brand btn-bold btn-font-sm btn-sm" id="btn_cancel" name="btn_cancel">Cancel
					</a>
	                <button type="submit" class="btn btn-success btn-bold btn-font-sm btn-sm btn-sm" id="btn_save" name="btn_save"><i class="fa fa-save"></i>Save</button>
		</div>
	</form>
</div>
<!-- end:: Content -->

<!--begin::Page Scripts(used by this page) -->

<script type="text/javascript">


$(function(){

	$('.select2_field').select2();


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
	            url: "<?=site_url('home-screen/insert')?>",
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
	                        location.href = "<?=site_url('home-screen')?>";
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
	                        location.href = "<?=site_url('home-screen/create')?>";
	                         loading_off();
	                    });
	                }
	            }
	        });
	    }
	});
});

</script>