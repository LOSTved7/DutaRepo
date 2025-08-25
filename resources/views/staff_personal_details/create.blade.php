@extends('layouts.header')

@section('title')
	CREATE STAFF
@endsection

@section('content')
	<div class="page-wrapper">
		<div class="page-content">
			<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
			</div>
			<div class="row">
				<div class="col-xl-12 mx-auto">
					<div class="card">
						<div class="card-body p-4">
							<div class="row">
								<div class="col-md-5 mt-2">
									<h3 class="mb-4">ADD PERSONAL DETAILS</h3>
								</div>
								<div class="col-md-3">
								</div>
								<div class="col-md-3">
									<span for="contact_no" class="form-label">Find By Contact No.</span>
									<input type="text" name="" id="contact_no_search" class="form-control"
										placeholder="Enter Contact no." maxlength="50"
										oninput="this.value = this.value.replace(/\D/g, '').slice(0, 10)">
								</div>
								<div class="col-md-1">
									<button type="button" class="btn btn-primary mt-4"
										onclick="find_by_contact_no()">search</button>
								</div>
							</div>
							<form class="row g-3" action="{{ route($current_menu . '.store') }}" method="POST">
								@csrf
								<div class="box-body">
									<div class="form-group row">
										@php
											if (Auth::user()->role_id == 60) {
												$duColleges_mast = $college_mapped;
											}
										@endphp
										<div class="col-md-4">
											<label for="college_id" class="form-label">College<font color="red"><b>*</b>
												</font></label>
											<select class="form-control single-select-clear-field" name="college_name"
												id="college_name" required data-placeholder="Select College">
												<option></option>
												@foreach($duColleges_mast as $key => $value)
													<option value="{{$key}}">{{$value}}</option>
												@endforeach
											</select>
										</div>

										<div class="col-md-4">
											<label class="form-label">Staff Name<font color="red"><b>*</b></font></label>
											<input type="text" name="name" id="name" class="form-control"
												placeholder="Enter Staff Name" maxlength="50" required>
										</div>


										<div class="col-md-4  mt-2">
											<label class="form-label">Department</label>
											<select name="department" id="department"
												class="form-select single-select-clear-field"
												data-placeholder="select Department" maxlength="100">
												<option></option>
												@foreach($department as $dept)
													<option value="{{ $dept }}">{{ $dept }}</option>
												@endforeach
											</select>
										</div>
										<div class="col-md-4 mt-2">
											<label class="form-label">Email</label>
											<input type="email" name="email1" id="email1" class="form-control" placeholder="Enter Email"
												maxlength="100">
										</div>
										<div class="col-md-4 mt-2">
											<label class="form-label">Contact No</label>
											<input type="text" name="contact_no" id="contact_no" class="form-control"
												placeholder="Enter Contact No." maxlength="10"
												oninput="this.value = this.value.replace(/[^0-9]/g, '');">
										</div>

										<div class="col-md-4 mt-2">
											<label for="status" class="form-label">Status</label>
											<select class="form-select single-select-clear-field" name="status">
												<option value="1">Active</option>
												<option value="2">Inactive</option>
											</select>
										</div>

									</div>
								</div>

								<div class="col-md-12">
									<button type="button" onclick="window.location='{{ url($current_menu) }}'"
										class="btn btn-light px-4">Cancel</button>
									<button type="submit" style="float: right;" class="btn btn-primary px-4"
										id="button">Submit</button>
								</div>
							</form>

						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

@endsection
<style>
	.note-text {
		color: #b30000;
		font-size: 14px;
		font-style: italic;
		margin-bottom: 15px;
	}

	.contact-group {
		margin-bottom: 20px;
	}

	.label-row {
		display: flex;
		justify-content: space-between;
		align-items: center;
		margin-bottom: 5px;
	}

	.label-row .form-label {
		margin-bottom: 0;
		font-weight: 600;
	}

	.form-check-label {
		margin-left: 4px;
		font-weight: normal;
	}
</style>



<script>
	
	function find_by_contact_no() {
		var contact_no_search = document.getElementById('contact_no_search').value;

		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
		$.ajax({
			type: 'POST',
			url: '{{ route('find_staff_personal_detail_by_contact_no') }}',
			data: {
				contact_no: contact_no_search,
				'_token': '{{ csrf_token() }}'
			},
			success: function (data) {
				console.log(data);
				if (data.id !== undefined) {
					$('#college_name').val(data.college_name || '').trigger('change');
					// setTimeout(function () {
						$('#department').val(data.department || '').trigger('change');
					// }, 2000);
					$('#name').val(data.name);
					$('#email1').val(data.email || '');
					$('#contact_no').val(data.mobile || '');
					$('#status').val(data.status || '').trigger('change');

				}
			}
		});
	}
</script>