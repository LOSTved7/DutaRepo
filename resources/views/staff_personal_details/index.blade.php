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
				@php
					$total_records = count($data);
					$total_mobile_no_count =0;
					$total_email_count =0;
					$unique_count = [];
					foreach($data as $staff){
						if(!empty($staff->mobile)){
							$total_mobile_no_count++;
						}
						if(!empty($staff->email)){
							$total_email_count++;
						}
						if(empty($unique_count[$staff->mobile])){
							$unique_count[$staff->mobile] = 1;
						}else{
						$unique_count[$staff->mobile] +=1 ;
						}
					}
					//dd($data,$total_mobile_no_count,$total_email_count);
					@endphp
					<h3	>CANDIDATE MAPPINGS</h3>
					{{--<div class="mx-auto text-end">
						<h6 class="d-inline-block ms-3" style="color:blue;">Total Result: <span style="color:red;"> {{ $total_records }}</span></h6>
						<h6 class="d-inline-block ms-3" style="color:blue;">Contact: <span style="color:red;">{{ $total_mobile_no_count }}</span></h6>
						<h6 class="d-inline-block ms-3" style="color:blue;">Emails: <span style="color:red;">{{ $total_email_count }}</span></h6>
					</div>--}}
					<div class="ms-auto">
					
						<div class="btn-group">
							<a href="{{ url($current_menu.'/create') }}" class="btn btn-primary">Add Personal Details</a>
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
							  	<option></option>
							 	@foreach($duColleges as $key => $value);
								<option value="{{$value}}" {{  Request::get('college_name') == $value ? 'selected' : '' }}> {{ !empty($duColleges_mast[$value])?$duColleges_mast[$value]:''}}</option>
								@endforeach 
						 	</select>
					 	</div>
{{--
						<div class="col-md-3">
							<label class="form-label">Department</label>
							<select name="department" id="department" class="form-select single-select-clear-field" data-placeholder="Select Department" maxlength="100" onchange="get_staff_by_department(this);">
								<option></option>
								@foreach($department_mast as $key => $value)
									<option value="{{ $value }}" {{ old('department', request('department')) == $value ? 'selected' : '' }}>{{ $value }}</option>
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
						</div>--}}
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
								<th>Name</th>
								<th>Mobile No</th>
								<th>Email</th>
								<th>Department</th>
								@if(Auth::user()->role_id == '59')
								<th>Created By</th>
								@endif
								<th>Count</th>
							{{--	<th>Action</th>--}}
							</tr>
						</thead>
						<tbody>
							@php $i = 1;
							$unique = [];
							 @endphp
							@foreach ($data as $staff)
							@if(!in_array($staff->mobile,$unique))
							
							@php
								$encrypt_id = Crypt::encryptString($staff->id);
							@endphp
								<tr>
									<td>{{ $i++ }}</td>
									<td>{{ !empty($duColleges_mast[$staff->college_name])?$duColleges_mast[$staff->college_name]:''}}</td>
									<td>{{ !empty($staff->name)?$staff->name:''}}</td>
									<td>{{ !empty($staff->mobile)?$staff->mobile:''}}</td>
									<td>{{ !empty($staff->email)?$staff->email:''}}</td>
									<td>{{ !empty($staff->department)?$staff->department:''}}</td>
								@if(Auth::user()->role_id ==59)
									<td>{{ !empty($user_profile[$staff->created_by])?$user_profile[$staff->created_by]:''}}</td>
								@endif

									{{--<td>
										<a href="{{ url($current_menu.'/'.$encrypt_id.'/edit') }}" class="btn btn-sm btn-warning">Edit</a>
										<form action="{{ route($current_menu.'.destroy', $encrypt_id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure you want to delete this staff member?');">
											@csrf
											@method('DELETE')
											<button type="submit" class="btn btn-sm btn-danger">Delete</button>
										</form>
									</td>--}}
									<td>{{ !empty($unique_count[$staff->mobile])?$unique_count[$staff->mobile]:'' }}</td>
								
								</tr>
								@endif
								@php
							$unique[] = $staff->mobile;
							@endphp
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