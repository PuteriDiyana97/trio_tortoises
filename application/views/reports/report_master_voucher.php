<div class="kt-subheader-search">
	<div class="kt-container  kt-container--fluid">
		<h3 class="kt-subheader-search__title">
			Report
			<span class="kt-subheader-search__desc"></span>
		</h3>
	</div>
</div>

<!-- begin:: Content -->
<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
	<form class="kt-form" id="form_filter" name="form_filter" action="" method="post" enctype="multipart/form-data">
		<div class="kt-portlet kt-portlet--mobile">
			<div class="kt-portlet__head">
				<div class="kt-portlet__head-label">
					<h3 class="kt-portlet__head-title">Master Voucher</h3>
				</div>
			</div>
			<div class="kt-portlet__body">
				<div class="accordion accordion-solid accordion-toggle-plus" id="accordionExample3">
					<div class="card">
						<div class="card-header" id="headingThree3">
							<div class="card-title collapsed" data-toggle="collapse" data-target="#collapseThree3" aria-expanded="false">
								Advance Filter
							</div>
						</div>
						<div id="collapseThree3" class="collapse" data-parent="#accordionExample3" style=""><br>
							<!--start: Filter -->
							<div class="kt-grid">
			            		<div class="kt-grid__item kt-grid__item--middle">
				                    <div class="row">
				                        <div class="col-md-2">
											<strong>Member ID</strong>
											<input type="text" class="form-control form-control-sm" id="filter_id" name="filter_id" placeholder="Member ID" value="">
				                        </div>
				                        <div class="col-md-2">
											<strong>Nationality</strong>
											<select class="form-control kt-selectpicker" id="filter_nationality" name="filter_nationality" data-size="4" data-live-search="true" value="">
												<option data-content="" value="">Nationality</option>
												<option data-content="Malaysian" value="Malaysia">Malaysian</option>
												<option data-content="Singaporean" value="Singapore">Singaporean</option>
												<option data-content="Afghani" value="Afghanistan">Afghan</option>
												<option data-content="Albanian" value="Albania">Albanian</option>
												<option data-content="Algerian" value="Algeria">Algerian</option>
												<option data-content="Andorran" value="Andorra">Andorran</option>
												<option data-content="Angolan" value="Angola">Angolan</option>
												<option data-content="Antigua and Barbuda" value="Antigua and Barbuda">Antigua and Barbuda</option>
												<option data-content="Argentine" value="Argentina">Argentine</option>
												<option data-content="Armenian" value="Armenia">Armenian</option>
												<option data-content="Australian" value="Australia">Australian</option>
												<option data-content="Austrian" value="Austria">Austrian</option>
												<option data-content="Azerbaijani" value="Azerbaijan">Azerbaijani</option>
												<option data-content="Bahamian" value="Bahamas">Bahamian</option>
												<option data-content="Bahraini" value="Bahrain">Bahraini</option>
												<option data-content="Bangladeshi" value="Bangladesh">Bangladeshi</option>
												<option data-content="Barbadian" value="Barbados">Barbadian</option>
												<option data-content="Belarusian" value="Belarus">Belarusian</option>
												<option data-content="Belgium" value="Belgium">Belgium</option>
												<option data-content="Belizean" value="Belize">Belizean</option>
												<option data-content="Beninese" value="Benin">Beninese</option>
												<option data-content="Bhutanese" value="Bhutan">Bhutanese</option>
												<option data-content="Bolivian" value="Bolivia">Bolivian</option>
												<option data-content="Bosnia and Herzegovina" value="Bosnia and Herzegovina">Bosnia and Herzegovina</option>
												<option data-content="Botswanan" value="Botswana">Botswanan</option>
												<option data-content="Brazilian" value="Brazil">Brazilian</option>
												<option data-content="Bruneian" value="Brunei">Bruneian</option>
												<option data-content="Bulgarian" value="Bulgaria">Bulgarian</option>
												<option data-content="Burkina Faso" value="Burkina Faso">Burkina Faso</option>
												<option data-content="Angola" value="Angola">Angola</option>
												<option data-content="Burundi" value="Antigua and Barbuda">Antigua and Barbuda</option>
												<option data-content="Cambodia" value="Cambodian">Cambodian</option>
												<option data-content="Cameroon" value="Cameroon">Cameroon</option>
												<option data-content="Canadian" value="Canada">Canadian</option>
												<option data-content="Central African Republic" value="Central African Republic">Central African Republic</option>
												<option data-content="Chadian" value="Chad">Chadian</option>
												<option data-content="Chilean" value="Chile">Chilean</option>
												<option data-content="Chinese" value="China">Chinese</option>
												<option data-content="Colombian" value="Colombia">Colombian</option>
												<option data-content="Comoros" value="Comoros">Comoros</option>
												<option data-content="Congo (Congo-Brazzaville)" value="Congo (Congo-Brazzaville)">Congo (Congo-Brazzaville)</option>
												<option data-content="Costa Rica" value="Costa Rica">Costa Rica</option>
												<option data-content="Croatia" value="Croatia">Croatia</option>
												<option data-content="Cuban" value="Cuba">Cuban</option>
												<option data-content="Cypriot" value="Cyprus">Cypriot</option>
												<option data-content="Czechia (Czech Republic)" value="Czechia (Czech Republic)">Czechia (Czech Republic)</option> <!-- 45 -->
												<option data-content="Indonesian" value="Indonesia">Indonesian</option>
										</select>
									</div>
				                        <div class="col-md-2">
											<strong>Voucher Name</strong>
											<input type="text" class="form-control form-control-sm" id="filter_vname" name="filter_vname" placeholder="Voucher Name" value="">
				                        </div>
				                        <div class="col-md-3">
						                    <strong>Date</strong>
								            <div class="input-daterange input-group" id="kt_datepicker_5">
												<input type="text" class="form-control form-control-sm" id="filter_date_start" name="filter_date_start">
												<div class="input-group-append">
												<span class="input-group-text"><i class="la la-ellipsis-h"></i></span>
												</div>
												<input type="text" class="form-control form-control-sm" id="filter_date_end" name="filter_date_end">
											</div>
					                    </div>
				                        <div class="col-md-3"><br>
					                    	<button type="button" class="btn btn-sm btn-default btn-bold btn-font-sm btn-sm" id="btn_search" name="btn_search">
					                    		<i class="fa fa-search"></i> Search
					                    	</button>
					                    	<button type="button" class="btn btn-sm btn-dark btn-bold btn-font-sm btn-sm" id="btn_reset" name="btn_reset">
					                    		<i class="fa fa-eraser"></i> Reset
					                    	</button>
				                    	</div>
				                    </div>
				                </div>
					        </div>
					        <!--end: Filter -->
						</div>
					</div>
				</div><br>
				<div class="kt-portlet__head-actions">
					<label>Download Report:</label>
					<a href="javascript:void(0)" class="btn btn-brand btn-bold btn-font-sm btn-sm" id="btn_export" name="btn_export">
					<i class="fa fa-download"></i> Master Voucher
					</a>
				</div><br>
				
				<!--begin: Datatable -->
				<table class="table table-striped- table-bordered table-hover table-checkable data_table_server" id="data_table_server">
					<thead>
						<tr>
							<th class="text-center no-sort">No</th>
							<th class="text-center">Member ID</th>
							<!-- <th class="text-center">Member Name</th> -->
							<th class="text-center">Nationality</th>
							<th class="text-center">Current Voucher Name</th>
							<th class="text-center">Current Voucher Type</th>
						</tr>
					</thead>
				</table>

				<input type="hidden" id="selected_id" name="selected_id" value="" />

				<!--end: Datatable -->
			</div>
		</div>
	</form>
