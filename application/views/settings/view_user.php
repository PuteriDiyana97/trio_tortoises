
<style type="text/css">
  .disable{
        pointer-events: none !important;
        opacity: 0.5;
}
</style>

<div class="kt-subheader-search">
	<div class="kt-container  kt-container--fluid">
		<h3 class="kt-subheader-search__title">
			User
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
						View User
					</h3>
				</div>
			</div>
			<div class="kt-portlet__body">
					<div class="form-group row">
	            		<div class="col-md-3">
							<strong>Login Username</strong>
							<input type="text" class="form-control form-control-sm" id="user_name" name="user_name" placeholder="Login Username" disabled="" value="<?= $user_info->user_name ?>">
						</div>	
						<div class="col-md-3">
							<strong>Password</strong>
							<input type="password" class="form-control form-control-sm" id="user_password" name="user_password" placeholder="Password" >
						</div>
					</div>

                    <div class="form-group row">
						<div class="col-md-3">
							<strong>Full Name</strong>
							<input type="text" class="form-control form-control-sm turn_uppercase" id="full_name" name="full_name" placeholder="Full Name" value="<?= $user_info->full_name ?>">
						</div>
						<div class="col-md-3">
							<strong>Email</strong>
							<input type="text" class="form-control form-control-sm" id="email" name="email" placeholder="Email" value="<?= $user_info->email ?>">
						</div>
						<div class="col-md-3">
							<strong>Mobile No.</strong>
							<input type="text" class="form-control form-control-sm" id="mobile_no" name="mobile_no" placeholder="Mobile No." value="<?= $user_info->mobile_no ?>" disabled="">
						</div>
					</div>
					<?php if ($this->session->user_type == 1){ ?>
					<div class="form-group row">
							<div class="col-md-6">
		                        <strong>User Types</strong>
		                        <div class="radio-list">
		                            <label class="radio">
		                                <input type="radio" name="type" value="2" <?= $user_info->user_type == 2 ? 'checked' : '' ?>>
		                                <span></span>
		                                Administrator
		                            </label><br>

		                            <label class="radio">
		                                <input type="radio" name="type" value="3" <?= $user_info->user_type == 3 ? 'checked' : '' ?>>
		                                <span></span>
		                                Operator
		                            </label>
		                        	
		                        </div>
		                    </div>
					</div>
					<div class="row">
							<div class="col-md-6">
		                        <strong>Roles</strong>
		                        <?php $user_role = $this->Users->read_data_role($user_info->id); 
		                        //pre($user_role); die();
		                        $user_data = array();
		                        foreach ($user_role as $ur) {
		                        	$user_data[] = $ur->role_id;
		                        }
		                        ?>
		                        <div class="checkbox">
		                                <input type="checkbox" name="role[]" value="4" <?= (in_array('4', $user_data)) ? 'checked' : '' ?>>
		                                <span></span>
		                                Member
		                           <br>
		                                <input type="checkbox" name="role[]" value="5" <?= (in_array('5', $user_data)) ? 'checked' : '' ?>>
		                                <span></span>
		                                Voucher | Notification | Store Locator<br>
		                                <input type="checkbox" name="role[]" value="6" <?= (in_array('6', $user_data)) ? 'checked' : '' ?>>
		                                <span></span>
		                                CMS<br>
		                                <input type="checkbox" name="role[]" value="7" <?= (in_array('7', $user_data)) ? 'checked' : '' ?>>
		                                <span></span>
		                                Report
		                        </div>
		                        
		                    </div>
					</div>
				<?php }else if ($this->session->user_type == 2) {?>
		                        
					<!-- duplicate -->
					<div class="form-group row">
							<div class="col-md-6">
		                        <strong>User Types</strong>
		                        <div class="radio-list">
		                            <label class="radio">
		                                <input type="radio" name="type" value="3" <?= $user_info->user_type == 3 ? 'checked' : '' ?>>
		                                <span></span>
		                                Operator
		                            </label>
		                        	
		                        </div>
		                    </div>
					</div>
					<div class="row">
							<div class="col-md-6">
		                        <strong>Roles</strong>
		                        <?php $user_role = $this->Users->read_data_role($user_info->id); 
		                        $user_data = array();
		                        // pre($user_role); die();
		                        foreach ($user_role as $ur) {
		                        	$user_data[] = $ur->role_id;
		                        }
		                        ?>

		                        <div class="checkbox">
		                                <input type="checkbox" name="role[]" value="4" <?= (in_array('4', $user_data)) ? 'checked' : '' ?>>
		                                <span></span>
		                                Member
		                           <br>
		                                <input type="checkbox" name="role[]" value="5" <?= (in_array('5', $user_data)) ? 'checked' : '' ?>>
		                                <span></span>
		                                Voucher | Notification | Store Locator<br>
		                                <input type="checkbox" name="role[]" value="6" <?= (in_array('6', $user_data)) ?'checked' : '' ?>>
		                                <span></span>
		                                CMS<br>
		                                <input type="checkbox" name="role[]" value="7" <?= (in_array('7', $user_data)) ? 'checked' : '' ?>>
		                                <span></span>
		                                Report
		                        </div>
		                        
		                    </div>
					</div>
					<?php }else {?>
		            <?php }?>
					
	            </div>
	            <div class="kt-portlet__foot text-right">
					<input type="hidden" id="ids" name="ids" value="<?= $_GET['ids']?>" />
	                <a href="<?=site_url('user')?>" class="btn btn-brand btn-bold btn-font-sm btn-sm" id="btn_cancel" name="btn_cancel">Cancel
					</a>
	                <button type="submit" class="btn btn-success btn-bold btn-font-sm btn-sm btn-sm" id="btn_save" name="btn_save"><i class="fa fa-save"></i>Save</button>
		</div>
			</div>
		
	</form>
</div>
<!-- end:: Content -->

<!--begin::Page Scripts(used by this page) -->
<script type="text/javascript">
//1:superadmin 2:admin 3:operator 4:member 5:vns 6:cms 7:report
 $(document).ready(function() {

   $(':radio[value=2]').change(function(){
        $(':checkbox[value=4]').prop('checked',true).addClass("disable", true);
   		$(':checkbox[value=5]').prop('checked',true).addClass("disable", true);
   		$(':checkbox[value=6]').prop('checked',true).addClass("disable", true);
   		$(':checkbox[value=7]').prop('checked',true).addClass("disable", true);
   });
   $(':radio[value=3]').change(function(){
        $(':checkbox[value=4]').prop('checked',false).removeClass("disable", false);
   		$(':checkbox[value=5]').prop('checked',false).removeClass("disable", false);
   		$(':checkbox[value=6]').prop('checked',false).removeClass("disable", false);
   		$(':checkbox[value=7]').prop('checked',false).removeClass("disable", false);
   });

 });
 $('input[type=radio]').change(function(){
       $('input[type=checkbox]').prop("disabled", false);
    
   });
 $('input[type=checkbox]').prop("disable", true);
 $('#btn_save').click(function() {
      checked = $("input[type=checkbox]:checked").length;

      if(!checked) {
        swal.fire({
	                        title: 'You must check at least one checkbox',
	                        text: "",
	                        type: "error"
	                    })
        return false;
      }

    });

$(function(){

	$('.select2_field').select2();

    $('#form').on('submit', function(e) {
    	 loading_on();
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
	            url: "<?=site_url('user/save')?>",
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
	                        location.href = "<?=site_url('user')?>";
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
	                        location.href = "<?=site_url('user')?>";
	                         loading_off();
	                    });
	                }
	            }
	        });
	    }
	});
});

</script>