<head>
	<!-- <base href="../../"> -->
	<meta charset="utf-8" />
	<title>Trio Tortoises</title>
	<meta name="description" content="Static table examples">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<!--begin::Fonts -->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700|Roboto:300,400,500,600,700">

	<!--end::Fonts -->

	<!--begin::Page Vendors Styles(used by this page) -->
	<link href="<?=base_url()?>assets/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />
	
	<!--end::Page Vendors Styles -->

	<!--begin::Global Theme Styles(used by all pages) -->
	<link href="<?=base_url()?>assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
	<link href="<?=base_url()?>assets/css/style.bundle.css" rel="stylesheet" type="text/css" />

	<!--end::Global Theme Styles -->

	<!--begin::Layout Skins(used by all pages) -->

	<!--end::Layout Skins -->
    <link rel="shortcut icon" href="<?=base_url();?>assets/media/trio_small.png" />

	<!--begin::Custom CSS -->
	<style>
		
		.kt-header__topbar .kt-header__topbar-item.kt-header__topbar-item--user .kt-header__topbar-wrapper .kt-header__topbar-icon
		{
			background-color: #ddad4b !important;
		}

		.kt-header__brand
		{
			background-color: transparent !important;
		}

		.kt-subheader-search
		{
			background: #ddad4b !important;
			padding: 8px 0 !important;
			margin-bottom: 10px !important;
		}

		.kt-subheader-search .kt-subheader-search__desc
		{
			color: #000000;
		}

		.btn-custom
		{
			background-color: #ddad4b;
			border-color: #ddad4b;
			color: #ffffff;
			width: 100%; 
			font-weight:bold;
			font-size: 12px;
			text-align: right;
		}

		.btn-delete
		{
			background: #fd517f;
			color: #ffffff;
		}

		.kt-font-dangerous {
		    color: #fd517f !important;
		}

		.bootstrap-select.form-control
		{
			padding: 0 !important;
			margin-bottom: 0 !important;
		}

		.bootstrap-select > .dropdown-toggle
		{
			padding: 0.5rem 1rem !important;
		}

		.form-group.row .kt-radio-inline
		{
			margin-top: 0.5rem !important;
		}

		/* start datatable custom sm */

		.table-responsive.table-responsive-custom
		{
			padding-bottom: 25px !important;
		}

		.data_table_server, .datatable-custom
		{
			font-size: 0.875rem;
		}

		.data_table_server > thead, .datatable-custom > thead, .table-custom > thead
		{
			background-color: #f9f6f6;
		}

		.data_table_server > thead > tr > th, .data_table_server > tbody > tr > td
		{
			padding: 5px 10px;
		}

		.datatable-custom > thead > tr > th, .datatable-custom > tbody > tr > td
		{
			padding: 5px 10px;
		}

		.table-custom > thead > tr > th, .table-custom > tbody > tr > td
		{
			padding: 5px 10px;
		}

		div.dataTables_wrapper div.dataTables_info
		{
			padding-top: 0.1rem;
			font-size: 0.875rem;
		}

		.dataTables_wrapper .dataTables_paginate .pagination .page-item > .page-link
		{
			height: 1.8rem;
			padding: 0;
			font-size: 0.875rem;
		}

		.dataTables_wrapper .dataTable th.sorting_desc:before, .dataTables_wrapper .dataTable th.sorting_desc:after, .dataTables_wrapper .dataTable th.orting_asc_disabled:before, .dataTables_wrapper .dataTable th.orting_asc_disabled:after, .dataTables_wrapper .dataTable th.orting_desc_disabled:before, .dataTables_wrapper .dataTable th.orting_desc_disabled:after, .dataTables_wrapper .dataTable th.sorting_asc:before, .dataTables_wrapper .dataTable th.sorting_asc:after, .dataTables_wrapper .dataTable th.sorting:before, .dataTables_wrapper .dataTable th.sorting:after, .dataTables_wrapper .dataTable td.sorting_desc:before, .dataTables_wrapper .dataTable td.sorting_desc:after, .dataTables_wrapper .dataTable td.orting_asc_disabled:before, .dataTables_wrapper .dataTable td.orting_asc_disabled:after, .dataTables_wrapper .dataTable td.orting_desc_disabled:before, .dataTables_wrapper .dataTable td.orting_desc_disabled:after, .dataTables_wrapper .dataTable td.sorting_asc:before, .dataTables_wrapper .dataTable td.sorting_asc:after, .dataTables_wrapper .dataTable td.sorting:before, .dataTables_wrapper .dataTable td.sorting:after
		{
			bottom: 0.50rem !important;
		}

		/* end datatable custom sm */

		/* start custom color project theme */
		.theme-color-text
		{
			color: #ddad4b;
		}

		.theme-color-bg
		{
			background: #ddad4b;
		}

		.theme-color-btn
		{
			background: #ddad4b;
			color: #ffffff;
			font-weight: bold;
		}	
		/* end custom color project theme */

		/* start custom breadcrum */

		ul.breadcrumb {
			padding: 10px 16px;
			list-style: none;
			background-color: white;
		}
		ul.breadcrumb li {
			display: inline;
			font-size: 12px;
		}
		ul.breadcrumb li+li:before {
			padding: 8px;
			color: black;
			content: "\003E ";
		}
		ul.breadcrumb li a {
			color: #0275d8;
			text-decoration: none;
		}
		ul.breadcrumb li a:hover {
			color: #01447e;
			text-decoration: underline;
		}

		/* end custom breadcrum */

	</style>
	<!--end::Custom CSS -->

	<!-- begin::Global Config(global config for global JS sciprts) -->
	<script>
		var KTAppOptions = {
			"colors": {
				"state": {
					"brand": "#22b9ff",
					"light": "#ffffff",
					"dark": "#282a3c",
					"primary": "#5867dd",
					"success": "#34bfa3",
					"info": "#36a3f7",
					"warning": "#ffb822",
					"danger": "#fd3995"
				},
				"base": {
					"label": ["#c5cbe3", "#a1a8c3", "#3d4465", "#3e4466"],
					"shape": ["#f0f3ff", "#d9dffa", "#afb4d4", "#646c9a"]
				}
			}
		};
	</script>
	<!-- end::Global Config -->

	<!--begin::Global Theme Bundle(used by all pages) -->
	<script src="<?=base_url()?>assets/plugins/global/plugins.bundle.js" type="text/javascript"></script>
	<script src="<?=base_url()?>assets/js/scripts.bundle.js" type="text/javascript"></script>

	<!--end::Global Theme Bundle -->

	<!--begin::Page Vendors(used by this page) -->
	<script src="<?=base_url()?>assets/plugins/custom/datatables/datatables.bundle.js" type="text/javascript"></script>

	<!--end::Page Vendors -->

	<!--begin::Page Scripts(used by this page) -->

	<!-- Source: https://developer.snapappointments.com/bootstrap-select/ -->
	<!-- <script src="<?=base_url();?>assets/js/pages/crud/forms/widgets/bootstrap-select.js" type="text/javascript"></script> -->

	<!--end::Page Scripts -->

	<!--begin::Page Custom Scripts (used by custom page) -->
	<script type="text/javascript">
		
		function get_random_id()
		{
		    // var char_length = '10';
		    var result = '';
		    // var characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
		    // var charactersLength = characters.length;
		    // for ( var i = 0; i < char_length; i++ ) 
		    // {
		    //     result += characters.charAt(Math.floor(Math.random() * charactersLength));
		    // }
		    result = ( Math.round(Math.round(+new Date()) * Math.random()) ); 
		    return result;
		}

		function loading_on()
		{
			$('.loading_cloone').show();
		}

		function loading_off()
		{
			$('.loading_cloone').hide();
		}

		$(function(){
		    
		    // turn field value to uppercase
		    $('.turn_uppercase').keyup( function(e){
		        $(this).val($(this).val().toUpperCase());
		    });

		});

	</script>

	<!--end::Page Custom Scripts -->

</head>