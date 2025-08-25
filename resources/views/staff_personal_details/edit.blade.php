@extends('layouts.header')

@section('title')
EDIT PERSONAL DETAILS
@endsection

@section('content')
<div class="page-wrapper">
	<div class="page-content">
		<div class="row">
			<div class="col-xl-12 mx-auto">
				<div class="card">
					<div class="card-body p-4">
						<h5 class="mb-4">EDIT PERSONAL DETAILS</h5>

						<form class="row g-3" action="{{ route($current_menu.'.update', $encrypted_id) }}" method="POST">
							@csrf
							@method('PUT')
							<div class="box-body">
								<div class="form-group row">

									<div class="col-md-4">
											<label for="college_id" class="form-label">College<font color="red"><b>*</b>
												</font></label>
											<select class="form-control single-select-clear-field" name="college_name"
												id="college_name" required data-placeholder="Select College">
												<option></option>
												@foreach($duColleges_mast as $key => $value)
													<option value="{{$key}}" {{ $data->college_name==$key?'selected':'' }}>{{$value}}</option>
												@endforeach
											</select>
										</div>

										<div class="col-md-4">
											<label class="form-label">Staff Name<font color="red"><b>*</b></font></label>
											<input type="text" name="name" id="name" class="form-control"
												placeholder="Enter Staff Name" maxlength="50" required value="{{ $data->name }}">
										</div>


										<div class="col-md-4  mt-2">
											<label class="form-label">Department</label>
											<select name="department" id="department"
												class="form-select single-select-clear-field"
												data-placeholder="select Department" maxlength="100">
												<option></option>
												@foreach($department as $dept)
													<option value="{{ $dept }}" {{ $data->department==$dept?'selected':'' }}>{{ $dept }}</option>
												@endforeach
											</select>
										</div>
										<div class="col-md-4 mt-2">
											<label class="form-label">Email</label>
											<input type="email" name="email1" class="form-control" placeholder="Enter Email" value="{{ $data->email }}"
												maxlength="100">
										</div>
										<div class="col-md-4 mt-2">
											<label class="form-label">Contact No</label>
											<input type="text" name="contact_no" id="contact_no" class="form-control"
												placeholder="Enter Contact No." maxlength="10"
												oninput="this.value = this.value.replace(/[^0-9]/g, '');"  value="{{ $data->mobile }}">
										</div>

										<div class="col-md-4 mt-2">
											<label for="status" class="form-label">Status</label>
											<select class="form-select single-select-clear-field" name="status">
												<option value="1" {{ $data->status==1?'selected':'' }}>Active</option>
												<option value="2" {{ $data->status==2?'selected':'' }}>Inactive</option>
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
