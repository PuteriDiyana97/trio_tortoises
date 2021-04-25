
<div class="kt-subheader-search">
	<div class="kt-container  kt-container--fluid">
		<h3 class="kt-subheader-search__title">
			Member
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
						View Member
					</h3>
				</div>
				<!-- <div class="kt-portlet__head-toolbar">
					<div class="kt-portlet__head-wrapper">
						<div class="kt-portlet__head-actions">
							<button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">Joined Account</button>
							<?php foreach ($member_points as $mp) { ?>
							<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
						        <a class="dropdown-item" href="javascript:void(0)">(<?= $mp->name ?>, <?= $mp->contact_no ?>)</a>
						    </div>
						    <?php } ?>
						</div>
					</div>
				</div> -->

			</div>
			<div class="kt-portlet__body">

				<div class="kt-grid">
            		<div class="kt-grid__item kt-grid__item--middle">
	                    <div class="row">
								<div class="col-md-3">
									<strong>Full Name</strong>
									<input type="text" class="form-control form-control-sm" id="full_name" name="full_name" placeholder="Full Name" value="<?= $member_list->name ?>">
								</div>
								<div class="col-md-3">
									<strong>Mobile No.</strong>
									<input type="text" class="form-control form-control-sm" id="mobile_no" name="mobile_no" placeholder="Mobile No." value="<?= $member_list->contact_no ?>" >
								</div>
								<div class="col-md-3">
									<strong>Email</strong>
									<input type="email" class="form-control form-control-sm" id="email" name="email" placeholder="Email" value="<?= $member_list->email ?>">
								</div>
								<div class="col-md-3">
									<strong>Date of Birth</strong>
									<input type="text" class="form-control form-control-sm kt_datepicker_4_3" id="dob" name="dob" value="<?= date("d-m-Y", strtotime($member_list->date_of_birth))  ?>">																
								</div>
			            </div><br>
			            <div class="row">
								<div class="col-md-3">
									<strong>Gender</strong>
									<select class="form-control kt-selectpicker" id="gender" name="gender" data-size="4">
										    <option> Select Gender</option>
											<option data-content="Female" value="Female" <?= $member_list->gender == 'Female' ? 'selected' : '' ?>>Female</option>
											<option data-content="Male" value="Male" <?= $member_list->gender == 'Male' ? 'selected' : '' ?>>Male</option>
											
									</select>
								</div>	
								<div class="col-md-3">
									<strong>Race</strong>
									<select class="form-control kt-selectpicker" id="race" name="race" data-size="7" data-live-search="true">
											<option> Select Race</option>
											<option data-content="Indian" value="Indian" <?= $member_list->race == 'Indian' ? 'selected' : '' ?>>Indian</option>
											<option data-content="Chinese" value="Chinese" <?= $member_list->race == 'Chinese' ? 'selected' : '' ?>>Chinese</option>
											<option data-content="Malay" value="Malay" <?= $member_list->race == 'Malay' ? 'selected' : '' ?>>Malay</option>
											<option data-content="Others" value="Others" <?= $member_list->race == 'Others' ? 'selected' : '' ?>>Others</option>
											
									</select>
								</div>
								<div class="col-md-3">
									<strong>Address</strong>
									<textarea type="text" class="form-control form-control-sm" id="address" name="address" placeholder="Address(Street Name)" ><?= $member_list->address ?></textarea>
								</div>
								<div class="col-md-3">
									<strong>State</strong>
									<input type="text" class="form-control form-control-sm" id="state" name="state" placeholder="State" value="<?= $member_list->state ?>">
								</div>
								
			            </div><br>
			            <div class="row">
			            	<div class="col-md-3">
									<strong>Country</strong>
									<select class="form-control kt-selectpicker" id="country" name="country" data-size="4" data-live-search="true">
											<!-- <option data-content="" value="<?= $member_list->country ?>"><?= $member_list->country ?></option>
											<option data-content="Afghanistan" value="Afghanistan">Afghanistan</option>
											<option data-content="Albania" value="Albania">Albania</option>
											<option data-content="Algeria" value="Algeria">Algeria</option>
											<option data-content="Andorra" value="Andorra">Andorra</option>
											<option data-content="Angola" value="Angola">Angola</option>
											<option data-content="Antigua and Barbuda" value="Antigua and Barbuda">Antigua and Barbuda</option>
											<option data-content="Argentina" value="Argentina">Argentina</option>
											<option data-content="Armenia" value="Armenia">Armenia</option>
											<option data-content="Australia" value="Australia">Australia</option>
											<option data-content="Austria" value="Austria">Austria</option>
											<option data-content="Azerbaijan" value="Azerbaijan">Azerbaijan</option>
											<option data-content="Bahamas" value="Bahamas">Bahamas</option>
											<option data-content="Bahrain" value="Bahrain">Bahrain</option>
											<option data-content="Bangladesh" value="Bangladesh">Bangladesh</option>
											<option data-content="Barbados" value="Barbados">Barbados</option>
											<option data-content="Belarus" value="Belarus">Belarus</option>
											<option data-content="Belgium" value="Belgium">Belgium</option>
											<option data-content="Belize" value="Belize">Belize</option>
											<option data-content="Benin" value="Benin">Benin</option>
											<option data-content="Bhutan" value="Bhutan">Bhutan</option>
											<option data-content="Bolivia" value="Bolivia">Bolivia</option>
											<option data-content="Bosnia and Herzegovina" value="Bosnia and Herzegovina">Bosnia and Herzegovina</option>
											<option data-content="Botswana" value="Botswana">Botswana</option>
											<option data-content="Brazil" value="Brazil">Brazil</option>
											<option data-content="Brunei" value="Brunei">Brunei</option>
											<option data-content="Bulgaria" value="Bulgaria">Bulgaria</option>
											<option data-content="Burkina Faso" value="Burkina Faso">Burkina Faso</option>
											<option data-content="Angola" value="Angola">Angola</option>
											<option data-content="Burundi" value="Antigua and Barbuda">Antigua and Barbuda</option>
											<option data-content="Côte d'Ivoire" value="Côte d'Ivoire">Côte d'Ivoire</option>
											<option data-content="Cabo Verde" value="Cabo Verde">Cabo Verde</option>
											<option data-content="Cambodia" value="Cambodia">Cambodia</option>
											<option data-content="Cameroon" value="Cameroon">Cameroon</option>
											<option data-content="Canada" value="Canada">Canada</option>
											<option data-content="Central African Republic" value="Central African Republic">Central African Republic</option>
											<option data-content="Chad" value="Chad">Chad</option>
											<option data-content="Chile" value="Chile">Chile</option>
											<option data-content="China" value="China">China</option>
											<option data-content="Colombia" value="Colombia">Colombia</option>
											<option data-content="Comoros" value="Comoros">Comoros</option>
											<option data-content="Congo (Congo-Brazzaville)" value="Congo (Congo-Brazzaville)">Congo (Congo-Brazzaville)</option>
											<option data-content="Costa Rica" value="Costa Rica">Costa Rica</option>
											<option data-content="Croatia" value="Croatia">Croatia</option>
											<option data-content="Cuba" value="Cuba">Cuba</option>
											<option data-content="Cyprus" value="Cyprus">Cyprus</option>
											<option data-content="Czechia (Czech Republic)" value="Czechia (Czech Republic)">Czechia (Czech Republic)</option> --> <!-- 45 -->
											<!-- <option data-content="Vietnam" value="Vietnam">Vietnam</option>
											<option data-content="Indonesia" value="Indonesia">Indonesia</option>
											<option data-content="Malaysia" value="Malaysia">Malaysia</option>
											<option data-content="Singapore" value="Singapore">Singapore</option> -->
											<?php foreach ($country_list as $cl) { ?>
											<option value="<?= $cl->country ?>" <?= $member_list->country == $cl->country ?"selected":"" ?>><?= $cl->country ?></option>
											<?php } ?>
									</select>
								</div>
								<div class="col-md-3">
									<strong>City</strong>
									<input type="text" class="form-control form-control-sm" id="city" name="city" placeholder="City" value="<?= $member_list->city ?>">
								</div>
								<div class="col-md-3">
									<strong>Zipcode</strong>
									<input type="text" class="form-control form-control-sm" id="zipcode" name="zipcode" placeholder="Zipcode" value="<?= $member_list->zipcode ?>">
								</div>
								<div class="col-md-3">
									<strong>Membership Type</strong>
									<select class="form-control kt-selectpicker" id="status" name="status" data-size="5" data-live-search="true">
										<option value="Membership Type">Membership Type</option>
										<option data-content="Star Glory Lite(SGL)" value="1" <?= $member_list->customer_type == 1 ? 'selected' : '' ?>>Star Glory Lite(SGL)</option>
										<option data-content="Star Glory Silver(SGS)" value="2" <?= $member_list->customer_type == 2 ? 'selected' : '' ?>>Star Glory Silver(SGS)</option>	
										<option data-content="Star Glory Gold(SGG)" value="3" <?= $member_list->customer_type == 3 ? 'selected' : '' ?>>Star Glory Gold(SGG)</option>
										<option data-content="Star Glory VIP(SGV)" value="4" <?= $member_list->customer_type == 4 ? 'selected' : '' ?>>Star Glory VIP(SGV)</option>	
									</select>
								</div>
			            </div><br>
		        </div>
			</div>
			<br>
			
		</div>

		<div class="kt-portlet__foot text-right">
					<input type="hidden" id="ids" name="ids" value="<?=$_GET['ids']?>" />
	                <a href="<?=site_url('member')?>" class="btn btn-brand btn-bold btn-font-sm btn-sm" id="btn_cancel" name="btn_cancel">Cancel
					</a>
	                <button type="submit" class="btn btn-success btn-bold btn-font-sm btn-sm btn-sm" id="btn_save" name="btn_save"><i class="fa fa-save"></i>Save</button>
		</div>
	</div>
	</form>
	<div class="kt-portlet kt-portlet--mobile">
		<div class="kt-portlet__body">
			<table class="table table-striped- table-bordered table-hover table-checkable data_table_server" id="data_table_server">
					<thead>
						<tr>
							<th class="text-center no-sort">Date</th>
							<th class="text-center">Description</th>
							<th>Receipt No</th>
							<th>Terminal ID</th>
							<th>Type</th>
							<th>Branch Code</th>
							<th>Transaction Amounts</th>
							<th class="text-center">Transaction Points</th>
							<th class="text-center">Current Points</th>
							<!-- <th class="text-center">Total Points</th> -->
						</tr>
					</thead>
					<tbody>
						<?php 
						$total=0;
						
						foreach ($member_points as $mp) { 
						//********************************************add calculation****************************************
							$this->db->select('SUM(dcp.points) AS current_points, COUNT(dcp.contact_no) AS curr_points')
													->from('data_customer_points as dcp')
													->join('data_customer','dcp.contact_no = data_customer.contact_no','left')
													->where('dcp.point_type','1')
													->where('dcp.transaction_date <=', $mp->c_transaction_date)
													->limit(1);
							if(isset($mp->data_cust_group_id) && !empty($mp->data_cust_group_id) && $mp->data_cust_group_id > 0)
							{
								$this->db->where('dcp.group_id',$mp->data_cust_group_id);
							}
							else
							{
								$this->db->where('dcp.contact_no',$mp->contact_no);
							}
							$qFind_sumTotal = $this->db->get()->row();
							
							
						//*****************************************subtraction calculation*******************************************
							$this->db->select('SUM(dcp.points) AS current_points, COUNT(dcp.contact_no) AS curr_points')
													->from('data_customer_points as dcp')
													->join('data_customer','dcp.contact_no = data_customer.contact_no','left')
													->where('dcp.point_type','0')
													->where('dcp.transaction_date <=', $mp->c_transaction_date)
													->limit(1);
							if(isset($mp->data_cust_group_id) && !empty($mp->data_cust_group_id) && $mp->data_cust_group_id > 0)
							{
								$this->db->where('dcp.group_id',$mp->data_cust_group_id);
							}
							else
							{
								$this->db->where('dcp.contact_no',$mp->contact_no);
							}
							$qFind_sumUsedTotal = $this->db->get()->row();

							$add = isset($qFind_sumTotal->current_points) && $qFind_sumTotal->current_points > 0 ? $qFind_sumTotal->current_points : 0 ;
							$minus = isset($qFind_sumUsedTotal->current_points) && $qFind_sumUsedTotal->current_points > 0 ? $qFind_sumUsedTotal->current_points : 0 ;
							$balance = $add - $minus;

							$point_indicator = ($mp->point_type == '1') ? '' : '-' ;

							$a = 'Sales for';
							$b = 'Void for ';

						    if(strpos($mp->description, $a) !== false) {
									    
							   $transaction_no  = trim(str_replace($a, '', $mp->description));
							   $type = '1';
						

							}else if(strpos($mp->description, $b) !== false){

								$transaction_no  = trim(str_replace($b, '', $mp->description));
								$type = '3';

							}else{

								$transaction_no  = '';
								$type = '';
							}

							

							$transaction_details = $this->Members->transaction_details($transaction_no,$type);
							// pre($transaction_no); 
							// pre($transaction_details);
							$trxnum   = '';
							$terminal = '';
							$trxtotal = '';
							$active   = '';

							if(!empty($transaction_details)){

								$trxnum   = $transaction_details->trxnum;
								$terminal = $transaction_details->terminal;
								$trxtotal = $transaction_details->trxpoint_desc;

								if( $transaction_details->active == '1'){

									$active   = 'SA';

								}else if( $transaction_details->active == '3'){

									$active   = 'VD';

								}else{

									$active   = '';

								}

							}

							
						//die();
						?>
						<tr>
							<td><?= $mp->transaction_date ?></td>
							<td><?= $mp->description ?> (<?= $mp->contact_no ?>, <?= $mp->name ?>)</td> 
							<td><?=$transaction_no ?></td>
							<td><?= $terminal ?></td>
							<td><?=$active?></td>
							<td><?=$terminal?></td>
							<td><?= $trxtotal ?></td>
							<td><?= $point_indicator?><?= $mp->points ?></td>
							<td><?php echo $balance ?></td>
							<!-- <th class="text-center"><?= $member_list->total_points ?></th> -->
						</tr>
					<?php } ?>
					</tbody>
				</table>
		</div>
	</div>
