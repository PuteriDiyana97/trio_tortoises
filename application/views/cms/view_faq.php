<style>
.capitalize {
    text-transform: capitalize;
}
</style>
<div class="kt-subheader-search">
    <div class="kt-container  kt-container--fluid">
        <h3 class="kt-subheader-search__title">
            FAQ
        </h3>
    </div>
</div>

<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
    <form class="kt-form" id="form" name="form" method="post" enctype="multipart/form-data">
        <div class="kt-portlet kt-portlet--mobile">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <h3 class="kt-portlet__head-title">
                        Edit FAQ
                    </h3>
                </div>
            </div>
            <div class="kt-portlet__body">
                <div class="kt-grid">
                    <div class="kt-grid__item kt-grid__item--middle">
                        <div class="form-group row">
                            <div class="col-md-12">

                            </div>
                            <div class="col-md-12">
                                <label>Description</label>
                                <textarea class="form-control form-control-sm" id="description"
                                    name="description"><?= $info->description ?></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-lg-4">

                            </div>
                            <div class="col-lg-4">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="kt-portlet__foot text-right">
                <input type="hidden" id="ids" name="ids" value="" />
                <a href="<?= site_url('faq') ?>" class="btn btn-brand btn-bold btn-font-sm btn-sm" id="btn_cancel"
                    name="btn_cancel">Cancel</a>
                <button type="submit" class="btn btn-success btn-bold btn-font-sm btn-sm" id="btn_save"
                    name="btn_save"><i class="fa fa-save"></i>Save</button>
            </div>
        </div>
    </form>
</div>

<link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.11/summernote-lite.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.11/summernote-lite.js"></script>
<script type="text/javascript">
$("#description").summernote({
    tabsize: 2,
    height: 300,
    callbacks: {
        onImageUpload: function(files, editor, welEditable) {
            for (var i = files.length - 1; i >= 0; i--) {
                sendFile(files[i], this);
            }
        }
        // ,
        // onCreateLink : function(originalLink) {
        // return originalLink; // return original link 
        // }

    }

});

// function sendFile(file,
//     el
// ) { //$('.summernote').summernote('module', 'videoDialog').createVideoNode = function(url) { *build html* return *html*; };
//     var form_data = new FormData();
//     form_data.append('file', file);
//     $.ajax({
//         data: form_data,
//         type: "POST",
//         url: '<?php echo site_url('cms/Faq_Controller/summernote_sync_image') ?>',
//         cache: false,
//         contentType: false,
//         processData: false,
//         success: function(url) {
//             console.log('url', url);
//             $(el).summernote('editor.insertImage', url);
//         }
//     });
// }

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
            url: "<?= site_url('faq/update') ?>",
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

                if (data.status == 1) {
                    swal.fire({
                        title: data.status_message,
                        text: "",
                        type: "success"
                    }).then(function() {
                        $('#form').modal('hide');
                        location.href = "<?= site_url('faq') ?>";
                        loading_off();
                    });

                } else {
                    //  console.log('get-participant-save suceess but fail',data);
                    // alert('Action Participant fail.');

                    swal.fire({
                        title: data.status_message,
                        text: "",
                        type: "error"
                    }).then(function() {
                        $('#form').modal('hide');
                        location.href = "<?= site_url('faq/details') ?>";
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
</script>