<div class="kt-subheader-search">
  <div class="kt-container  kt-container--fluid">
    <h3 class="kt-subheader-search__title">
      My Profile
    </h3>
  </div>
</div>

<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
			<!--begin::Form-->
			<form class="form">
				<div class="kt-portlet kt-portlet--mobile">
			      <div class="kt-portlet__head">
			        <div class="kt-portlet__head-label">
			          <h3 class="kt-portlet__head-title">
			            My Profile
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
			                                        <span class="m-l-15"><?=$data->full_name ?></span>
			                            </div>
			                            <div class="col-md-4">
			                                        <strong for="contact_no">Username</strong>
			                                        <span class="m-l-15"><?=$data_login->user_name ?></span>
			                            </div>
			                        </div><br>
			                        <div class="row">
			                                    <div class="col-md-4"> 
			                                            <strong for="open_hours">Contact Number</strong>
			                                            <span class="m-l-15"><?=$data->mobile_no ?></span>
			                                    </div>
			                                    <div class="col-md-4">
			                                        <strong for="store_address">Email</strong>
			                                        <span class="m-l-15"><?=$data->email ?></span>
			                                    </div><br>
			                        </div><br>
			            </div>
			      	</div>
			      	
				</div>
				<div class="kt-portlet__foot text-right ">
		    		<input type="hidden" id="ids" name="ids" value="<?= $this->session->curr_user_id ?>" />
		            <a href="<?=site_url('dashboard')?>" class="btn btn-secondary" id="btn_cancel" name="btn_cancel">Cancel</a>
		            <a href="<?=site_url('profile/details')?>" class="btn btn-success mr-2">Edit</a>
		    	   
		    	</div>
				<!--end::Body-->
			</div>
			</form>
			<!--end::Form-->
</div>