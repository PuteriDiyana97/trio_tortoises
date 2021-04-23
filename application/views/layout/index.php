<!DOCTYPE html>

<html lang="en">

    <!-- begin::Head -->
    <?php if ( $index_header ) echo $index_header ;?>
    <!-- end::Head -->

    <!-- begin::Body -->
    <body class="kt-quick-panel--right kt-demo-panel--right kt-offcanvas-panel--right kt-header--fixed kt-header-mobile--fixed kt-subheader--enabled kt-subheader--solid kt-aside--enabled kt-aside--fixed kt-aside--minimize kt-page--loading">

        <!-- begin:: Page -->

        <!-- begin:: Header Mobile -->
        <div id="kt_header_mobile" class="kt-header-mobile  kt-header-mobile--fixed ">
            <div class="kt-header-mobile__logo">
                <a href="index.html">
                    <img alt="Logo" src="assets/media/custom/starglo-300px.png" style="width: 20%;" />
                </a>
            </div>
            <div class="kt-header-mobile__toolbar">
                <div class="kt-header-mobile__toolbar-toggler kt-header-mobile__toolbar-toggler--left" id="kt_aside_mobile_toggler"><span></span></div>
                <!-- <div class="kt-header-mobile__toolbar-toggler" id="kt_header_mobile_toggler"><span></span></div> -->
                <div class="kt-header-mobile__toolbar-topbar-toggler" id="kt_header_mobile_topbar_toggler"><i class="flaticon-more"></i></div>
            </div>
        </div>

        <!-- end:: Header Mobile -->
        <div class="kt-grid kt-grid--hor kt-grid--root">
            <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--ver kt-page">

                <!-- begin:: Aside -->
                <button class="kt-aside-close " id="kt_aside_close_btn"><i class="la la-close"></i></button>
                <div class="kt-aside  kt-aside--fixed  kt-grid__item kt-grid kt-grid--desktop kt-grid--hor-desktop" id="kt_aside">

                    <!-- begin:: Aside Menu -->
                    <?php if ( $index_left_menu ) echo $index_left_menu ;?>
                    <!-- end:: Aside Menu -->

                </div>

                <!-- end:: Aside -->
                <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-wrapper" id="kt_wrapper">

                    <!-- begin:: Header -->
                    <?php if ( $index_top_menu ) echo $index_top_menu ;?>
                    <!-- end:: Header -->

                    <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
                        <?php flash_output('notification'); ?>
                        <?php if ( $middle ) echo $middle ;?>
                    </div>

                    <!-- begin:: Footer -->
                    <?php if ( $index_footer ) echo $index_footer ;?>
                    <!-- end:: Footer -->
                </div>
            </div>
        </div>

        <!-- end:: Page -->

        

        <!-- begin::Scrolltop -->
        <div id="kt_scrolltop" class="kt-scrolltop">
            <i class="fa fa-arrow-up"></i>
        </div>
        <!-- end::Scrolltop -->

        
    </body>

    <!-- end::Body -->
</html>