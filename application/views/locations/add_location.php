<style>
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map {
        height: 100%;
      }
      /* Optional: Makes the sample page fill the window. */
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
      #description {
        font-family: Roboto;
        font-size: 15px;
        font-weight: 300;
      }

      #infowindow-content .title {
        font-weight: bold;
      }

      #infowindow-content {
        display: none;
      }

      #map #infowindow-content {
        display: inline;
      }

      .pac-card {
        margin: 10px 10px 0 0;
        border-radius: 2px 0 0 2px;
        box-sizing: border-box;
        -moz-box-sizing: border-box;
        outline: none;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
        background-color: #fff;
        font-family: Roboto;

      }

      #pac-container {
        padding-bottom: 12px;
        margin-right: 12px;
      }

      .pac-controls {
        display: inline-block;
        padding: 5px 11px;
      }

      .pac-controls label {
        font-family: Roboto;
        font-size: 13px;
        font-weight: 300;
      }

      #pac-input {
        background-color: #fff;
        font-family: Roboto;
        font-size: 15px;
        font-weight: 300;
        margin-left: 12px;
        padding: 0 11px 0 13px;
        text-overflow: ellipsis;
        width: 350px;
      }

      #pac-input:focus {
        border-color: #4d90fe;
      }

      #title {
        color: #fff;
        background-color: #4d90fe;
        font-size: 25px;
        font-weight: 500;
        padding: 6px 12px;
      }

      .capitalize {
        text-transform: capitalize;
      }
</style>
<div class="kt-subheader-search">
  <div class="kt-container  kt-container--fluid">
    <h3 class="kt-subheader-search__title">
      Store Locator
    </h3>
  </div>
</div>

<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
	<div class="pac-card" id="pac-card">
      <div>
        <div id="title">
          Autocomplete search
        </div>
        <div id="type-selector" class="pac-controls ">
          <input type="radio" name="type" id="changetype-all" checked="checked">
          <label for="changetype-all">All</label>

          <input type="radio" name="type" id="changetype-establishment">
          <label for="changetype-establishment">Establishments</label>

          <input type="radio" name="type" id="changetype-address">
          <label for="changetype-address">Address</label>

          <input type="radio" name="type" id="changetype-geocode">
          <label for="changetype-geocode">Geocodes</label>
        </div>
        <div id="strict-bounds-selector" class="pac-controls">
          <input type="checkbox" id="use-strict-bounds" value="">
          <label for="use-strict-bounds">Strict Bounds</label>
        </div>
      </div>
      <div id="pac-container">
        <input id="pac-input" type="text"
            placeholder="Enter a location">
      </div>
    </div>
    
    <div id="map" style="width:100%;height:550px;"></div>
    <div id="infowindow-content">
      <img src="" width="16" height="16" id="place-icon">   
      <span id="place-name"  class="title"></span><br>
      <span id="place-address"></span>
    </div><br>
</div><br>

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
                                
                            </div>
                        </div><br>
                        <div class="row">
                            <div class="col-md-4">
                                        <strong for="store_name">Location Name <?=COMPULSORY;?></strong>
                                        <input type="text" class="form-control capitalize" name="store_name" id="store_name" placeholder="Location Name" required="">
                            </div>
                            <div class="col-md-8">
                                        <strong for="store_address">Store Address </strong>
                                        <textarea type="text" class="form-control capitalize" name="store_address" id="store_address" placeholder="Store Address"></textarea> 
                            </div>
                        </div><br>
                        <div class="row">
                                    <div class="col-md-2"> 
                                          <strong for="open_hours">Open Time <?=COMPULSORY;?></strong>
                                          <input class="form-control" id="kt_timepicker_1" name="open_time" readonly="" placeholder="Select time" type="text" required="">
                                    </div>
                                    <div class="col-md-2"> 
                                          <strong for="open_hours">Close Time <?=COMPULSORY;?></strong>
                                          <input class="form-control" id="kt_timepicker_1" name="close_time" readonly="" placeholder="Select time" type="text" required="">
                                    </div>
                             <div class="col-md-3">
                                        <strong for="description">Phone Number <?=COMPULSORY;?></strong>
                                        <input type="text" class="form-control" name="contact_no" id="contact_no" placeholder="Phone Number">
                            </div>
                            <div class="col-md-3">
                                    <strong>Image</strong>
                                    <input type="file" class="form-control form-control-sm" id="attachment" name="attachment">
                                    <div>
                                        <span>Allowed type: png | jpg | jpeg</span>
                                        <span style="float: left;">(Max: 13MB, Height:600px Width:500px)</span>
                                    </div>
                            </div>
                            <input type="hidden" class="form-control" name="latitude" id="latitude" placeholder="Latitude" readonly>
                            <input type="hidden" class="form-control" name="longitude" id="longitude" placeholder="Longitude" readonly>
                        </div>  
            </div>
      </div>
    </div>
      <div class="kt-portlet__foot text-right">
    		<input type="hidden" id="ids" name="ids" value="" />
            <a href="<?=site_url('store-locator')?>" class="btn btn-brand btn-bold btn-font-sm btn-sm" id="btn_cancel" name="btn_cancel">Cancel
    					</a>
    	    <button type="submit" class="btn btn-success btn-bold btn-font-sm btn-sm" id="btn_save" name="btn_save"><i class="fa fa-save"></i>Save</button>
    	</div>
    </div>
  </form>
