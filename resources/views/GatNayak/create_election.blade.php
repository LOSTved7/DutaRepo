@extends('layouts.header')

@section('title')
User
@endsection

@section('content')
		<!--start page wrapper -->
		<div class="page-wrapper">
			<div class="page-content">
				<!--breadcrumb-->
				<!--end breadcrumb-->
				<div class="row">
					<div class="col-xl-12 mx-auto">
						@php
						@endphp
						<div class="card">
							<div class="card-body p-4">
								<div class="row">
									<div class="col-md-3 mt-2">
										<h4 class="">ADD GAT NAYAK</h4>
									</div>
									<div class="col-md-5">
									</div>
									<div class="col-md-3">
										<span for="contact_no" class="form-label">Find By Contact No.</span>
										<input type="text" name="" id="contact_no_search" class="form-control" placeholder="Enter Contact no." maxlength="50" oninput="this.value = this.value.replace(/\D/g, '').slice(0, 10)">
									</div>
									<div class="col-md-1">
										<button type="button" class="btn btn-primary mt-4" onclick="find_by_contact_no()">search</button>
									</div>
								</div>
								<form class="row g-3" action="{{route($current_menu.'.store')}}" method="POST" enctype="multipart/form-data">
										@csrf
								<div class="row g-3">
									  <div class="col-md-4">
									    <label for="college_name" class="form-label">College<font color="red"><b>*</b></font></label>
									    <select class="form-select single-select-clear-field" name="college_name" id="college_name" required data-placeholder="Select College">
									      <option></option>
									      @foreach($duColleges as $key => $value)
									        <option value="{{ $key }}">{{ $value }}</option>
									      @endforeach
									    </select>
									  </div>

									  <div class="col-md-4">
									    <label for="department" class="form-label">Department</label>
									    <select class="form-select single-select-clear-field" name="department" id="department"  data-placeholder="Select Department">
									      <option></option>
									      @foreach($department_mast as $key => $value)
									        <option value="{{ $value }}">{{ $value }}</option>
									      @endforeach
									    </select>
									  </div>

									  <div class="col-md-4">
									    <label for="first_name" class="form-label">Full Name<font color="red"><b>*</b></font></label>
									    <input type="text" name="fullname" id="fullname" class="form-control" placeholder="Enter First Name" maxlength="50" required>
									  </div>
{{--
									  <div class="col-md-3">
									    <label for="middle_name" class="form-label">Middle Name</label>
									    <input type="text" name="middle_name" id="middle_name" class="form-control" placeholder="Enter Middle Name" maxlength="50">
									  </div>

									  <div class="col-md-3">
									    <label for="last_name" class="form-label">Last Name<font color="red"><b>*</b></font></label>
									    <input type="text" name="last_name" id="last_name" class="form-control" placeholder="Enter Last Name" maxlength="50" required>
									  </div>

									  <!-- Row 3: Employment Type + Contact + Email -->
									  <div class="col-md-3">
									    <label for="employment_type" class="form-label">Employment Type<font color="red"><b>*</b></font></label>
									    <select class="form-select single-select-clear-field" name="employment_type" id="employment_type" required>
									      <option value="">Select</option>
									      <option value="Permanent">Permanent</option>
									      <option value="Adhoc">Adhoc</option>
									      <option value="Temp">Temp</option>
									    </select>
									  </div>
--}}
									  <div class="col-md-4">
									    <label for="contact_no" class="form-label">Contact No.<font color="red"><b>*</b></font></label>
									    <input type="text" name="contact_no" id="contact_no" class="form-control" placeholder="Enter Contact" maxlength="50" required oninput="this.value = this.value.replace(/\D/g, '').slice(0, 10)">
									  </div>

									 {{-- <div class="col-md-3">
									    <label for="salutation" class="form-label">Gender<font color="red"><b>*</b></font></label>
									    <select name="gender" id="gender" class="form-select single-select-clear-field" required>
									      <option value="">Select</option>
									      <option value="1">Male</option>
									      <option value="2">Female</option>
									    </select>
									  </div>
									  <div class="col-md-3">
									    <label for="email" class="form-label">Email<font color="red"><b>*</b></font></label>
									    <input type="text" name="email" id="email" class="form-control" placeholder="Enter Email" maxlength="50" required>
									  </div>

									  <!-- Row 4: Grade + Sangathan + Status -->
									  <div class="col-md-3">
									    <label for="grade" class="form-label">Grade<font color="red"><b>*</b></font></label>
									    <select name="grade" id="grade" class="form-select single-select-clear-field" required>
									      <option value="">Select</option>
									      <option value="A">A</option>
									      <option value="B">B</option>
									      <option value="C">C </option>
									      <option value="D">D</option>
									    </select>
									  </div>

									  <div class="col-md-3">
									    <label for="sangathan" class="form-label">Sangathan<font color="red"><b>*</b></font></label>
									    <select name="sangathan" id="sangathan" class="form-select single-select-clear-field" required>
									      <option value="">Select</option>
									      <option value="RSS">RSS</option>
									      <option value="ABVP">ABVP</option>
									      <option value="Other">Other</option>
									    </select>
									  </div>--}}

									  <div class="col-md-2">
									    <label for="status" class="form-label">Status<font color="red"><b>*</b></font></label>
									    <select class="form-select single-select-clear-field" name="status" id="status" required>
									      <option value="1">Active</option>
									      <option value="2">Inactive</option>
									    </select>
									  </div>

									{{--  <!-- Row 5: Comments -->
									  <div class="col-md-4">
									    <label for="comments" class="form-label">Comments</label>
									    <textarea name="comments" id="comments" class="form-control" rows="2" placeholder="Enter comments if any..."></textarea>
									  </div>--}}

									</div>


								<div class="col-md-12"style="margin-top: 10px;">
									<button type="button" onclick="window.location='{{url($current_menu)}}'"class="btn btn-light px-4">Cancel</button>
									<button type="submit" style="float: right;" class="btn btn-primary px-4">Submit</button>
								</div>
				</form>
			</div>
		</div>
	</div>	
</div>
@endsection

@section('js')
<script type="text/javascript">
	  jQuery(function ($) {        
      $('form').bind('submit', function () {
        // console.log('1');
        $(this).find('select').prop('disabled', false);
        // alert(1);
      });
    });
function find_by_contact_no(){
	var contact_no_search = document.getElementById('contact_no_search').value;

	$.ajaxSetup({
			    headers: {
			        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			    }
			});
		$.ajax({
			type: 'POST',
			url: '{{ route('find_staff_by_contact_no') }}',
			data: {
				contact_no: contact_no_search,
				'_token' : '{{ csrf_token() }}'
			},
			success: function(data){
					console.log(data);
					$('#college_name').val(data.college_name || '').trigger('change');
					$('#department').val(data.department || '').trigger('change');
					$('#fullname').val(data.name || '');
					$('#contact_no').val(data.mobile_no1 || '');
					
			}
		});
}
</script>
@endsection