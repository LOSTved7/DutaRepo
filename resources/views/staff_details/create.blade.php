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
									<div class="col-md-3 mt-2">
										<h3 class="mb-4">ADD STAFF</h3>
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
						<form class="row g-3" action="{{ route($current_menu.'.store') }}" method="POST" onsubmit="return validateWhatsAppSelection();">
							@csrf
							<input type="hidden" name="id" id="id">
							<div class="box-body">
								<div class="form-group row">
									@php
									if(Auth::user()->role_id==60){
										$duColleges = $college_mapped;
									}
									@endphp
									<div class="col-md-4">
										<label for="college_id" class="form-label">College/Faculties<font color="red"><b>*</b></font></label>
										<select class="form-control single-select-clear-field" name="college_name" id="college_name" required data-placeholder="Select College" onchange="get_staff_by_college(this);">
										<option></option>
										@foreach($duColleges as $key => $value)
										    <option value="{{$value}}" >{{$value}}</option>
										@endforeach
									 </select>
									</div>

									<div class="col-md-4">
										<label class="form-label">Staff Name<font color="red"><b>*</b></font></label>
										<input type="text" name="name" id="name" class="form-control" placeholder="Enter Staff Name" maxlength="50" required>
									</div>
									
									
									
									<div class="col-md-4 mt-2">
										<label class="form-label">Department</label>
										<select name="department" id="department" class="form-select single-select-clear-field" data-placeholder="Select Department" maxlength="100">
											<option></option>
										</select>
										
									</div>
									
									<div class="col-md-4  mt-2">
										<label class="form-label">Designation</label>
										<select name="designation" id="designation" class="form-select single-select-clear-field" data-placeholder="select Designation" maxlength="100">
											<option></option>
										</select>
									</div>
									<div class="col-md-4 mt-2">
										<label class="form-label">Email</label>
										<input type="email" name="email1" class="form-control" placeholder="Enter Email" maxlength="100">
									</div>
									<div class="col-md-4 mt-2">
										<label class="form-label">Email 2</label>
										<input type="email" name="email2" class="form-control" placeholder="Enter Email" maxlength="100">
									</div>
									<p class="note-text mt-4">Please check the box next to the contact number that is your <strong>WhatsApp number</strong>.</p>

									<div class="row">
										<div class="col-md-4 contact-group">
											<div class="label-row">
												<label for="mobile_no1" class="form-label">
													Contact no. <span class="text-danger">*</span>
												</label>
												<div>
													<input type="checkbox" name="whatsapp" id="whatsapp1" onclick="setWhatsApp(this, 'mobile_no1')">
													<label for="whatsapp1" class="form-check-label">WhatsApp</label>
												</div>
											</div>
											<input type="text" name="mobile_no1" id="mobile_no1" class="form-control" placeholder="Enter Contact no." maxlength="10" required onkeyup="validateMobileNumber(this)">
											<small id="mobileError1" class="text-danger d-none">Please enter a valid 10-digit Contact no.</small>
										</div>

										<div class="col-md-4 contact-group">
											<div class="label-row">
												<label for="mobile_no2" class="form-label">Contact no. 2</label>
												<div>
													<input type="checkbox" name="whatsapp" id="whatsapp2" onclick="setWhatsApp(this, 'mobile_no2')">
													<label for="whatsapp2" class="form-check-label">WhatsApp</label>
												</div>
											</div>
											<input type="text" name="mobile_no2" id="mobile_no2" class="form-control" placeholder="Enter Contact no." maxlength="10" onkeyup="validateMobileNumber(this)">
											<small id="mobileError2" class="text-danger d-none">Please enter a valid 10-digit Contact no.</small>
										</div>

										<div class="col-md-4 contact-group">
											<div class="label-row">
												<label for="mobile_no3" class="form-label">Contact no. 3</label>
												<div>
													<input type="checkbox" name="whatsapp" id="whatsapp3" onclick="setWhatsApp(this, 'mobile_no3')">
													<label for="whatsapp3" class="form-check-label">WhatsApp</label>
												</div>
											</div>
											<input type="text" name="mobile_no3" id="mobile_no3" class="form-control" placeholder="Enter Contact no." maxlength="10" onkeyup="validateMobileNumber(this)">
											<small id="mobileError3" class="text-danger d-none">Please enter a valid 10-digit Contact no.</small>
										</div>
									</div>
									{{--<div class="col-md-4 mt-2">
										<label class="form-label">Grade</label>
										<select class="form-select single-select-clear-field" name="grade" id="grade" data-placeholder="Select Grade">
											<option ></option>
											<option value="A">A</option>
											<option value="B">B</option>
											<option value="C">C</option>
											<option value="D">D</option>
										</select>
									</div>--}}
										<div class="col-md-4 mt-2">
										<label class="form-label">College Code</label>
										<input type="text" name="college_code" id="college_code" class="form-control" placeholder="Enter College code" maxlength="50">
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
								<button type="button" onclick="window.location='{{ url($current_menu) }}'" class="btn btn-light px-4">Cancel</button>
								<button type="submit" style="float: right;" class="btn btn-primary px-4" id="button">Submit</button>
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
function validateMobileNumber(element) {
    const mobileRegex = /^[0-9]{10}$/;
    const inputs = [
        document.getElementById('mobile_no1'),
        document.getElementById('mobile_no2'),
        document.getElementById('mobile_no3')
    ];

    const currentValue = element.value.trim();
    const errorElement = document.getElementById('mobileError' + element.id.slice(-1));

    // Format check
    if (!mobileRegex.test(currentValue)) {
        showError(element, errorElement, "Please enter a valid 10-digit Contact no.");
        return;
    }

    // Duplicate check
    for (let input of inputs) {
        if (input !== element && input.value.trim() === currentValue) {
            showError(element, errorElement, "This number is already entered in another field.");
            element.value = "";
            return;
        }
    }

    hideError(element, errorElement);
}

