@extends('layouts.header')
@section('title')
Update Subjects
@endsection
@section('content')
<div class="page-wrapper">
    <div class="page-content">
        <div class="row">
            <div class="col-xl-12 mx-auto">
                <div class="card">
                    <div class="card-body">
                        <div class="page-breadcrumb d-sm-flex align-items-center mb-3">
                            <div>
                                <h4>UPDATE PREVIOUS SUBJECT</h4>
                            </div>
                        </div>
                        <form class="row g-3" action="{{url('updatePreviousSubjectStore')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                                
                                <div class="col-md-3">
                                    <label for="single-select-clear-field" class="form-label">Choose file<font
                                            color="red"><b>*</b></font></label>
                                    <input type="file" class="form-control" name="excelfile" required>
                                </div>
                                <div class="col-md-3">
                                    <label for="single-select-clear-field" class="form-label">Data Type<font
                                            color="red"><b>*</b></font></label>
                                   <select class="form-select single-select-clear-field" name="data_type"  data-placeholder="Current/Previous Data" required> 
                                        <option></option>
                                        <option value="current">Current Semester Data</option>
                                        <option value="previous">Previous Semester Data</option>
                            </select>
                                </div>
                                <div class="col-md-12">
                                    
                                            <button type="button" onclick="window.location='{{url('updatePreviousSubject')}}'"  class="btn btn-light px-4">Cancel</button>
                                            
                                            <button type="submit" style="float: right;" class="btn btn-primary px-4">Submit</button>
                                    </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection