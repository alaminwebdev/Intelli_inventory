@extends('member.layouts.app')
@section('content')
<section class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-3">
				<div class="card card-primary card-outline">
					<div class="card-body box-profile">
						<div class="text-center">
							<img class="profile-user-img img-fluid img-circle" src="{{fileExist(['url'=>@$profile->image,'type'=>'profile'])}}" alt="{{@$profile->name}}">
						</div>
						<h3 class="profile-username text-center">{{@$profile->name}}</h3>
						<a href="{{ route('member.profile-management.profile-info.update') }}" class="btn btn-primary btn-block"><b>Edit</b></a>
					</div>
				</div>
			</div>
			<div class="col-md-9">
				<div class="card">
					<div class="card-body">
						<fieldset class="border p-3">
							<legend  class="w-auto pl-2 pr-2">Personal Information</legend>
							<div class="row">
								<label class="col-sm-2">Name</label>
								<div class="col-sm-10">
									<span>{{@$profile->name ?? 'N/A'}}</span>
								</div>
							</div>
							<div class="row">
								<label class="col-sm-2">Email</label>
								<div class="col-sm-10">
									<span>{{@$profile->email ?? 'N/A'}}</span>
								</div>
							</div>
							<div class="row">
								<label class="col-sm-2">Mobile No</label>
								<div class="col-sm-10">
									<span>{{@$profile->mobile_no ?? 'N/A'}}</span>
								</div>
							</div>
							<div class="row">
								<label class="col-sm-2">Designation</label>
								<div class="col-sm-10">
									<span>{{@$profile->designation->name ?? 'N/A'}}</span>
								</div>
							</div>
							<div class="row">
								<label class="col-sm-2">Working Place</label>
								<div class="col-sm-10">
									<span>{{@$profile->working_place ?? 'N/A'}}</span>
								</div>
							</div>
						</fieldset>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
@endsection