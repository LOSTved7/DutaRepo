@extends('layouts.header')

@section('title')
STAFF DETAILS
@endsection

@section('content')
<div class="page-wrapper">
	<div class="page-content">
		<div class="card">
			<div class="card-body">
				<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
					<h3>STAFF/GRADE</h3>
					<div class="ms-auto">
						<div class="btn-group">
							<a href="{{ route('staff_upload') }}" class="btn btn-warning">Upload</a>
						</div>
						<div class="btn-group">
							<a href="{{ url($current_menu.'/create') }}" class="btn btn-primary">Add</a>
						</div>
					</div>
				</div>
				@php
				if (Auth::user()->role_id==60){
				$duColleges =$staff_college_mapping;}
				@endphp
					<form action="" method="GET">
						@csrf
						<div class="row">
					 	<div class="col-md-3">
							<label for="single-select-clear-field" class="form-label">College</label>
						 	<select class="form-select single-select-clear-field" name="college_name" id="college_name"  data-placeholder="Select College" onchange="get_staff_by_college(this);">
							  	<option value=""> </option>
							 	@foreach($duColleges as $value);
								<option value="{{$value}}" {{ old('college_name', request('college_name')) == $value ? 'selected' : '' }}> {{ $value}}</option>
								@endforeach 
						 	</select>
					 	</div>
						<div class="col-md-3">
							<label class="form-label">Department</label>
							<select name="department" id="department" class="form-select single-select-clear-field" data-placeholder="Select Department" maxlength="100" onchange="get_staff_by_department(this);">
								<option></option>
								@foreach($department_mast as $key => $value)
									<option value="{{ $value }}" {{ old('department', request('department')) == $value ? 'selected' : '' }}>{{ $value }}</option>
								@endforeach
							</select>
						</div>
						<div class="col-md-3">
							<label class="form-label">Designation</label>
							<select name="designation" id="designation" class="form-select single-select-clear-field" data-placeholder="select Designation" maxlength="100" onclick="get_staff_by_designation(this);">
								<option></option>
								@foreach($designation_mast as $key => $value)
									<option value="{{ $value }}" {{ old('designation', request('designation')) == $value ? 'selected' : '' }}>{{ $value }}</option>
								@endforeach
							</select>
						</div> 

						<div class="col-md-2">
							<label class="form-label">Grade</label>
							<select class="form-select single-select-clear-field" name="grade" data-placeholder="Select Grade">
								<option ></option>
								<option value="A" {{ old('grade', request('grade')) == 'A' ? 'selected' : '' }}>A</option>
								<option value="B" {{ old('grade', request('grade')) == 'B' ? 'selected' : '' }}>B</option>
								<option value="C" {{ old('grade', request('grade')) == 'C' ? 'selected' : '' }}>C</option>
								<option value="D" {{ old('grade', request('grade')) == 'D' ? 'selected' : '' }}>D</option>
							</select>
						</div>
						<div class="col-md-1" style="margin-top:25px; display:flex; " >

					    <input style="margin:3px" type="submit" class="btn btn-primary px-4" value="Find">
					</div>
				</div>
				</form>
				<div class="card-body">
				<div class="table-responsive">
					<table id="example2" class="table table-striped table-bordered">
						<thead>
							<tr>
								<th>S.No.</th>
								<th>College Name</th>
								<th>College Code</th>
								<th>Name</th>
								<th>Mobile No</th>
								<th>Email</th>
								<th>Department</th>
								<th>Designation</th>
								@if(Auth::user()->role_id == '59')
								<th>Created By</th>
								@endif
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							@php $i = 1; @endphp
							@foreach ($data as $staff)
							@php
								$encrypt_id = Crypt::encryptString($staff->id);
							@endphp
								<tr>
									<td>{{ $i++ }}</td>
									<td>{{ !empty($staff->college_name)?$staff->college_name:''}}</td>
									<td>{{ !empty($staff->college_code)?$staff->college_code:''}}</td>
									<td>{{ !empty($staff->name)?$staff->name:''}}</td>
									<td>{{ !empty($staff->mobile_no1)?$staff->mobile_no1:''}}</td>
									<td>{{ !empty($staff->email1)?$staff->email1:''}}</td>
									<td>{{ !empty($staff->department)?$staff->department:''}}</td>
									<td>{{ !empty($staff->designation)?$staff->designation:''}}</td>
								@if(Auth::user()->role_id ==59)
									<td>{{ !empty($user_profile[$staff->created_by])?$user_profile[$staff->created_by]:''}}</td>
								@endif
									<td>
										<a href="{{ url($current_menu.'/'.$encrypt_id.'/edit') }}" class="btn btn-sm btn-warning">Edit</a>
										<form action="{{ route($current_menu.'.destroy', $encrypt_id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure you want to delete this staff member?');">
											@csrf
											@method('DELETE')
											<button type="submit" class="btn btn-sm btn-danger">Delete</button>
										</form>
									</td>
								
								</tr>
							@endforeach

							@if ($data->isEmpty())
								<tr>
									@if(Auth::user()->role_id == '59')
										<td colspan="10" class="text-center">No staff records found.</td>
									@else
										<td colspan="9" class="text-center">No staff records found.</td>
									@endif
								</tr>
							@endif
						</tbody>
					</table>
				</div>
			</div>
		</div>

	</div>
