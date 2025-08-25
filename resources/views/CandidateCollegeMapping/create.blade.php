@extends('layouts.header')

@section('title')
Staff College Mapping
@endsection

@section('content')
		<!--start page wrapper -->
		<div class="page-wrapper">
			<div class="page-content">
				<!--breadcrumb-->
				<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
				
				</div>
				<!--end breadcrumb-->
				<div class="row">
					<div class="col-xl-12 mx-auto">
						
						<div class="card">
							<div class="card-body p-4">
								<h5 class="mb-4">CANDIDATE COLLEGE MAPPING</h5>
					<form class="row g-3" action="{{route($current_menu.'.store')}}" method="POST" enctype="multipart/form-data">
						@csrf
						<div class="col-md-3">
						   <label for="single-select-clear-field" class="form-label">Staff Name<font color="red"><b>*</b></font></label>
						   <select class="form-select single-select-clear-field" name="staff_profile_id"  data-placeholder="Select staff" required>
							<option></option>
							   @foreach($staffProfiles as $key => $value)
								   <option value="{{$key}}">{{$value}}</option>
							   @endforeach

							</select>
						</div>
								<div class="col-md-6">
									<label for="single-select-clear-field" class="form-label">College<font color="red"><b>*</b></font></label>
									<select class="form-select single-select-clear-field" name="college_name[]" multiple  data-placeholder="Select College" required>
							<option></option>
										@foreach($duColleges as $key => $value)
										    <option value="{{$key}}">{{$value}}</option>
										@endforeach
									 </select>
								 </div>
                               <div class="col-md-3">
									<label for="single-select-clear-field" class="form-label">Status<font color="red"><b>*</b></font></label>
									 <select class="form-select single-select-clear-field" name="status"  data-placeholder="Choose Status" required>
										 
										<option value="1">Active</option>
										<option value="2">Inactive</option>
									</select>
								</div>
								<div class="col-md-12">
											
									<button type="button" onclick="window.location='{{url($current_menu)}}'"  class="btn btn-light px-4">Cancel</button>
													
									<button type="submit" style="float: right;" class="btn btn-primary px-4">Submit</button>
								</div>
					</form>
					</div>
				</div>
			</div>
		</div>
				
@endsection