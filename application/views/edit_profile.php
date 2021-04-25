<div class="kt-subheader-search">
  <div class="kt-container  kt-container--fluid">
    <h3 class="kt-subheader-search__title">
      Profile
    </h3>
  </div>
</div>

<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
			<!--begin::Form-->
			<form class="form" action="<?=site_url('profile/save')?>" method="post" enctype="multipart/form-data">
				<div class="kt-portlet kt-portlet--mobile">
			      <div class="kt-portlet__head">
			        <div class="kt-portlet__head-label">
			          <h3 class="kt-portlet__head-title">
			            Edit Profile
			          </h3>
			        </div>
			      </div>
				<!--begin::Body-->
				<div class="kt-portlet__body">
						<div class="kt-grid">
			                <div class="kt-grid__item kt-grid__item--middle">
			                        <div class="row">
			                            <div class="col-md-4">
			                                        <strong for="store_name">Name</strong>
			                                        <input type="text" class="form-control" name="full_name" id="full_name" placeholder="Name" value="<?= $data->full_name ?>">
			                            </div>
			                                    <div class="col-md-4"> 
			                                            <strong for="open_hours">Contact Number</strong>
			                                            <input type="text" class="form-control" name="contact_no" id="contact_no" placeholder="Contact Number" value="<?= $data->mobile_no ?>">
			                                    </div>
			                                    <div class="col-md-4">
			                                        <strong for="store_address">Email</strong>
			                                        <input type="text" class="form-control" name="email" id="email" placeholder="Email" value="<?= $data->email ?>">
			                                    </div><br>
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