<?php
defined('BASEPATH') or exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'Start_Controller';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

/*----------  LOGIN  ----------*/
$route['login'] = 'Start_Controller/login';
$route['login-submit'] = 'Start_Controller/login_submit';
$route['logout'] = 'Start_Controller/logout';
$route['forgot-password'] = 'Start_Controller/forgot_password';

/*----------  DASHBOARD  ----------*/
$route['dashboard'] = 'Start_Controller/index';

/*----------  Profile  ----------*/
$route['profile']                 = 'Profile_Controller/index'; // form (modal) + list
$route['profile/update']         = 'Profile_Controller/update';
$route['profile/details']        = 'Profile_Controller/details';
$route['profile/save']             = 'Profile_Controller/save';
$route['profile/password']         = 'Profile_Controller/password';
$route['profile/change-password']     = 'Profile_Controller/change_password';

/*----------  Others  ----------*/

$route['member']                 = 'Member_Controller/index'; // form (modal) + list
$route['member/list']             = 'Member_Controller/list1'; // get list from datatable
$route['member/create']         = 'Member_Controller/create';
$route['member/insert']         = 'Member_Controller/insert';
$route['member/view']             = 'Member_Controller/view';
$route['member/update']         = 'Member_Controller/update';
$route['member/details']        = 'Member_Controller/details';
$route['member/delete']         = 'Member_Controller/delete';

$route['notification']             = 'Notification_Controller/index'; // form (modal) + list
$route['notification/list']     = 'Notification_Controller/list1'; // get list from datatable
$route['notification/create']     = 'Notification_Controller/create';
$route['notification/insert']     = 'Notification_Controller/insert';
$route['notification/update']     = 'Notification_Controller/update';
$route['notification/details']    = 'Notification_Controller/details';
$route['notification/delete']     = 'Notification_Controller/delete';

$route['store-locator']         = 'Store_Location_Controller/index'; // form (modal) + list
$route['store-location/list']     = 'Store_Location_Controller/list1'; // get list from datatable
$route['store-location/insert'] = 'Store_Location_Controller/insert';
$route['store-location/create'] = 'Store_Location_Controller/create';
$route['store-location/view']     = 'Store_Location_Controller/view';
$route['store-location/details'] = 'Store_Location_Controller/details';
$route['store-location/update'] = 'Store_Location_Controller/update';
$route['store-location/delete'] = 'Store_Location_Controller/delete';

/*----------  Voucher  ----------*/
$path_voucher = 'voucher/';

$route['birthday_voucher/birthday']   = $path_voucher . 'Birthday_voucher_Controller/index';
$route['birthday_voucher/create']     = $path_voucher . 'Birthday_voucher_Controller/create';
$route['birthday_voucher/insert']     = $path_voucher . 'Birthday_voucher_Controller/insert';
$route['birthday_voucher/update']       = $path_voucher . 'Birthday_voucher_Controller/update';
$route['birthday_voucher/list']       = $path_voucher . 'Birthday_voucher_Controller/list1'; // get list from datatable
$route['birthday_voucher/details']       = $path_voucher . 'Birthday_voucher_Controller/details';
$route['birthday_voucher/delete']       = $path_voucher . 'Birthday_voucher_Controller/delete';

$route['voucher']         = $path_voucher . 'Voucher_Controller/index'; // form (modal) + list
$route['voucher/list']             = $path_voucher . 'Voucher_Controller/list1'; // get list from datatable
$route['voucher/create']         = $path_voucher . 'Voucher_Controller/create';
$route['voucher/insert']         = $path_voucher . 'Voucher_Controller/insert';
$route['voucher/update']         = $path_voucher . 'Voucher_Controller/update';
$route['voucher/details']        = $path_voucher . 'Voucher_Controller/details';
$route['voucher/delete']         = $path_voucher . 'Voucher_Controller/delete';

/*----------  Reports  ----------*/
$path_report = 'report/';

$route['report/master-voucher']     = $path_report . 'Report_Controller/master_voucher'; // list
$route['report/master-voucher-list'] = $path_report . 'Report_Controller/master_voucher_list'; // get list from datatable
$route['voucher_export']            = $path_report . 'Report_Controller/master_voucher_export';

$route['report/master-point']         = $path_report . 'Report_Controller/master_point'; // list
$route['report/master-point-list']     = $path_report . 'Report_Controller/master_point_list'; // get list from datatable
$route['point_export']                 = $path_report . 'Report_Controller/master_point_export';

