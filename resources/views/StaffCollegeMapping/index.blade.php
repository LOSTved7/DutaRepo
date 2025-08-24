@extends('layouts.header')

@section('title', 'Staff College Mapping')

@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <div class="card">
                <div class="card-body">
                    <div class="page-breadcrumb d-sm-flex align-items-center mb-3">
                        <div>
                            <h3 class="mb-0">GAT NAYAK STAFF MAPPING</h3>
                        </div>
                        <div class="ms-auto">
                            <div class="btn-group">
                                <a href="{{ route($current_menu . '.create') }}" class="btn btn-primary">Add</a>
                            </div>
                        </div>
                    </div>
                    <form action="" method="GET">
                        @csrf
                        <div class="row">
                            <div class="col-md-3">
                                <label for="gat_nayak" class="form-label">Gat Nayak Name</label>
                                <select class="form-select single-select-clear-field" name="gat_nayak" id="gat_nayak"
                                    onchange="get_staff_by_get_nayak(this);" data-placeholder="Select Gat Nayak">
                                    <option></option>
                                    @foreach($staff_Profile_arr as $key => $value)
                                        <option value="{{$key}}" {{ old('gat_nayak', request('gat_nayak')) == $key ? 'selected' : '' }}>
                                            {{ $value}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="staff_name" class="form-label">Staff Name</label>
                                <select class="form-select single-select-clear-field" name="staff_name" id="staff_name" data-placeholder="Select Staff">
                                    <option></option>
                                    @foreach($staff_detail_arr as $key => $value)
                                        <option value="{{$key}}" {{ old('staff_name', request('staff_name')) == $key ? 'selected' : '' }}>
                                            {{ $value}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3" style="margin-top:25px; display:flex;">
                                <input style="margin:3px" type="submit" class="btn btn-primary px-4" value="Find">

                                <button type="button" class="btn btn-success ms-2" id="showSmsCardBtn"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-whatsapp" viewBox="0 0 16 16">
                                <path d="M13.601 2.326A7.85 7.85 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.9 7.9 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.9 7.9 0 0 0 13.6 2.326zM7.994 14.521a6.6 6.6 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.56 6.56 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592m3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.73.73 0 0 0-.529.247c-.182.198-.691.677-.691 1.654s.71 1.916.81 2.049c.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232"/>
                                </svg></button>


                                <button type="button" class="btn btn-primary ms-2" id="showMailCardBtn"><svg height="18" width="18" version="1.1" id="_x32_" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <style type="text/css"> .st0{fill:#000000;} </style> <g> <path class="st0" d="M510.678,112.275c-2.308-11.626-7.463-22.265-14.662-31.054c-1.518-1.915-3.104-3.63-4.823-5.345 c-12.755-12.818-30.657-20.814-50.214-20.814H71.021c-19.557,0-37.395,7.996-50.21,20.814c-1.715,1.715-3.301,3.43-4.823,5.345 C8.785,90.009,3.63,100.649,1.386,112.275C0.464,116.762,0,121.399,0,126.087V385.92c0,9.968,2.114,19.55,5.884,28.203 c3.497,8.26,8.653,15.734,14.926,22.001c1.59,1.586,3.169,3.044,4.892,4.494c12.286,10.175,28.145,16.32,45.319,16.32h369.958 c17.18,0,33.108-6.145,45.323-16.384c1.718-1.386,3.305-2.844,4.891-4.43c6.27-6.267,11.425-13.741,14.994-22.001v-0.064 c3.769-8.653,5.812-18.171,5.812-28.138V126.087C512,121.399,511.543,116.762,510.678,112.275z M46.509,101.571 c6.345-6.338,14.866-10.175,24.512-10.175h369.958c9.646,0,18.242,3.837,24.512,10.175c1.122,1.129,2.179,2.387,3.112,3.637 L274.696,274.203c-5.348,4.687-11.954,7.002-18.696,7.002c-6.674,0-13.276-2.315-18.695-7.002L43.472,105.136 C44.33,103.886,45.387,102.7,46.509,101.571z M36.334,385.92V142.735L176.658,265.15L36.405,387.435 C36.334,386.971,36.334,386.449,36.334,385.92z M440.979,420.597H71.021c-6.281,0-12.158-1.651-17.174-4.552l147.978-128.959 l13.815,12.018c11.561,10.046,26.028,15.134,40.36,15.134c14.406,0,28.872-5.088,40.432-15.134l13.808-12.018l147.92,128.959 C453.137,418.946,447.26,420.597,440.979,420.597z M475.666,385.92c0,0.529,0,1.051-0.068,1.515L335.346,265.221L475.666,142.8 V385.92z"></path> </g> </g></svg></button>

                            </div>
                        </div>
                    </form>

                    <div class="row mt-4">
                        <!-- Table Section -->
                        <div class="col-md-12" id="tableSection">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped" id="example5">
                                    <thead>
                                        <tr>
                                            <th style="width:5%;">S.No</th>
                                            <th><input type="checkbox" id="selectAll"></th>
                                            <th  style="width:5%;">Staff Name</th>
                                            <th>WhatsApp</th>
                                            <th>Email</th>
                                            <th>Notification Status</th>
                                            @if(Auth::user()->role_id == 59)
                                                <th style="text-align: center;">Gat Nayak Name</th>
                                            @endif
                                            <th>College Name</th>
                                            <th>Designation</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(!$data->isEmpty())
                                            @php $i = 1; @endphp
                                            @foreach($data as $key => $item)
                                                @php
                                                    $encid = Crypt::encryptString($key);
                                                    $full_name = !empty($staffProfiles[$item->staff_detail_id]) ? $staffProfiles[$item->staff_detail_id] : '';
                                                @endphp
                                                <tr>
                                                    <td>{{ $i++ }}</td>
                                                    <td><input type="checkbox" class="staffCheckbox" name="staff_ids[]"
                                                            value="{{ !empty($item->staff_detail_id)?$item->staff_detail_id:'' }}"></td>
                                                    <td>{{ $full_name }}</td>
                                                    <td>{{ !empty($item->whatsapp)?$item->whatsapp:'' }}</td>
                                                    <td>{{ !empty($item->email1)?$item->email1:'' }}</td>
                                                    <td>@if(!empty($item->whatsapp_message_sent) && $item->whatsapp_message_sent==1)
                                                            ✅ WhatsApp Sent
                                                        @endif

                                                        @if(!empty($item->mail_sent) && $item->mail_sent==1)
                                                            @if(!empty($item->whatsapp_message_sent) && $item->whatsapp_message_sent==1)
                                                                <br>
                                                            @endif
                                                            ✅ Mail Sent
                                                        @endif
                                                    </td>
                                                    @if(Auth::user()->role_id == 59)
                                                    <td style="text-align: center;">
                                                        {{ $staff_Profile_arr[$item->staff_profile_id] ?? '' }}</td>
                                                        @endif
                                                        <td>{{ !empty($duColleges_mast[$item->college_name])?$duColleges_mast[$item->college_name]:'' }}</td>
                                                    <td>{{ $item->designation ?? '' }}</td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="7" class="text-center">No staff-college mapping records found.</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- SMS Card Section (Hidden Initially) -->
                        <div class="col-md-4 d-none" id="smsCardSection">
                            <div class="card">
                                <div class="card-header">
                                    <h5><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-whatsapp" viewBox="0 0 16 16">
                                        <path d="M13.601 2.326A7.85 7.85 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.9 7.9 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.9 7.9 0 0 0 13.6 2.326zM7.994 14.521a6.6 6.6 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.56 6.56 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592m3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.73.73 0 0 0-.529.247c-.182.198-.691.677-.691 1.654s.71 1.916.81 2.049c.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232"/>
                                        </svg> <span style="text-align: center;">Send WhatsApp</span> </h5>
                                </div>
                                <div class="card-body">
                                    <form action="{{ route('send.sms') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="mb-3">
                                            <label class="form-label">Body</label>
                                            <textarea name="body" rows="3" class="form-control" placeholder="write message" required></textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Attachment (optional)</label>
                                            <input type="file" name="attachment" class="form-control">
                                        </div>
                                        <input type="hidden" name="selected_staff" id="selectedStaffInput">
                                        <div class="d-flex">
                                            <button type="submit" class="btn btn-success me-2">Send</button>
                                            <button type="button" class="btn btn-secondary"
                                                id="cancelSmsCardBtn">Cancel</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 d-none" id="mailCardSection">
                            <div class="card">
                                <div class="card-header">
                                    <h5>
                                        <svg height="18" width="18" version="1.1" id="_x32_" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <style type="text/css"> .st0{fill:#000000;} </style> <g> <path class="st0" d="M510.678,112.275c-2.308-11.626-7.463-22.265-14.662-31.054c-1.518-1.915-3.104-3.63-4.823-5.345 c-12.755-12.818-30.657-20.814-50.214-20.814H71.021c-19.557,0-37.395,7.996-50.21,20.814c-1.715,1.715-3.301,3.43-4.823,5.345 C8.785,90.009,3.63,100.649,1.386,112.275C0.464,116.762,0,121.399,0,126.087V385.92c0,9.968,2.114,19.55,5.884,28.203 c3.497,8.26,8.653,15.734,14.926,22.001c1.59,1.586,3.169,3.044,4.892,4.494c12.286,10.175,28.145,16.32,45.319,16.32h369.958 c17.18,0,33.108-6.145,45.323-16.384c1.718-1.386,3.305-2.844,4.891-4.43c6.27-6.267,11.425-13.741,14.994-22.001v-0.064 c3.769-8.653,5.812-18.171,5.812-28.138V126.087C512,121.399,511.543,116.762,510.678,112.275z M46.509,101.571 c6.345-6.338,14.866-10.175,24.512-10.175h369.958c9.646,0,18.242,3.837,24.512,10.175c1.122,1.129,2.179,2.387,3.112,3.637 L274.696,274.203c-5.348,4.687-11.954,7.002-18.696,7.002c-6.674,0-13.276-2.315-18.695-7.002L43.472,105.136 C44.33,103.886,45.387,102.7,46.509,101.571z M36.334,385.92V142.735L176.658,265.15L36.405,387.435 C36.334,386.971,36.334,386.449,36.334,385.92z M440.979,420.597H71.021c-6.281,0-12.158-1.651-17.174-4.552l147.978-128.959 l13.815,12.018c11.561,10.046,26.028,15.134,40.36,15.134c14.406,0,28.872-5.088,40.432-15.134l13.808-12.018l147.92,128.959 C453.137,418.946,447.26,420.597,440.979,420.597z M475.666,385.92c0,0.529,0,1.051-0.068,1.515L335.346,265.221L475.666,142.8 V385.92z"></path> </g> </g></svg> <span>Send Email</span>
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <form action="{{ route('send.mail') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="mb-3">
                                            <label class="form-label">Subject</label>
                                            <input type="text" name="subject" class="form-control" placeholder="Enter Subject" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Body</label>
                                            <textarea name="body" rows="3" class="form-control" placeholder="Write message" required></textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Attachment (optional)</label>
                                            <input type="file" name="attachment" class="form-control">
                                        </div>
                                        <input type="hidden" name="selected_staff" id="selectedStaffInputMail">
                                        <div class="d-flex">
                                            <button type="submit" class="btn btn-primary me-2">Send</button>
                                            <button type="button" class="btn btn-secondary" id="cancelMailCardBtn">Cancel</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function () {
            $('#example4').DataTable(); // Initialize DataTable
        });

        function get_staff_by_get_nayak(ele) {
            var gat_nayak_id = $(ele).val();
            if (gat_nayak_id) {
                $.ajax({
                    url: "{{ route('getStaffByGatNayak') }}",
                    type: 'POST',
                    data: {
                        gat_nayak_id: gat_nayak_id,
                        '_token': '{{ csrf_token() }}'
                    },
                    success: function (response) {
                        $('#staff_name').empty();
                        $('#staff_name').append('<option value="">Select Staff</option>');
                        $.each(response, function (key, value) {
                            $('#staff_name').append('<option value="' + key + '">' + value + '</option>');
                        });
                    },
                    error: function (xhr) {
                        console.error(xhr);
                    }
                });
            } else {
                $('#staff_name').empty();
                $('#staff_name').append('<option value="">Select Staff</option>');
            }
        }
    </script>
    <script>
   // WhatsApp Button
document.getElementById('showSmsCardBtn').addEventListener('click', function () {
    document.getElementById('tableSection').classList.replace('col-md-12', 'col-md-8');
    document.getElementById('smsCardSection').classList.remove('d-none');
    document.getElementById('mailCardSection').classList.add('d-none'); // hide email card if open
});

// Email Button
document.getElementById('showMailCardBtn').addEventListener('click', function () {
    document.getElementById('tableSection').classList.replace('col-md-12', 'col-md-8');
    document.getElementById('mailCardSection').classList.remove('d-none');
    document.getElementById('smsCardSection').classList.add('d-none'); // hide whatsapp card if open
});

// Cancel WhatsApp
document.getElementById('cancelSmsCardBtn').addEventListener('click', function () {
    document.getElementById('tableSection').classList.replace('col-md-8', 'col-md-12');
    document.getElementById('smsCardSection').classList.add('d-none');
});

// Cancel Email
document.getElementById('cancelMailCardBtn').addEventListener('click', function () {
    document.getElementById('tableSection').classList.replace('col-md-8', 'col-md-12');
    document.getElementById('mailCardSection').classList.add('d-none');
});

// Capture selected staff for WhatsApp form
document.querySelector('#smsCardSection form').addEventListener('submit', function () {
    let selected = [];
    document.querySelectorAll('.staffCheckbox:checked').forEach(cb => selected.push(cb.value));
    document.getElementById('selectedStaffInput').value = JSON.stringify(selected);
});

// Capture selected staff for Email form
document.querySelector('#mailCardSection form').addEventListener('submit', function () {
    let selected = [];
    document.querySelectorAll('.staffCheckbox:checked').forEach(cb => selected.push(cb.value));
    document.getElementById('selectedStaffInputMail').value = JSON.stringify(selected);
});
 document.getElementById('selectAll').addEventListener('change', function () {
        let checkboxes = document.querySelectorAll('.staffCheckbox');
        checkboxes.forEach(cb => cb.checked = this.checked);
    });

</script>
@endsection