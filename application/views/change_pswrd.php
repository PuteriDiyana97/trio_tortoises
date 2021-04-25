<div class="kt-subheader-search">
  <div class="kt-container  kt-container--fluid">
    <h3 class="kt-subheader-search__title">
      Settings
    </h3>
  </div>
</div>

<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
			<!--begin::Form-->
			<form  method="POST" action="<?=site_url('profile/change-password')?>" >
				<div class="kt-portlet kt-portlet--mobile">
			      <div class="kt-portlet__head">
			        <div class="kt-portlet__head-label">
			          <h3 class="kt-portlet__head-title">
			            Settings
			          </h3>
			        </div>
			      </div>
				<!--begin::Body-->
				<div class="kt-portlet__body">
						<div class="kt-grid">
			                <div class="kt-grid__item kt-grid__item--middle">
			                        <div class="row">
			                            <div class="col-md-6">
			                                        <strong for="store_name">Current Password</strong>
			                                        <input type="text" class="form-control" name="current_pswrd" id="current_pswrd" placeholder="Password">
			                            </div>
			                        </div><br>
			                        <div class="row">
			                            <div class="col-md-6">
			                                        <strong for="contact_no">New Password</strong>
			                                        <input type="text" class="form-control" name="new_pswrd" id="new_pswrd" placeholder="New Password" value="">
			                            </div>
			                        </div><br>
			                        <div class="row">
			                                    <div class="col-md-6"> 
			                                            <strong for="open_hours">Confirm Password</strong>
			                                            <input type="text" class="form-control" name="confirm_pswrd" id="confirm_pswrd" placeholder="Confirm Password">
			                                    </div>
			                        </div><br>
			            </div>
			      	</div>
			      	
				</div>
				<div class="kt-portlet__foot text-right ">
		    		<input type="hidden" id="ids" name="ids" value="<?= $this->session->curr_user_id ?>" />
		            <a href="<?=site_url('profile')?>" class="btn btn-secondary" id="btn_cancel" name="btn_cancel">Cancel</a>
		    	    <button type="submit" class="btn btn-success mr-2" id="btn_save" name="btn_save"><i class="fa fa-save"></i>Save</button>
		    	</div>
				<!--end::Body-->
			</div>
			</form>
			<!--end::Form-->
</div>