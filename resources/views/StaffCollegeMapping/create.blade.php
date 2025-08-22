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
							<h5 class="mb-4">GAT NAYAK STAFF MAPPING</h5>
							<form class="row" action="" method="GET">
								@csrf

								<div class="col-md-3">
									<label for="staff_name" class="form-label">Staff Name<font color="red"><b>*</b></font></label>
									<select class="form-select single-select-clear-field" name="staff_profile_id"
										data-placeholder="Select staff" required>
										<option></option>
										@foreach($staffProfiles as $key => $value)
											<option value="{{$key}}" {{ count($staffProfiles) == 1 ? 'selected' : '' }}>{{$value}}</option>
										@endforeach
									</select>
								</div>

								<div class="col-md-6">
									<label for="college_name" class="form-label">College<font color="red"><b>*</b></font></label>
									<select class="form-select single-select-clear-field" name="college_name"
										data-placeholder="Select College" required >
										<option></option>
										@foreach($duColleges as $key => $value)
											<option value="{{$value}}" {{ $college_name==$value?'selected':'' }}>{{$value}}</option>
										@endforeach
									</select>
								</div>

								<div class="col-md-3 d-flex align-items-end justify-content-start">
									<div>
										<button type="submit" class="btn btn-primary px-4 me-2">Find</button>
										<button type="button" onclick="window.location='{{url($current_menu)}}'" class="btn btn-light px-4">Cancel</button>
									</div>
								</div>

							</form>
						</div>
							<div class="card-body p-4 mt-0">
								@if(!empty($data) && !$data->isEmpty())
									<div class="table-responsive">
										<form action="{{ route('StaffCollegeMapping.store') }}" method="POST">
												@csrf
										<table class="table table-bordered table-striped" id="example3">
											<thead>
												<tr>
													<th>S.No</th>
													<th style="text-align: center;">
														Staff Name
													<p><input type="checkbox" name="" id="checkAll" onclick="checkall_function(this);"> check all</p> 	
												</th>
													<th style="text-align: center;">Department</th>
												</tr>
											</thead>
											
											<tbody>
												@php $i = 1; @endphp
												@foreach($data as $item)
													@php
														$full_name = !empty($item->name)?$item->name:'';
														$department = !empty($item->department)?$item->department:'';
													@endphp
													<tr>
														<td style="width:6%;">{{ $i++ }}</td>
														<td>
														<input type="checkbox" name="staff_id[]" id="" value="{{ $item->id }}"  {{ in_array($item->id, $exist) ? 'checked' : '' }} style="width:18px; height: 18px;">
														{{ $full_name }}</td>
														<td>{{ $department}}</td>
													</tr>
												@endforeach
											</tbody>
										</table>
													<input type="hidden" name="college_name" value="{{ $college_name }}">
													<input type="hidden" name="staff_profile_id" value="{{ $staff_profile_id }}">
													<button type="submit" class="btn btn-primary px-4 me-2" style="float:right;">Submit</button>
											</form>
									</div>
								@else
								@if(!empty($staff_profile_id))
									<div class="alert-danger" style="text-align: center;">
										No staff records found.
									</div>
									@endif
								@endif
							</div>
					</div>
				</div>
			</div>

@endsection

		<script>
			function checkall_function(ele) {
			var checkboxes = document.getElementsByTagName('input');
			if (ele.checked) {
				for (var i = 0; i < checkboxes.length; i++) {
					if (checkboxes[i].type == 'checkbox') {
						checkboxes[i].checked = true;
					}
				}
			} else {
				for (var i = 0; i < checkboxes.length; i++) {
					console.log(i)
					if (checkboxes[i].type == 'checkbox') {
						checkboxes[i].checked = false;
					}
				}
			}
		}
		</script>