</div>
<!--end page wrapper -->
@endsection

@section('js')
<script>
	function get_staff_by_college(element){
		var college_name = element.value;
		var department_selected = document.getElementById('department').value;
		var designation_selected = document.getElementById('designation').value;
		$.ajaxSetup({
			    headers: {
			        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			    }
			});
		$.ajax({
			type: 'POST',
			url: '{{ route('get_staff_by_college') }}',
			data: {
				college_name: college_name,
				department: department_selected,
				designation: designation_selected,
				'_token' : '{{ csrf_token() }}'
			},
			success: function(data){
				let department = data.department;
				let designation = data.designation;
				$('#department').empty();
				$('#department').append('<option></option>')
					$.each(department, function(key, value){
						let selected = (department_selected == value) ? 'selected' : '';
						$('#department').append('<option value="'+value+'"'+selected+'>'+value+'</option>');
					});
				$('#designation').empty();
				$('#designation').append('<option></option>')
					$.each(designation, function(key, value){
						let selected = (designation_selected === value) ? 'selected' : '';
						$('#designation').append('<option value="'+value+'"'+selected+'>'+value+'</option>');
					});
				}
			});

	}
	function get_staff_by_department(element){
		var department = element.value;
		var college_name_selected = document.getElementById('college_name').value;
		var designation_selected = document.getElementById('designation').value;
		$.ajaxSetup({
			    headers: {
			        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			    }
			});
		$.ajax({
			type: 'POST',
			url: '{{ route('get_staff_by_department') }}',
			data: {
				department: department,
				college_name: college_name_selected,
				designation: designation_selected,
				'_token' : '{{ csrf_token() }}'
			},
			success: function(data){
				let college_name = data.college_name;
				let designation = data.designation;
				console.log(designation);
				$('#college_name').empty();
				$('#college_name').append('<option></option>')
					$.each(college_name, function(key, value){
						let selected = (college_name_selected == value) ? 'selected' : '';
						$('#college_name').append('<option value="'+value+'"'+selected+'>'+value+'</option>');
					});
				$('#designation').empty();
				$('#designation').append('<option></option>')
					$.each(designation, function(key, value){
						let selected = (designation_selected === value) ? 'selected' : '';
						$('#designation').append('<option value="'+value+'"'+selected+'>'+value+'</option>');
					});
				}
			});

	}
	function get_staff_by_designation(element){
		var designation = element.value;
		var college_name_selected = document.getElementById('college_name').value;
		var department_selected = document.getElementById('department').value;
		$.ajaxSetup({
			    headers: {
			        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			    }
			});
		$.ajax({
			type: 'POST',
			url: '{{ route('get_staff_by_designation') }}',
			data: {
				designation:designation,
				department: department_selected,
				college_name: college_name_selected,
				'_token' : '{{ csrf_token() }}'
			},
			success: function(data){
				let college_name = data.college_name;
				let department = data.department;
				$('#college_name').empty();
				$('#college_name').append('<option></option>')
					$.each(college_name, function(key, value){
						let selected = (college_name_selected == value) ? 'selected' : '';
						$('#college_name').append('<option value="'+value+'"'+selected+'>'+value+'</option>');
					});
				$('#department').empty();
				$('#department').append('<option></option>')
					$.each(department, function(key, value){
						let selected = (department_selected == value) ? 'selected' : '';
						$('#department').append('<option value="'+value+'"'+selected+'>'+value+'</option>');
					});
				}
			});

	}
</script>

@endsection