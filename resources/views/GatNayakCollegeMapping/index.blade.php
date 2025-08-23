@extends('layouts.header')

@section('title', 'Staff College Mapping')

@section('content')
<div class="page-wrapper">
    <div class="page-content">
        <div class="card">
            <div class="card-body">
                <div class="page-breadcrumb d-sm-flex align-items-center mb-3">
                    <div>
                        <h3 class="mb-0">GAT NAYAK COLLEGE MAPPING</h3>
                    </div>
                    <div class="ms-auto">
                        <div class="btn-group">
                            <a href="{{ route($current_menu.'.create') }}" class="btn btn-primary">Add Mapping</a>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="example">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Gat Nayak Name</th>
                                <th>Colleges mapped</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
							@if(!$data->isEmpty())
                                @php 
                                    $i = 1; 
                                    $grouped = $data->groupBy('staff_profile_id'); 
                                @endphp

                                @foreach($grouped as $staffId => $items)
                                    @php
                                        $encid = Crypt::encryptString($staffId);
                                        $staff = DB::table('staff_profile')->where('id', $staffId)->first();
                                        $full_name = trim(($staff->first_name ?? '') . ' ' . ($staff->middle_name ?? '') . ' ' . ($staff->last_name ?? ''));
                                        $colleges = $items->pluck('college_name')->filter()->unique()->implode('<br>');
                                    @endphp
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>{{ $full_name }}</td>
                                        <td>{{ $staff->college_name ?? '-' }}</td>
                                        <td>{!! $colleges ?: '<span style="color:red;">No Colleges Mapped</span>' !!}</td>
                                        <td>
                                            <a href="{{ url($current_menu.'/'.$encid.'/edit') }}" class="btn btn-sm btn-warning">Edit</a>
                                            <form action="{{ route($current_menu.'.destroy', $encid) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure you want to delete this entry?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                            </form>
                                        </td>
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