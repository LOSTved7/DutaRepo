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
                            <a href="{{ route($current_menu.'.create') }}" class="btn btn-primary">Add</a>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="example">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Staff Name</th>
                                <th>College Name</th>
                                <th>Designation</th>
                               {{--<th>Action</th>--}}
                            </tr>
                        </thead>
                        <tbody>
							 @if(!$data->isEmpty())
                            @php $i = 1; @endphp
                            @foreach($data as $key => $item)
                                @php
                                    $encid = Crypt::encryptString($key);
									$full_name = !empty($staffProfiles[$item->staff_detail_id])?$staffProfiles[$item->staff_detail_id]:'';
                                @endphp
                                <tr>
                                    <td>{{ $i++ }}</td>
                                    <td>{{ $full_name }}</td>
                                    <td>{{ !empty($item->college_name)?$item->college_name:''}}</td>
                                    <td>{{ !empty($item->designation)?$item->designation:''}}</td>
									
                                </tr>
                            @endforeach
							@endif
                            @if($data->isEmpty())
                                <tr>
                                    <td colspan="7" class="text-center">No staff-college mapping records found.</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    $(document).ready(function () {
        $('#example').DataTable(); // Initialize DataTable if needed
    });
</script>
@endsection
