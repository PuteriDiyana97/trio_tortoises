<?php

// pre($access_module['roles']);
// pre($this->session->user_type );
// die();
?>
<div class="kt-aside-menu-wrapper kt-grid__item kt-grid__item--fluid" id="kt_aside_menu_wrapper">
    <div id="kt_aside_menu" class="kt-aside-menu " data-ktmenu-vertical="1" data-ktmenu-scroll="1"
        data-ktmenu-dropdown-timeout="500">
        <ul class="kt-menu__nav ">

            <li class="kt-menu__item " aria-haspopup="true">
                <a href="<?= site_url('dashboard'); ?>" class="kt-menu__link ">
                    <i class="kt-menu__link-icon flaticon2-protection"></i>
                    <span class="kt-menu__link-text">Dashboard</span>
                </a>
            </li>
            <?php if (isset($access_module['roles'][4]) > 0 ||  ($this->session->user_type  == 1 ||  ($this->session->user_type  == 2))) { ?>
            <li class="kt-menu__item " aria-haspopup="true">
                <a href="<?= site_url('member'); ?>" class="kt-menu__link ">
                    <i class="kt-menu__link-icon flaticon-customer"></i>
                    <span class="kt-menu__link-text">Member</span>
                </a>
            </li>
            <?php } ?>
            <?php if (isset($access_module['roles'][5]) > 0 ||  ($this->session->user_type  == 1 ||  ($this->session->user_type  == 2))) { ?>
            <li class="kt-menu__item " aria-haspopup="true">
                <a href="javascript:;" class="kt-menu__link kt-menu__toggle">
                    <i class="kt-menu__link-icon flaticon-shopping-basket"></i>
                    <span class="kt-menu__link-text">Voucher</span>
                    <i class="kt-menu__ver-arrow la la-angle-right"></i>
                </a>
                <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                    <ul class="kt-menu__subnav">
                        <li class="kt-menu__item " aria-haspopup="true">
                            <a href="<?= site_url('birthday_voucher/birthday'); ?>" class="kt-menu__link ">
                                <i class="kt-menu__link-icon flaticon-gift"></i>
                                <span class="kt-menu__link-text">Birthday Voucher</span>
                            </a>
                        </li>
                        <li class="kt-menu__item " aria-haspopup="true">
                            <a href="<?= site_url('voucher'); ?>" class="kt-menu__link ">
                                <i class="kt-menu__link-icon fas fa-ticket-alt"></i>
                                <span class="kt-menu__link-text">Regular Voucher</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <?php } ?>
            <?php if (isset($access_module['roles'][5]) > 0 ||  ($this->session->user_type  == 1 ||  ($this->session->user_type  == 2))) { ?>
            <li class="kt-menu__item " aria-haspopup="true">
                <a href="<?= site_url('notification'); ?>" class="kt-menu__link ">
                    <i class="kt-menu__link-icon flaticon-bell"></i>
                    <span class="kt-menu__link-text">Notification</span>
                </a>
            </li>
            <?php } ?>
            <?php if (isset($access_module['roles'][5]) > 0 ||  ($this->session->user_type  == 1 ||  ($this->session->user_type  == 2))) { ?>
            <li class="kt-menu__item " aria-haspopup="true">
                <a href="<?= site_url('store-locator'); ?>" class="kt-menu__link ">
                    <i class="kt-menu__link-icon    flaticon-placeholder-1"></i>
                    <span class="kt-menu__link-text">Store Locator</span>
                </a>
            </li>
            <?php } ?>
            <?php if (isset($access_module['roles'][7]) > 0 ||  ($this->session->user_type  == 1 ||  ($this->session->user_type  == 2))) { ?>
            <li class="kt-menu__item kt-menu__item--submenu" aria-haspopup="true" data-ktmenu-submenu-toggle="hover">
                <a href="javascript:;" class="kt-menu__link kt-menu__toggle">
                    <i class="kt-menu__link-icon flaticon-graphic"></i>
                    <span class="kt-menu__link-text">Report</span>
                    <i class="kt-menu__ver-arrow la la-angle-right"></i>
                </a>
                <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                    <ul class="kt-menu__subnav">
                        <li class="kt-menu__item " aria-haspopup="true">
                            <a href="<?= site_url('report/master-member'); ?>" class="kt-menu__link ">
                                <i class="kt-menu__link-icon flaticon-graphic"></i>
                                <span class="kt-menu__link-text">Master Member</span>
                            </a>
                        </li>
                        <li class="kt-menu__item " aria-haspopup="true">
                            <a href="<?= site_url('report/master-point'); ?>" class="kt-menu__link ">
                                <i class="kt-menu__link-icon flaticon-graphic"></i>
                                <span class="kt-menu__link-text">Master Point</span>
                            </a>
                        </li>
                        <li class="kt-menu__item " aria-haspopup="true">
                            <a href="<?= site_url('report/member-sales'); ?>" class="kt-menu__link ">
                                <i class="kt-menu__link-icon flaticon-graphic"></i>
                                <span class="kt-menu__link-text">Master Sales</span>
                            </a>
                        </li>
                        <li class="kt-menu__item " aria-haspopup="true">
                            <a href="<?= site_url('report/master-voucher'); ?>" class="kt-menu__link ">
                                <i class="kt-menu__link-icon flaticon-graphic"></i>
                                <span class="kt-menu__link-text">Master Voucher</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <?php } ?>
            <?php if (isset($access_module['roles'][6]) > 0 ||  ($this->session->user_type  == 1) ||  ($this->session->user_type  == 2)) { ?>
            <li class="kt-menu__item kt-menu__item--submenu" aria-haspopup="true" data-ktmenu-submenu-toggle="hover">
                <a href="javascript:;" class="kt-menu__link kt-menu__toggle">
                    <i class="kt-menu__link-icon flaticon2-document"></i>
                    <span class="kt-menu__link-text">CMS</span>
                    <i class="kt-menu__ver-arrow la la-angle-right"></i>
                </a>
                <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                    <ul class="kt-menu__subnav">
                        <li class="kt-menu__item " aria-haspopup="true">
                            <a href="<?= site_url('home-screen'); ?>" class="kt-menu__link ">
                                <i class="kt-menu__link-icon flaticon2-shelter"></i>
                                <span class="kt-menu__link-text">Home Screen</span>
                            </a>
                        </li>
                        <li class="kt-menu__item " aria-haspopup="true">
                            <a href="<?= site_url('promotion'); ?>" class="kt-menu__link ">
                                <i class="kt-menu__link-icon flaticon2-tag"></i>
                                <span class="kt-menu__link-text">Promotion</span>
                            </a>
                        </li>
                        <li class="kt-menu__item " aria-haspopup="true">
                            <a href="<?= site_url('promotion-category'); ?>" class="kt-menu__link ">
                                <i class="kt-menu__link-icon flaticon2-menu-3"></i>
                                <span class="kt-menu__link-text">Promotion Category</span>
                            </a>
                        </li>
                        <li class="kt-menu__item " aria-haspopup="true">
                            <a href="<?= site_url('snews'); ?>" class="kt-menu__link ">
                                <i class="kt-menu__link-icon flaticon2-bell-5"></i>
                                <span class="kt-menu__link-text">News</span>
                            </a>
                        </li>
                        <li class="kt-menu__item " aria-haspopup="true">
                            <a href="<?= site_url('about-us'); ?>" class="kt-menu__link ">
                                <i class="kt-menu__link-icon flaticon-information"></i>
                                <span class="kt-menu__link-text">About Us</span>
                            </a>
                        </li>
                        <li class="kt-menu__item " aria-haspopup="true">
                            <a href="<?= site_url('faq'); ?>" class="kt-menu__link ">
                                <i class="kt-menu__link-icon flaticon-questions-circular-button"></i>
                                <span class="kt-menu__link-text">FAQ</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <?php } ?>
            <?php if (isset($access_module['roles'][2]) > 0 ||  ($this->session->user_type  == 1) ||  ($this->session->user_type  == 2)) { ?>
            <li class="kt-menu__item kt-menu__item--submenu" aria-haspopup="true" data-ktmenu-submenu-toggle="hover">
                <a href="javascript:;" class="kt-menu__link kt-menu__toggle">
                    <i class="kt-menu__link-icon fas fa-user-cog"></i>
                    <span class="kt-menu__link-text">Settings</span>
                    <!-- <span class="kt-menu__link-badge"><span class="kt-badge kt-badge--brand">2</span></span> -->
                    <i class="kt-menu__ver-arrow la la-angle-right"></i>
                </a>
                <div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                    <ul class="kt-menu__subnav">
                        <li class="kt-menu__item " aria-haspopup="true">
                            <a href="<?= site_url('user'); ?>" class="kt-menu__link ">
                                <!-- <i class="kt-menu__link-bullet kt-menu__link-bullet--line"><span></span></i> -->
                                <i class="kt-menu__link-icon flaticon2-writing"></i>
                                <span class="kt-menu__link-text">User</span>
                            </a>
                        </li>

                    </ul>
                </div>
            </li>
            <?php } ?>
        </ul>
    </div>
</div>