</div>

<!--begin::Page Scripts(used by this page) -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<!-- <script src="<?=base_url()?>assets/js/pages/crud/forms/widgets/bootstrap-datepicker.js"></script> -->
<script type="text/javascript">
	$('.kt-selectpicker').selectpicker();
	// when click button search
    $('#btn_search').on('click',function(e){
        $('#selected_id').val('');

        e.preventDefault();
        data_table_server.draw();
    });

    // when click button reset
    $('#btn_reset').on('click',function(e){

        $('#filter_id').val('');
        $('#filter_nationality').val('');
        $('#filter_vname').val('');
        $('#filter_date_start').val('');
        $('#filter_date_end').val('');
        $('#selected_id').val('');

        e.preventDefault();
        data_table_server.draw();   
    });
function load_datepicker()
{
    var last_month = new Date();
    last_month.setDate(last_month.getDate() - 30);
    // set default today date
    $("#filter_date_start").datepicker().datepicker("setDate", last_month);
    $("#filter_date_end").datepicker().datepicker("setDate", new Date());
}

$(function() {

    $('#kt_datepicker_5').datepicker({
    	   // format: "dd/mm/yyyy",
        format: "dd/mm/yyyy",
        toggleActive: true,
        autoclose: true,
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
$(function()
{
        $('#btn_export').on('click',function(){

        var filter_date_start = $('#filter_date_start').val();
        var filter_date_end   = $('#filter_date_end').val();
        
        var dataString = "fds="+filter_date_start+"&fde="+filter_date_end;
        console.log('datastring',dataString);
        Swal.fire({
            title: '<div class="progress progress-md"><div class="progress-bar progress-bar-inverse progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;"><span class="sr-only">Processing</span></div></div>',
            text: 'File is downloading, please wait...',
            showCloseButton: false,
            showCancelButton: false,
            showConfirmButton: false,
            allowOutsideClick: false
        }).then(function () {
        });
       
        $.ajax({
                type: "POST",
                url: "<?=site_url('voucher_export');?>",
                data: dataString,
                cache: false,
                dataType: 'json',
                success: function(data)
                {
                    // console.log(data);

                    if ( data.filesave == 1 )
                    {
                        Swal.fire({
                            title: 'File Download Completed!',
                            text: 'Please click Download to download file.',
                            type: 'success',
                            showCancelButton: true,
                            showCloseButton: false,
                            showConfirmButton: true,
                            confirmButtonText: '<i class="fa fa-download"></i> Download',
                            confirmButtonColor: '#32c861',
                            allowOutsideClick: false
                        }).then(function (result) {
					        if (result.value) {
					          console.log('Downloaded',result);
					          	location.href = '<?=site_url("export_files/")?>'+data.filename;
					        }else{
								console.log('Cancelled');					        	
					        }
					      }
					    );

        //                 Swal.fire({
					   //    title: "Confirm?",
					   //    text: "Are you sure?",
					   //    type: "warning",
					   //    showCancelButton: true,
					   //    confirmButtonColor: "#DD6B55",
					   //    confirmButtonText: "Confirm",
					   //    cancelButtonText: "Back"
					   //    }
					   //  ).then(function (result) {
					   //      if (result.value) {
					   //        console.log('CONFIRMED2',result);
					   //        	location.href = '<?=site_url("export_files/")?>'+data.filename;
					   //      }else{
								// console.log('CANCELLED');					        	
					   //      }
					   //    }
					   //  );

                    }
                    else
                    {
                        Swal.fire({
                            title: 'File Download Fail!',
                            text: 'Please try again later.',
                            type: 'error',
                            showCancelButton: false,
                            showCloseButton: false,
                            showConfirmButton: true,
                            allowOutsideClick: false
                        }).then(function () {});
                    }
                },
                complete: function(data)
                {
                    // console.log(data);
                }
            });
         });
});
var data_table_server = $('.data_table_server').DataTable({ 

		"scrollY": false,
		"scrollX": true,
		"scrollCollapse": true,
	    "processing": true, 
	    "serverSide": true, 
	     
	    "ajax": {
	        "url": "<?=site_url('report/master-voucher-list')?>",
	        "type": "POST",
	        data: function (d) {
	        	d.filter_id = $('#filter_id').val();
                d.filter_nationality = $('#filter_nationality').val();
                d.filter_vname = $('#filter_vname').val();
                d.filter_date_start = $('#filter_date_start').val();
                d.filter_date_end   = $('#filter_date_end').val();
	        },
	    },
	    "pageLength": 50,
	    "language": {
	        "emptyTable": "No data available in the table",
	        "processing": '<div class="alert alert-default" style="color:#ddad4b"><i class="fa fa-circle-o-notch fa-spin fa-1x fa-fw"></i><b>Processing...</b></div>'
	    },

		"searching": true, //disable searching
		"bLengthChange": true, //disable show entries
		"columnDefs": [ {
	          "targets": 'no-sort',
	          "orderable": false,
	    } ],
	    initComplete: function(setting,json){
	        $('.tooltips').tooltip();
	        $('table.table.table-hover.dataTable.no-footer,.dataTables_scrollHeadInner').css("min-width", "100%");
	        $(window).trigger('resize'); 
	    },
	    createdRow: function( row, data, dataIndex ) {
	    	$( row ).find('td:eq(0)').addClass('text-center');
	    },
	    order: [[ 3, "ASC" ]],

	});
</script>