<style>

.kt-content 
{
    padding: 0; 
}
.kt-error_container
{
	padding: 10px 40px;
}
.kt-error_code
{
	font-size: 10rem;
	font-weight: bold;
}
.kt-error_title, .kt-error_subtitle, .kt-error_description, .kt-error_redirect
{
	font-size: 1rem;
}

</style>

<!-- begin:: Page -->
<div class="kt-grid kt-grid--ver kt-grid--root kt-page">
	<div class="kt-grid__item kt-grid__item--fluid kt-grid kt-error-v3" style="background-color: #f9f9fc;">
		<div class="kt-error_container">
			<span class="kt-error_number">
				<h1 class="kt-error_code">404</h1>
			</span>
			<!-- 
			<p class="kt-error_title">
				How did you get here
			</p> 
			-->
			<p class="kt-error_subtitle">
				Sorry we can't seem to find the page you're looking for.
			</p>
			<p class="kt-error_description">
				There may be amisspelling in the URL entered,<br>
				or the page you are looking for may no longer exist.
			</p>
			<p class="kt-error_redirect">
				Click <a href="<?=site_url('dashboard');?>">here</a> to go back.
			</p>
		</div>
	</div>
</div>

<!-- end:: Page -->