</div>
<!-- end:: Content --> 
<script src="<?=base_url()?>assets/js/scripts.bundle.js"></script>
<script src="<?=base_url()?>assets/js/pages/crud/forms/widgets/bootstrap-timepicker.js"></script>
<script>
  $('#kt_timepicker_1, #kt_timepicker_1_modal').timepicker();

      function initMap() {
        var map = new google.maps.Map(document.getElementById('map'), {
          center: {lat: 1.4662851, lng: 103.6319212},
          zoom: 15
        });
        var card = document.getElementById('pac-card');
        var input = document.getElementById('pac-input');
        var types = document.getElementById('type-selector');
        var strictBounds = document.getElementById('strict-bounds-selector');

        map.controls[google.maps.ControlPosition.TOP_RIGHT].push(card);

        var autocomplete = new google.maps.places.Autocomplete(input);

        // Bind the map's bounds (viewport) property to the autocomplete object,
        // so that the autocomplete requests use the current map bounds for the
        // bounds option in the request.
        autocomplete.bindTo('bounds', map);

        // Set the data fields to return when the user selects a place.
        autocomplete.setFields(
            ['address_components', 'geometry', 'icon', 'name']);

        var infowindow = new google.maps.InfoWindow();
        var infowindowContent = document.getElementById('infowindow-content');
        infowindow.setContent(infowindowContent);
        var marker = new google.maps.Marker({
          map: map,
          anchorPoint: new google.maps.Point(0, -29)
        });

    //   var address = document.getElementById('address');
    //   var autocomplete = new google.maps.places.Autocomplete(address);

        autocomplete.addListener('place_changed', function() {
          infowindow.close();
          marker.setVisible(false);
          var place = autocomplete.getPlace();
          
          // var componentForm = {
          //   street_number: 'short_name',
          //   route: 'long_name',
          //   locality: 'long_name',
          //   administrative_area_level_1: 'short_name',
          //   country: 'long_name',
          //   postal_code: 'short_name'
          // };

          // console.log('place',place);
          console.log('latitude',place.geometry.location.lat());
          console.log('longitude',place.geometry.location.lng());
          $('#latitude').val(place.geometry.location.lat());
          $('#longitude').val(place.geometry.location.lng());
          // $('#store_name').val();
          
          if (!place.geometry) {
            // User entered the name of a Place that was not suggested and
            // pressed the Enter key, or the Place Details request failed.
            window.alert("No details available for input: '" + place.name + "'");
            return;
          }

          // If the place has a geometry, then present it on a map.
          if (place.geometry.viewport) {
            map.fitBounds(place.geometry.viewport);
          } else {
            map.setCenter(place.geometry.location);
            map.setZoom(17);  // Why 17? Because it looks good.
          }
          marker.setPosition(place.geometry.location);
          marker.setVisible(true);

          var address = '';
          if (place.address_components) {
            address = [
              (place.address_components[0] && place.address_components[0].short_name || ''),
              (place.address_components[1] && place.address_components[1].short_name || ''),
              (place.address_components[2] && place.address_components[2].short_name || '')
            ].join(' ');
          }

          infowindowContent.children['place-icon'].src = place.icon;
          infowindowContent.children['place-name'].textContent = place.name;
          infowindowContent.children['place-address'].textContent = address;
          infowindow.open(map, marker);
        });

        // Sets a listener on a radio button to change the filter type on Places
        // Autocomplete.
        function setupClickListener(id, types) {
          var radioButton = document.getElementById(id);
          radioButton.addEventListener('click', function() {
            autocomplete.setTypes(types);
          });
        }

        setupClickListener('changetype-all', []);
        setupClickListener('changetype-address', ['address']);
        setupClickListener('changetype-establishment', ['establishment']);
        setupClickListener('changetype-geocode', ['geocode']);

        document.getElementById('use-strict-bounds')
            .addEventListener('click', function() {
              console.log('Checkbox clicked! New state=' + this.checked);
              autocomplete.setOptions({strictBounds: this.checked});
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
                     //  console.log('get-participant-save suceess but fail',data);
                      // alert('Action Participant fail.');

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
          // console.log(dataString);
      }
  });
      }
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD0m6ob2DuYu4klOPKkYNTAGoqsrgWTYxs&libraries=places&callback=initMap"
        async defer></script>
