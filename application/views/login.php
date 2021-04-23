<!DOCTYPE html>

<!--
Template Name: Metronic - Responsive Admin Dashboard Template build with Twitter Bootstrap 4 & Angular 8
Author: KeenThemes
Website: http://www.keenthemes.com/
Contact: support@keenthemes.com
Follow: www.twitter.com/keenthemes
Dribbble: www.dribbble.com/keenthemes
Like: www.facebook.com/keenthemes
Purchase: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes
Renew Support: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes
License: You must have a valid license purchased only from themeforest(the above link) in order to legally use the theme for your project.
-->
<html lang="en">

	<!-- begin::Head -->
	<head>
		<base href="../../../">
		<meta charset="utf-8" />
		<title>Trio Tortoises | Login Page</title>
		<meta name="description" content="Login page">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<!--begin::Fonts -->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700|Roboto:300,400,500,600,700">

		<!--end::Fonts -->

		<!--begin::Page Custom Styles(used by this page) -->
		<link href="<?=base_url();?>assets/css/pages/login/login-3.css" rel="stylesheet" type="text/css" />

		<!--end::Page Custom Styles -->

		<!--begin::Global Theme Styles(used by all pages) -->
		<link href="<?=base_url();?>assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
		<link href="<?=base_url();?>assets/css/style.bundle.css" rel="stylesheet" type="text/css" />

		<!--end::Global Theme Styles -->

		<!--begin::Layout Skins(used by all pages) -->

		<!--end::Layout Skins -->
		<link rel="shortcut icon" href="<?=base_url();?>assets/media/trio_small.png" />

		<!--begin::Custom CSS -->
		<style>

		.kt-login.kt-login--v3 .kt-login__wrapper .kt-login__container .kt-login__logo
		{
			margin: 0 auto 10px auto;
		}

		.kt-login.kt-login--v3 .kt-login__wrapper .kt-login__container .kt-login__head
		{
			margin-bottom: 1rem;
		}

		.kt-login.kt-login--v3 .kt-login__wrapper .kt-login__container .kt-form .form-control
		{
			height: 35px;
		}

		.kt-login.kt-login--v3 .kt-login__wrapper .kt-login__container .kt-form .kt-login__extra
		{
			margin-top: 15px;
		}

		.kt-login__companyname
		{
			margin: 0 auto 20px auto;
			text-align: center;
			color: #ddad4b;
			font-weight:bold;
		}

		.kt-login__signin
		{
			border: 1px solid #ffffff;
			border-radius: 4px;
			background: #fdfdfd;
			box-shadow: 0px 4px 16px 0px rgba(162, 162, 162, 0.15);
			padding: 10px 15px;
		}

		.kt-login__forgot
		{
			border: 1px solid #ffffff;
			border-radius: 4px;
			background: #fdfdfd;
			box-shadow: 0px 4px 16px 0px rgba(162, 162, 162, 0.15);
			padding: 10px 15px;
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

		.bootstrap-select.form-control
		{
			padding: 0 !important;
			margin-bottom: 0 !important;
		}

		.alert
		{
			padding: 2px 6px !important;
			margin: 0 !important;
		}

		</style>
		<!--end::Custom CSS -->

	</head>

	<!-- end::Head -->

	<!-- begin::Body -->
	<body class="kt-quick-panel--right kt-demo-panel--right kt-offcanvas-panel--right kt-header--fixed kt-header-mobile--fixed kt-subheader--enabled kt-subheader--solid kt-aside--enabled kt-aside--fixed kt-aside--minimize kt-page--loading">

		<!-- begin:: Page -->
		<div class="kt-grid kt-grid--ver kt-grid--root kt-page">
			<div class="kt-grid kt-grid--hor kt-grid--root  kt-login kt-login--v3 kt-login--signin" id="kt_login">
				<div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" style="background-image: url(<?=base_url();?>assets/media/custom/login-bg.jpg);">
					<div class="kt-grid__item kt-grid__item--fluid kt-login__wrapper">
						<div class="kt-login__container">
							<div class="kt-login__logo">
								<a href="<?=site_url('login');?>">
									<img src="<?=base_url();?>assets/media/trio_.png">
								</a>
							</div>
							<!-- <div class="kt-login__companyname">
								<h3>STAR GLORY ASIA (M) SDN BHD</h3>
							</div> -->
							<div class="kt-login__signin">
								<div class="kt-login__head">
									<h3 class="kt-login__title">Login</h3>
									<h3 class="kt-login__title">Administrator System</h3>
								</div>
                        		<?php flash_output('login_result'); ?>
								<form class="kt-form" action="<?=site_url('login-submit')?>" method="POST">
									<div class="input-group">
										<input class="form-control form-control-sm" type="text" id="user_name" name="user_name" placeholder="Username" autocomplete="off" />
									</div>
									<div class="input-group">
										<input class="form-control form-control-sm" type="password" id="user_password" name="user_password" placeholder="Password" />
									</div>
									<div class="row kt-login__extra">
										<!-- <div class="col">
											<label class="kt-checkbox">
												<input type="checkbox" id="remember" name="remember" value="1"> Remember me
												<span></span>
											</label>
										</div> -->
										<!-- <div class="col kt-align-right">
											<a href="javascript:;" id="kt_login_forgot" class="kt-login__link">Forget Password ?</a>
										</div> -->
									</div>
									<div class="kt-login__actions">
										<button class="btn btn-custom btn-elevate btn-sm" type="submit" id="btn_submit" name="btn_submit"><center>Login</center></button>
									</div>
								</form>
							</div>
							<div class="kt-login__forgot">
								<div class="kt-login__head">
									<h3 class="kt-login__title">Forgotten Password ?</h3>
									<div class="kt-login__desc">Enter your email to reset your password:</div>
								</div>
								<form class="kt-form" action="<?=site_url('forgot-password')?>" method="POST">
									<div class="input-group">
										<input class="form-control form-control-sm" type="text" placeholder="Email" name="fp_email" id="fp_email" autocomplete="off">
									</div>
									<div class="kt-login__actions">
										<button id="kt_login_forgot_submit" class="btn btn-brand btn-elevate btn-sm">Request</button>&nbsp;&nbsp;
										<button id="kt_login_forgot_cancel" class="btn btn-light btn-elevate btn-sm">Cancel</button>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- end:: Page -->

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
		<script src="<?=base_url();?>assets/plugins/global/plugins.bundle.js" type="text/javascript"></script>
		<script src="<?=base_url();?>assets/js/scripts.bundle.js" type="text/javascript"></script>

		<!--end::Global Theme Bundle --> 

		<!--begin::Page Scripts(used by this page) -->
		<script src="<?=base_url();?>assets/js/pages/custom/login/login-general.js" type="text/javascript"></script>

		<!-- Source: https://developer.snapappointments.com/bootstrap-select/ -->
		<script src="<?=base_url();?>assets/js/pages/crud/forms/widgets/bootstrap-select.js" type="text/javascript"></script>

		<!--end::Page Scripts -->
	</body>

	<!-- end::Body -->
</html>