$route['report/member-sales']         = $path_report . 'Report_Controller/member_sales'; // list
$route['report/member-sales-list']     = $path_report . 'Report_Controller/member_sales_list'; // get list from datatable
$route['sales_export']                 = $path_report . 'Report_Controller/master_sales_export';

$route['report/master-member']         = $path_report . 'Report_Controller/master_member'; // list
$route['report/master-member-list'] = $path_report . 'Report_Controller/master_member_list'; // get list from datatable
$route['member_export']                 = $path_report . 'Report_Controller/master_member_export';

/*----------  CMS  ----------*/

$path_cms = 'cms/';

$route['home-screen']             = $path_cms . 'Screen_Controller/index'; // form
$route['home-screen/list']         = $path_cms . 'Screen_Controller/list1';
$route['home-screen/create']     = $path_cms . 'Screen_Controller/create';
$route['home-screen/insert']     = $path_cms . 'Screen_Controller/insert';
$route['home-screen/update']     = $path_cms . 'Screen_Controller/update';
$route['home-screen/delete']    = $path_cms . 'Screen_Controller/delete';
$route['home-screen/details']    = $path_cms . 'Screen_Controller/details';

$route['promotion']             = $path_cms . 'Promotion_Controller/index'; // form (modal) + list
$route['promotion/list']         = $path_cms . 'Promotion_Controller/list1'; // get list from datatable
$route['promotion/create']         = $path_cms . 'Promotion_Controller/create';
$route['promotion/insert']         = $path_cms . 'Promotion_Controller/insert';
$route['promotion/update']         = $path_cms . 'Promotion_Controller/update';
$route['promotion/details']        = $path_cms . 'Promotion_Controller/details';
$route['promotion/delete']         = $path_cms . 'Promotion_Controller/delete';

$route['snews']                 = $path_cms . 'News_Controller/index'; // form (modal) + list
$route['snews/list']             = $path_cms . 'News_Controller/list1'; // get list from datatable
$route['snews/create']             = $path_cms . 'News_Controller/create';
$route['snews/insert']             = $path_cms . 'News_Controller/insert';
$route['snews/update']             = $path_cms . 'News_Controller/update';
$route['snews/details']            = $path_cms . 'News_Controller/details';
$route['snews/delete']             = $path_cms . 'News_Controller/delete';

$route['about-us']                 = $path_cms . 'About_Controller/index'; // form
$route['about-us/details']         = $path_cms . 'About_Controller/details';
$route['about-us/update']         = $path_cms . 'About_Controller/update';

$route['post']             = $path_cms . 'Post_Controller/index'; // form (modal) + list
$route['post/list']       = $path_cms . 'Post_Controller/list1'; // get list from datatable
$route['post/update']     = $path_cms . 'Post_Controller/update';
$route['post/details']    = $path_cms . 'Post_Controller/details';
$route['post/delete']     = $path_cms . 'Post_Controller/delete';

$route['faq']           = $path_cms . 'Faq_Controller/index';
$route['faq/details']     = $path_cms . 'Faq_Controller/details';
$route['faq/update']     = $path_cms . 'Faq_Controller/update';

/*----------  SETTINGS  ----------*/

$path_settings = 'settings/';

$route['user']             = $path_settings . 'User_Controller/index'; // form (modal) + list
$route['user/list']       = $path_settings . 'User_Controller/list1'; // get list from datatable
$route['user/save']     = $path_settings . 'User_Controller/save';
$route['user/create']     = $path_settings . 'User_Controller/create';
$route['user/update']     = $path_settings . 'User_Controller/update';
$route['user/details']    = $path_settings . 'User_Controller/details';
$route['user/view']     = $path_settings . 'User_Controller/view';
$route['user/delete']     = $path_settings . 'User_Controller/delete';

$route['promotion-category']             = $path_settings . 'Promotion_Category_Controller/index'; // form (modal) + list
$route['promotion-category/list']       = $path_settings . 'Promotion_Category_Controller/list1'; // get list from datatable
$route['promotion-category/create']     = $path_settings . 'Promotion_Category_Controller/create';
$route['promotion-category/details']    = $path_settings . 'Promotion_Category_Controller/details';
$route['promotion-category/insert']        = $path_settings . 'Promotion_Category_Controller/insert';
$route['promotion-category/update']        = $path_settings . 'Promotion_Category_Controller/update';
$route['promotion-category/delete']     = $path_settings . 'Promotion_Category_Controller/delete';