@extends('layouts.header')

@section('title')
User
@endsection

@section('content')
<!--start page wrapper -->
<div class="page-wrapper">
    <div class="page-content">
        <div class="row">
            <div class="col-xl-12 mx-auto">
                <div class="card">
                    <div class="card-body p-4">
                        <h4 class="mb-2">Edit User</h4>
                        <form class="row g-3" action="{{ route($current_menu.'.update', $data->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="college_name" class="form-label">College<font color="red"><b>*</b></font></label>
                                    <select class="form-select single-select-clear-field" name="college_name" id="college_name" required data-placeholder="Select College">
                                        <option></option>
                                        @foreach($duColleges as $value)
                                            <option value="{{ $value }}" {{ $data->college_name == $value ? 'selected' : '' }}>{{ $value }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label for="department" class="form-label">Department<font color="red"><b>*</b></font></label>
                                    <select class="form-select single-select-clear-field" name="department" id="department" required data-placeholder="Select Department">
                                        <option></option>
                                        @foreach($department_mast as $key => $value)
                                            <option value="{{ $key }}" {{ $data->department_id == $key ? 'selected' : '' }}>{{ $value }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-3">
                                    <label for="salutation" class="form-label">Salutation<font color="red"><b>*</b></font></label>
                                    <select name="salutation" id="salutation" class="form-select single-select-clear-field" required>
                                        <option value="">Select</option>
                                        @foreach(['Mr.', 'Ms.', 'Mrs.', 'Dr.', 'Prof.'] as $sal)
                                            <option value="{{ $sal }}" {{ $data->salutation == $sal ? 'selected' : '' }}>{{ $sal }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-3">
                                    <label for="first_name" class="form-label">First Name<font color="red"><b>*</b></font></label>
                                    <input type="text" name="first_name" id="first_name" class="form-control" value="{{ $data->first_name }}" required>
                                </div>

                                <div class="col-md-3">
                                    <label for="middle_name" class="form-label">Middle Name</label>
                                    <input type="text" name="middle_name" id="middle_name" class="form-control" value="{{ $data->middle_name }}">
                                </div>

                                <div class="col-md-3">
                                    <label for="last_name" class="form-label">Last Name<font color="red"><b>*</b></font></label>
                                    <input type="text" name="last_name" id="last_name" class="form-control" value="{{ $data->last_name }}" required>
                                </div>

                                <div class="col-md-3">
                                    <label for="employment_type" class="form-label">Employment Type<font color="red"><b>*</b></font></label>
                                    <select class="form-select single-select-clear-field" name="employment_type" id="employment_type" required>
                                        @foreach(['Permanent', 'Adhoc', 'Temp'] as $type)
                                            <option value="{{ $type }}" {{ $data->employment_type == $type ? 'selected' : '' }}>{{ $type }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-3">
                                    <label for="contact_no" class="form-label">Contact No.<font color="red"><b>*</b></font></label>
                                    <input type="text" name="contact_no" id="contact_no" class="form-control" value="{{ $data->contact_no }}" required>
                                </div>
                                <div class="col-md-3">
									    <label for="salutation" class="form-label">Gender<font color="red"><b>*</b></font></label>
									    <select name="gender" id="gender" class="form-select single-select-clear-field" required>
									      <option value="">Select</option>
									      <option value="1" {{ (!empty($data->gender) && $data->gender==1)?'selected':'' }}>Male</option>
									      <option value="2" {{(!empty($data->gender) && $data->gender==2)?'selected':''}}>Female</option>
									    </select>
									  </div>
									  <div class="col-md-3">
                                    <label for="email" class="form-label">Email<font color="red"><b>*</b></font></label>
                                    <input type="text" name="email" id="email" class="form-control" value="{{ $data->email }}" required>
                                </div>

                                <div class="col-md-3">
                                    <label for="grade" class="form-label">Grade<font color="red"><b>*</b></font></label>
                                    <select name="grade" id="grade" class="form-select single-select-clear-field" required>
                                        @foreach(['A', 'B', 'C', 'D'] as $grade)
                                            <option value="{{ $grade }}" {{ $data->grade == $grade ? 'selected' : '' }}>{{ $grade }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-3">
                                    <label for="sangathan" class="form-label">Sangathan<font color="red"><b>*</b></font></label>
                                    <select name="sangathan" id="sangathan" class="form-select single-select-clear-field" required>
                                        @foreach(['RSS', 'ABVP', 'BJP Yuva Morcha', 'NSUI', 'Other'] as $sangathan)
                                            <option value="{{ $sangathan }}" {{ $data->sangathan == $sangathan ? 'selected' : '' }}>{{ $sangathan }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-2">
                                    <label for="status" class="form-label">Status<font color="red"><b>*</b></font></label>
                                    <select class="form-select single-select-clear-field" name="status" id="status" required>
                                        <option value="1" {{ $data->status == 1 ? 'selected' : '' }}>Active</option>
                                        <option value="2" {{ $data->status == 2 ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label for="comments" class="form-label">Comments</label>
                                    <textarea name="comments" id="comments" class="form-control" rows="2">{{ $data->comments }}</textarea>
                                </div>
                            </div>

                            <div class="col-md-12" style="margin-top: 10px;">
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

@section('js')
<script type="text/javascript">
    jQuery(function ($) {
        $('form').bind('submit', function () {
            $(this).find('select').prop('disabled', false);
        });
    });
</script>
@endsection
