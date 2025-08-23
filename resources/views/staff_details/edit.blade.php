@extends('layouts.header')

@section('title')
Edit Staff
@endsection

@section('content')
<div class="page-wrapper">
	<div class="page-content">
		<div class="row">
			<div class="col-xl-12 mx-auto">
				<div class="card">
					<div class="card-body p-4">
						<h5 class="mb-4">Edit Staff Detail</h5>

						<form class="row g-3" action="{{ route($current_menu.'.update', $encrypted_id) }}" method="POST"  onsubmit="return validateWhatsAppSelection();">
							@csrf
							@method('PUT')
							<div class="box-body">
								<div class="form-group row">

									<div class="col-md-4">
										<label for="college_id" class="form-label">College<font color="red"><b>*</b></font></label>
										<select class="form-select single-select-clear-field" name="college_name" id="college_name" required data-placeholder="Select College Name">
											<option></option>
											@foreach ($duColleges as $value )
											<option value="{{ $value }}" {{$data->college_name==$value?'selected':''}}>{{ $value }}</option>
											@endforeach
											</select>
									</div>

									<div class="col-md-4">
										<label class="form-label">Staff Name<font color="red"><b>*</b></font></label>
										<input type="text" name="name" class="form-control" value="{{ !empty($data->name)?$data->name:'' }}" required>
									</div>
									
									<div class="col-md-4 mt-2">
										<label class="form-label">Department</label>
										<select class="form-select single-select-clear-field" name="department" data-placeholder="Enter Department" maxlength="100" >
											<option></option>
											@foreach ($department_data as $value )
											<option value="{{ $value }}" {{ $data->department==$value?'selected':'' }}>{{ $value }}</option>
											
											@endforeach
											</select>
										
									</div>
									
								<div class="col-md-4  mt-2">
										<label class="form-label">Designation</label>
										<select name="designation" class="form-select single-select-clear-field" data-placeholder="select Designation" maxlength="100">
											<option></option>
											@foreach ($designation_data as $value )
											<option value="{{ $value }}" {{ $data->designation==$value?'selected':'' }}>{{ $value }}</option>
											
											@endforeach
											</select>
										
									</div>
									<div class="col-md-4 mt-2">
										<label class="form-label">Email</label>
										<input type="email" name="email1" class="form-control" value="{{ !empty($data->email1)?$data->email1:'' }}" placeholder="Enter Email">
									</div>
									
									<div class="col-md-4 mt-2">
										<label class="form-label">Email 2</label>
										<input type="email" name="email2" class="form-control" value="{{ !empty($data->email2)?$data->email2:'' }}" placeholder="Enter Email">
									</div>
									
									<p class="note-text mt-4">Please check the box next to the contact number that is your <strong>WhatsApp number</strong>.</p>

									<div class="row">
										<div class="col-md-4 contact-group">
											<div class="label-row">
												<label for="mobile_no1" class="form-label">
													Contact no. <span class="text-danger">*</span>
												</label>
												<div>
													<input type="checkbox" name="whatsapp" id="whatsapp1" onclick="setWhatsApp(this, 'mobile_no1')" @if(!empty($data->mobile_no1) && $data->whatsapp==$data->mobile_no1) checked value="{{ $data->mobile_no1 }}" @endif>
													<label for="whatsapp1" class="form-check-label">WhatsApp</label>
												</div>
											</div>
											<input type="text" name="mobile_no1" id="mobile_no1" value="{{ $data->mobile_no1 }}" class="form-control" placeholder="Enter Contact no." maxlength="10" required onkeyup="validateMobileNumber(this)">
											<small id="mobileError1" class="text-danger d-none">Please enter a valid 10-digit Contact no.</small>
										</div>
										<div class="col-md-4 contact-group">
											<div class="label-row">
												<label for="mobile_no2" class="form-label">Contact no. 2</label>
												<div>
													<input type="checkbox" name="whatsapp" id="whatsapp2" onclick="setWhatsApp(this, 'mobile_no2')" @if(!empty($data->mobile_no2) && $data->whatsapp==$data->mobile_no2) checked value="{{ $data->mobile_no2 }}" @endif>
													<label for="whatsapp2" class="form-check-label">WhatsApp</label>
												</div>
											</div>
											<input type="text" name="mobile_no2" id="mobile_no2" value="{{ $data->mobile_no2 }}" class="form-control" placeholder="Enter Contact no." maxlength="10" onkeyup="validateMobileNumber(this)">
											<small id="mobileError2" class="text-danger d-none">Please enter a valid 10-digit Contact no.</small>
										</div>
										<div class="col-md-4 contact-group">
											<div class="label-row">
												<label for="mobile_no3" class="form-label">Contact no. 3</label>
												<div>
													<input type="checkbox" name="whatsapp" id="whatsapp3" onclick="setWhatsApp(this, 'mobile_no3')" @if(!empty($data->mobile_no3) && $data->whatsapp==$data->mobile_no3) checked value="{{ $data->mobile_no3 }}" @endif>
													<label for="whatsapp3" class="form-check-label">WhatsApp</label>
												</div>
											</div>
											<input type="text" name="mobile_no3" id="mobile_no3" value="{{ $data->mobile_no3 }}" class="form-control" placeholder="Enter Contact no." maxlength="10" onkeyup="validateMobileNumber(this)">
											<small id="mobileError3" class="text-danger d-none">Please enter a valid 10-digit Contact no.</small>
										</div>
									</div>

								{{--	<div class="col-md-4 mt-2">
										<label class="form-label">Grade</label>
										<select class="form-select single-select-clear-field" name="grade" data-placeholder="select">
											<option></option>
											@foreach(['A','B','C','D'] as $grade)
												<option value="{{ $grade }}" {{ $data->grade == $grade ? 'selected' : '' }}>{{ $grade }}</option>
											@endforeach
										</select>
									</div>
--}}								<div class="col-md-4 mt-2">
										<label class="form-label">College Code</label>
										<input type="text" name="college_code" id="college_code" class="form-control" placeholder="Enter College code" maxlength="50" value="{{ !empty($data->college_code)?$data->college_code:'' }}">
									</div>
									<div class="col-md-4 mt-2">
										<label class="form-label">Status</label>
										<select class="form-select single-select-clear-field" name="status">
											<option value="1" {{ $data->status == 1 ? 'selected' : '' }}>Active</option>
											<option value="2" {{ $data->status == 2 ? 'selected' : '' }}>Inactive</option>
										</select>
									</div>

								</div>
							</div>

							<div class="col-md-12">
								<button type="button" onclick="window.location='{{ url($current_menu) }}'" class="btn btn-light px-4">Cancel</button>
								<button type="submit" style="float: right;" class="btn btn-primary px-4">Update</button>
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
        if (cb.checked) atLeastOneChecked = true;
    });

    if (!atLeastOneChecked) {
        alert("Please select at least one WhatsApp number.");
        return false;
    }

    return true;
}
</script>