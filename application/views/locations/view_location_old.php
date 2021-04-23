<div class="kt-subheader-search">
	<div class="kt-container  kt-container--fluid">
		<h3 class="kt-subheader-search__title">
			Store Locator
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
						Edit Location
					</h3>
				</div>
			</div>
			<div class="kt-portlet__body">

				<div class="kt-grid">
            		<div class="kt-grid__item kt-grid__item--middle">
	                    
                        <div class="row">
                            <div class="col-md-12">
                                <div class="panel panel-primary">
                                    <div class="panel-heading"><span class="glyphicon glyphicon-globe"></span><strong>Map</strong></div><br>
                                    <div class="panel-body" style="height:350px;" id="map-canvas"></div>
                                </div>
                            </div>
                        </div><br>
                        <div class="row">
                            <div class="col-md-4">
                                        <strong for="store_name">Location Name</strong>
                                        <input type="text" class="form-control" name="store_name" id="store_name" placeholder="Location Name">
                            </div>
                            <div class="col-md-8">
                                        <strong for="description">Description</strong>
                                        <textarea type="text" class="form-control" name="description" id="description" placeholder="Description"></textarea> 
                            </div>
                        </div><br>
                        <div class="row">
                                    <div class="col-md-4"> 
                                        <div class="form-group">
                                            <strong for="open_hours">Open Hours</strong>
                                            <input type="text" class="form-control" name="open_hours" id="open_hours" placeholder="Open Hours"><!-- <?php echo $location_info->store_address ?> -->
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <strong for="store_address">Store Address</strong>
                                        <textarea type="text" class="form-control" name="store_address" id="store_address" placeholder="Store Address"></textarea> 
                                        <!-- <?php echo $location_info->store_address ?> -->
                                    </div>
                                    <div class="col-md-4"> 
                                        <div class="form-group">
                                            <strong for="latitude">Latitude</strong>
                                            <input type="text" class="form-control" name="latitude" id="latitude" placeholder="Latitude">
                                        </div>
                                    </div>
                                    <div class="col-md-4"> 
                                        <div class="form-group">
                                            <strong for="longitude">Longitude</strong>
                                            <input type="text" class="form-control" name="longitude" id="longitude" placeholder="Longitude">
                                        </div>
                                    </div>
                        </div>     
                        <div class="row">
                            <div class="col-md-4">
                                    <strong>Image</strong>
                                    <input type="file" class="form-control form-control-sm" id="attachment" name="attachment" placeholder="Banner">
                                </div>
                        </div>     
		        </div>
			</div>
		</div>
		<div class="kt-portlet__foot text-right">
					<input type="hidden" id="ids" name="ids" value="" />
	                <a href="<?=site_url('store-locator')?>" class="btn btn-brand btn-bold btn-font-sm btn-sm" id="btn_cancel" name="btn_cancel">Cancel
					</a>
	                <button type="submit" class="btn btn-success btn-bold btn-font-sm btn-sm" id="btn_save" name="btn_save"><i class="fa fa-save"></i>Save</button>
                    <button class="btn btn-info btn-font-sm btn-sm" id="clearmap"><span class="glyphicon glyphicon-globe"></span> ClearMap</button>
		</div>
	</form>
</div>
<!-- end:: Content -->

<!--begin::Page Scripts(used by this page) -->
<!--script google map-->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD0m6ob2DuYu4klOPKkYNTAGoqsrgWTYxs"></script> <!-- guna google map -->
<script>

$(document).on('click','#clearmap',clearmap)
    var map;
    var markers = [];

    function initialize() {
        var mapOptions = {
        zoom: 19,
        // location center
        center: new google.maps.LatLng(1.3344204,103.5926155)
        };

        map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);

        // Add a listener for the click event
        google.maps.event.addListener(map, 'rightclick', addLatLng);
        google.maps.event.addListener(map, "rightclick", function(event) {
          var lat = event.latLng.lat();
          var lng = event.latLng.lng();
          $('#latitude').val(lat);
          $('#longitude').val(lng);
          //alert(lat +" dan "+lng);
        });
    }

    /**
     * Handles click events on a map, and adds a new point to the marker.
     * @param {google.maps.MouseEvent} event
     */
    function addLatLng(event) {
        var marker = new google.maps.Marker({
        position: event.latLng,
        title: 'Star Glory Locator',
        map: map
        });
        markers.push(marker);
    }
    //membersihkan peta dari marker
    function clearmap(e){
        e.preventDefault();
        $('#latitude').val('');
        $('#longitude').val('');
        setMapOnAll(null);
    }
    //buat hapus marker
    function setMapOnAll(map) {
      for (var i = 0; i < markers.length; i++) {
        markers[i].setMap(map);
      }
      markers = [];
    }
    //end buat hapus marker

    function location_coordinates(e){
        e.preventDefault();
        var datakoordinat = {'id_store_locations':$('#id_store_locations').val(),'latitude':$('#latitude').val(),'longitude':$('#longitude').val()};
        console.log(datakoordinat);
        $.ajax({
            url : '<?php echo site_url("admin/location_coordinates") ?>',
            dataType : 'json',
            data : datakoordinat,
            type : 'POST',
            success : function(data,status){
                if (data.status!='error') {
                    $('#register_location_coordinates').load('<?php echo current_url()."/ #register_location_coordinates > *" ?>');
                    alert(data.msg);
                    clearmap(e);
                }else{
                    alert(data.msg);
                }
            }
        })
    }

    function view_location(e){
        e.preventDefault();
        var datakoordinat = {'id_store_locations':$(this).data('iddatajembatan')};
        $.ajax({
            url : '<?php echo site_url("admin/view_location") ?>',
            data : datakoordinat,
            dataType : 'json',
            type : 'POST',
            success : function(data,status){
                if (data.status!='error') {
                    clearmap(e);
                    //load marker
                    $.each(data.msg,function(m,n){
                        var myLatLng = {lat: parseFloat(n["latitude"]), lng: parseFloat(n["longitude"])};
                        console.log(m,n);
                        $.each(data.datajembatan,function(k,v){
                            addMarker(v['store_name'],myLatLng);
                        })
                        return false;
                    })
                    //end load marker
                }else{
                    alert(data.msg);
                }
            }
        })
    }
    // Menampilkan marker lokasi 
    function addMarker(nama,location) {
        var marker = new google.maps.Marker({
            position: location,
            map: map,
            title : nama
        });
        markers.push(marker);
    }

    google.maps.event.addDomListener(window, 'load', initialize);

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
	            url: "<?=site_url('store-location/insert')?>",
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
	                        location.href = "<?=site_url('store-locator')?>";
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
	                        location.href = "<?=site_url('store-locator')?>";
	                         loading_off();
	                    });
	                }
	            }
	        });
	    }
	});
});

</script>