function showError(element, errorElement, message) {
    errorElement.textContent = message;
    errorElement.classList.remove('d-none');
    element.classList.add('is-invalid');
}

function hideError(element, errorElement) {
    errorElement.classList.add('d-none');
    element.classList.remove('is-invalid');
}

// Optional: Allow only one WhatsApp checkbox to be selected
function setWhatsApp(checkbox, inputId) {
    const allCheckboxes = document.querySelectorAll('input[name="whatsapp"]');
    allCheckboxes.forEach(cb => {
        if (cb !== checkbox) cb.checked = false;
    });

    // Optionally, set the checkbox value as the associated phone number
    checkbox.value = document.getElementById(inputId).value;
}

function get_staff_by_college(element){
		var college_name = element.value;
		var current_url = 'staff_details_create';
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
				current_url: current_url,
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
</script>




<script>
function validateWhatsAppSelection() {
    const whatsappCheckboxes = document.querySelectorAll('input[name="whatsapp"]');
    let atLeastOneChecked = false;
	console.log(whatsappCheckboxes);
    whatsappCheckboxes.forEach(cb => {
        if (cb.checked && cb.value) atLeastOneChecked = true;
    });

    if (!atLeastOneChecked) {
        alert("Please select at least one WhatsApp number With Correct Value");
        return false; // Prevent form submission
    }

    return true; // Allow form submission
}

function find_by_contact_no(){
	var contact_no_search = document.getElementById('contact_no_search').value;
	var duColleges = <?php echo(json_encode($duColleges)) ?>;

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
					if(data.id !== undefined){
					$('#college_name').val(data.college_name || '').trigger('change');
					setTimeout(function() {
						$('#department').val(data.department || '').trigger('change');
						$('#designation').val(data.designation || '').trigger('change');
					}, 2000);
					$('#name').val(data.name);
					$('#mobile_no1').val(data.mobile_no1 || '');
					$('#mobile_no2').val(data.mobile_no2 || '');
					$('#mobile_no3').val(data.mobile_no3 || '');
					$('#mobile_no3').val(data.mobile_no3 || '');
					$('#college_code').val(data.college_code || '');
					$('#email1').val(data.email1 || '');
					$('#email2').val(data.email2 || '');
					console.log(data.whatsapp);
					if(data.whatsapp!=='' && data.whatsapp !==undefined){
						if(data.whatsapp==data.mobile_no1){
							$('#whatsapp1').val(data.mobile_no1);
							$('#whatsapp1').prop('checked', true);
						}else if(data.whatsapp==data.mobile_no2){
							$('#whatsapp2').val(data.mobile_no2);
							$('#whatsapp1').prop('checked', true);
						}else if(data.whatsapp==data.mobile_no3){
							$('#whatsapp3').val(data.mobile_no3);
							$('#whatsapp1').prop('checked', true);
						}
					}
					$('#grade').val(data.grade || '').trigger('change');
					$('#status').val(data.status || '').trigger('change');
					$('#id').val(data.id || '');
					document.getElementById('button').innerHTML = 'Update';

				}
			}
		});
}
</script>