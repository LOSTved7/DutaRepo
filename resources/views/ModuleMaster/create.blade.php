@extends('layouts.header')

@section('title')
Student
@endsection

@section('content')
		<!--start page wrapper -->
		<div class="page-wrapper">
			<div class="page-content">
				<!--breadcrumb-->
				<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
								{{--
					<div class="breadcrumb-title pe-3">STUDENT</div>
					
					<div class="ps-3">
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb mb-0 p-0">
								<li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
								</li>
								<li class="breadcrumb-item active" aria-current="page">CREATE STUDENT</li>
							</ol>
						</nav>
					</div>
								--}}
					{{--
					<div class="ms-auto">
						<div class="btn-group">
							<button type="button" class="btn btn-primary">Settings</button>
							<button type="button" class="btn btn-primary split-bg-primary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown">	<span class="visually-hidden">Toggle Dropdown</span>
							</button>
							<div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-end">	<a class="dropdown-item" href="javascript:;">Action</a>
								<a class="dropdown-item" href="javascript:;">Another action</a>
								<a class="dropdown-item" href="javascript:;">Something else here</a>
								<div class="dropdown-divider"></div>	<a class="dropdown-item" href="javascript:;">Separated link</a>
							</div>
						</div>
					</div>
					--}}
				</div>
				<!--end breadcrumb-->
				<div class="row">
					<div class="col-xl-12 mx-auto">
						
						<div class="card">
							<div class="card-body p-4">
								<h5 class="mb-4">MODULE</h5>

					    <form class="row g-3"action="{{route($current_menu.'.store')}}" method="POST" enctype="multipart/form-data">
				            @csrf
							<div class="box-body">
					            <div class="form-group row">
					              	<div class="col-md-3">
										<label for="single-select-clear-field" class="form-label">Parent Module</label>
									 	<select class="form-select single-select-clear-field" name="parent_id"  data-placeholder="Select Parent" >
									 		<option></option>
									 		@foreach($module as $key => $value)
											<option value="{{$key}} ">{{$value}}</option>
											@endforeach
									 	</select>
								 	</div>
					                <div class="col-md-3">
					                  	<label class="form-label">Module Name<font color="red"><b>*</b></font></label>
					                  	<input type="text" name="name" class="form-control"  placeholder="Enter Module Name" maxlength="50" required>
					                </div>
					                <div class="col-md-3">
					                  	<label class="form-label">URL</label>
					                  	<input type="text" name="url" class="form-control"  placeholder="Enter URL" maxlength="50" >
					                </div>
					                <div class="col-md-3">
					                  <label class="form-label">Sequence</label>
					                  <input type="text" name="sequence" class="form-control"  placeholder="Enter Sequence" maxlength="50" >
					                </div>
					            </div>
					            <div class="form-group row" style="margin-top: 10px;">
					                <div class="col-md-9">
					                  <label class="form-label">Icon</label>
					                  <input type="text" name="icon" class="form-control"  placeholder="Enter Icon" maxlength="1000" >
					                </div>
					                <div class="col-md-3">
										<label for="single-select-clear-field" class="form-label">Status</label>
										<select class="form-select single-select-clear-field" data-placeholder="Choose Status">
											<option value="1">Active</option>
											<option value="2">Inactive</option>
										</select>
									</div>
					            </div>
					        </div>

					        <div class="col-md-12">
								<button type="button" onclick="window.location='{{url($current_menu)}}'"  class="btn btn-light px-4">Cancel</button>
								<button type="submit" style="float: right;" class="btn btn-primary px-4">Submit</button>
							</div>
					 	</form>
					</div>
				</div>
			</div>
		</div>
				<!--end row-->




	</div>
</div>
		<!--end page wrapper -->
@endsection