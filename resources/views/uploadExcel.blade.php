@extends('layouts.header')

@section('title')
    Create Staff
@endsection

@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            </div>
            <div class="row">
                <div class="col-xl-12 mx-auto">
                    <div class="card">
                        <div class="card-body p-4 row">
                            <div class="col-md-6">
                                <h4 class="">UPLOAD ELECTROL DATA</h4>
                            </div>
                            @php
                            @endphp
                            <div class="col-md-6 text-end">
                                <button onclick="downloadEmptyCSV();" class="btn btn-warning px-4">view Sample</button>
                            </div>

                           <form action="{{ route('upload.excel') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                 <div class="col-md-4">
                                        <label class="form-label">File To Upload<font color="red"><b>*</b></font></label>
                                        <input type="file" name="file" class="form-control" required>
                                    </div>
                                <div class="col-md-12">
                                    <button type="submit" style="float: right;" class="btn btn-primary px-4">Submit</button>
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
<script>
    function downloadEmptyCSV() {
    const headers = ['Name','college name','department','contact no'];
    const csvContent = headers.join(',') + '\n';
    const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
    const link = document.createElement('a');
    link.href = URL.createObjectURL(blob);
    link.download = 'GatNayakupload_sample.csv';
    link.style.display = 'none';
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}

</script>
@endsection