@extends('layouts.header')

@section('title')
College
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
								<h5 class="mb-4">COLLEGE</h5>
						<form class="row g-3" action="{{route($current_menu.'.update', $encrypted_id)}}" method="POST">
						@csrf
						@method('PATCH')
						
								
								<div class="col-md-4">
									<label class="form-label">College Name<font color="red"><b>*</b></font></label>
									<input type="text" name="college_name" value="{{$data->college_name}}" class="form-control"  placeholder="Enter College Name" required>
								</div>
								<div class="col-md-4">
									<label class="form-label">ID/CODE<font color="red"><b>*</b></font></label>
									<input type="text" name="short_name" class="form-control" value="{{$data->college_id}}"  placeholder="Enter College Short Name" required >
								</div>
								<div class="col-md-3">
										<label for="single-select-clear-field" class="form-label">Status<font color="red"><b>*</b></font></label>
										 <select class="form-select single-select-clear-field" name="status" data-placeholder="Choose Status" required>
											 <option></option>
												<option value="1" {{($data->status == 1)?'selected':''}}>Active</option>
												<option value="2" {{($data->status == 2)?'selected':''}}>Inactive</option>
										 </select>
										</div>
							
						<!-- /.box-body -->
						<div class="col-md-12">
									
											<button type="button" onclick="window.location='{{url($current_menu)}}'"class="btn btn-light px-4">Cancel</button>
											<button type="submit" style="float: right;" class="btn btn-primary px-4">Submit</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
		@endsection