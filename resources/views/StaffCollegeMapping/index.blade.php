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
                                <button type="button" class="btn btn-success ms-2" id="showSmsCardBtn">Send SMS</button>

                            </div>
                        </div>
                    </form>

                    <div class="row mt-4">
                        <!-- Table Section -->
                        <div class="col-md-12" id="tableSection">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped" id="example3">
                                    <thead>
                                        <tr>
                                            <th><input type="checkbox" id="selectAll"></th>
                                            <th>S.No</th>
                                            <th>Staff Name</th>
                                            <th>College Name</th>
                                            @if(Auth::user()->role_id == 59)
                                                <th style="text-align: center;">Gat Nayak Name</th>
                                            @endif
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
                                                    <td><input type="checkbox" class="staffCheckbox" name="staff_ids[]"
                                                            value="{{ $item->whatsapp }}"></td>
                                                    <td>{{ $i++ }}</td>
                                                    <td>{{ $full_name }}</td>
                                                    <td>{{ $item->college_name ?? '' }}</td>
                                                    @if(Auth::user()->role_id == 59)
                                                        <td style="text-align: center;">
                                                            {{ $staff_Profile_arr[$item->staff_profile_id] ?? '' }}</td>
                                                    @endif
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
                                    <h5>Send SMS</h5>
                                </div>
                                <div class="card-body">
                                    <form action="{{ route('send.sms') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="mb-3">
                                            <label class="form-label">Subject</label>
                                            <input type="text" name="subject" class="form-control" placeholder="Enter Subject" required>
                                        </div>
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
    document.getElementById('showSmsCardBtn').addEventListener('click', function () {
        document.getElementById('tableSection').classList.remove('col-md-12');
        document.getElementById('tableSection').classList.add('col-md-8');
        document.getElementById('smsCardSection').classList.remove('d-none');
    });
    document.getElementById('cancelSmsCardBtn').addEventListener('click', function () {
        document.getElementById('tableSection').classList.remove('col-md-8');
        document.getElementById('tableSection').classList.add('col-md-12');
        document.getElementById('smsCardSection').classList.add('d-none');
    });

    document.getElementById('selectAll').addEventListener('change', function () {
        let checkboxes = document.querySelectorAll('.staffCheckbox');
        checkboxes.forEach(cb => cb.checked = this.checked);
    });

    document.querySelector('#smsCardSection form').addEventListener('submit', function () {
        let selected = [];
        document.querySelectorAll('.staffCheckbox:checked').forEach(cb => selected.push(cb.value));
        document.getElementById('selectedStaffInput').value = JSON.stringify(selected);
    });
</script>
@endsection