</div>
<!-- end:: Content -->

<!--begin::Page Scripts(used by this page) -->

<script src="<?=base_url()?>assets/js/scripts.bundle.js"></script>
<script src="<?=base_url()?>assets/js/pages/crud/forms/widgets/bootstrap-datepicker.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
    $('#data_table_server').DataTable();
} );
	// $(document).ready(function() {
	//     $('#example').DataTable( {
	//         "order": [[ 0, "asc" ]]
	
	//     } );
	// } );

$(function(){
	$('.kt-selectpicker').selectpicker();

    $('.kt_datepicker_4_3').datepicker({
        todayHighlight: true,
        autoclose: true,
        format: "dd-M-yyyy",
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
	            url: "<?=site_url('member/update')?>",
	            data: dataString,
	            dataType: 'json',
	            enctype: 'multipart/form-data',
	            processData: false,
	            contentType: false,
	            data: new FormData(this),
	            cache: false,
	            success: function(data) {
	              //  alert(data);
	                console.log("frm submit", data);

	                  if(data.status == 1)
	                {
	                    swal.fire({
	                        title: data.status_message,
	                        text: "",
	                        type: "success"
	                    }).then(function() {
	                        $('#form').modal('hide');
	                        location.href = "<?=site_url('member')?>";
	                         loading_off();
	                    });

	                }
	                else
	                {
	                   //  console.log('get-participant-save suceess but fail',data);
	                    // alert('Action Participant fail.');

	                     swal.fire({
	                        title: data.status_message,
	                        text: "",
	                        type: "error"
	                    }).then(function() {
	                        $('#form').modal('hide');
	                        location.href = "<?=site_url('member')?>";
	                         loading_off();
	                    });

	                }
	            }
	        });
	        // console.log(dataString);
	        // $('#promo_setting').modal('hide');
	        // loading_off();
	    }
	});


});

</script>