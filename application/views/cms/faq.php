<div class="kt-subheader-search">
    <div class="kt-container  kt-container--fluid">
        <h3 class="kt-subheader-search__title">
            FAQ
            <span class="kt-subheader-search__desc"></span>
        </h3>
    </div>
</div>
<style>
.img_advs {
    transition: transform .2s;
    height: 100px;
    max-width: 100%;
}

.img_edit {
    height: 100px;
    max-width: 100%;
}

.capitalize {
    text-transform: capitalize;
}
</style>
<!-- begin:: Content -->
<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
    <form class="kt-form" id="form_filter" name="form_filter" action="" method="post" enctype="multipart/form-data">
        <div class="kt-portlet kt-portlet--mobile">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <h3 class="kt-portlet__head-title">
                        FAQ
                    </h3>
                </div>
            </div>
            <div class="kt-portlet__body">
                <div class="kt-grid">
                    <div class="kt-grid__item kt-grid__item--middle">
                        <div class="row">
                            <div class="col-lg-12">
                                <!-- <strong>Title</strong><br>
                                <span><?= $info->title ?></span> -->
                            </div>
                        </div><br>
                        <div class="row">
                            <div class="col-lg-10">
                                <strong>Description</strong><br>
                                <span><?= nl2br($info->description) ?></span>
                            </div>
                        </div><br>
                        <div class="row">
                            <div class="col-lg-6">
                                <!-- <strong>Banner</strong><br><br>
                                <?php if (empty($info->attachment)) : ?>
                                <br><span>No uploaded image</span>
                                <?php else : ?>
                                <img src="<?php echo base_url('assets/upload_files/faq/' . $info->attachment); ?>"
                                    width="100%">
                                <?php endif; ?> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="kt-portlet__foot text-right">
                <input type="hidden" id="ids" name="ids" value="" />
                <a href="<?= site_url('faq/details') ?>" class="btn btn-success mr-2">Edit</a>
            </div>
        </div>

    </form>
</div>
<!-- end:: Content -->

<script type="text/javascript">
$(function() {

    // when click button search
    $('#btn_search').on('click', function(e) {
        $('#selected_id').val('');

        e.preventDefault();
        data_table_server.draw();
    });

    // when click button reset
    $('#btn_reset').on('click', function(e) {

        //$('#filter_title').val('');
        $('#filter_description').val('');
        $('#selected_id').val('');

        e.preventDefault();
        data_table_server.draw();
    });
    // when click button view
    $('.data_table_server').on('click', '.btn_view', function() {

        loading_on();

        var ids = $(this).attr('ids');

        var dataString = "ids=" + ids;
        // console.log(dataString);
        $.ajax({
            type: "POST",
            url: "<?= site_url('faq/details') ?>",
            data: dataString,
            dataType: 'json',
            cache: false,
            success: function(data) {
                // console.log("data",data);

                if (data.length != '0') {
                    //$('#title').val(data.title);
                    $('#description').val(data.description);
                    $('#banner_show').append(
                        '<img width="180px" height="100px" src="<?= site_url() ?>assets/upload_files/faq/' +
                        data.attachment + '" />');

                    $('#ids').val(ids);

                    loading_off();

                    $('#modal_title').text('Edit FAQ');
                    $('#modal_form').modal('show');
                } else {
                    loading_off();

                    swal.fire({
                        title: 'Selected data not found',
                        text: '',
                        type: 'error',
                        allowOutsideClick: false
                    }).then(function() {});
                }
            }
        });

    });

});
</script>