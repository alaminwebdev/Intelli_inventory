<footer class="main-footer shadow-sm">
	<strong>
		Copyright &copy; {{ (@$site_setting->copy_right_year != date('Y'))?((@$site_setting->copy_right_year)?(@$site_setting->copy_right_year.' - '.date('Y')):''):(date('Y')) }}
		<a target="_blank" href="{{@$site_setting->copy_right_org_link?@$site_setting->copy_right_org_link:'#'}}">{{(@$site_setting->name)?(@$site_setting->name):'Project Name'}}</a>
		All rights reserved.
	</strong>
	<div class="float-right d-none d-sm-inline-block">
		@if(@$site_setting->version)
		<b>Version</b> {{@$site_setting->version}}
		@endif
	</div>
</footer>