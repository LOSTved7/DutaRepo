@extends('layouts.header')

@section('title')
My Profile
@endsection
@section('css')
<style>
	/*
    .modal {
        display: none;
        position: fixed;
        z-index: 1;
        left: 0;
        top: 0;
        width: 30%;
        height: 30%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0);
    }

    .modal-content {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        max-width: 40%; 
        max-height: 40%;
    }

    .close {
        color: white;
        position: absolute;
        top: 15px;
        right: 15px;
        font-size: 30px;
        font-weight: bold;
        cursor: pointer;
    }

    .modal-content {
        animation: zoom 0s;
    }

    @keyframes zoom {
        from {
            transform: scale(0)
        }
        to {
            transform: scale(1)
        }
    }
    */
</style>

@endsection

@section('content')
		<!--start page wrapper -->
		<div class="page-wrapper">
			<div class="page-content">
				<!--breadcrumb-->
				<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
					<div class="breadcrumb-title pe-3">User Profile</div>
					<div class="ps-3">
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb mb-0 p-0">
								<li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
								</li>
								<li class="breadcrumb-item active" aria-current="page">User Profile</li>
							</ol>

						</nav>
						
					</div>
					


						
					<div class="ms-auto">
						<div class="btn-group">
							{{--
							//commented on 250124 because of mobile view
							<!-- Button trigger modal -->
							<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleVerticallycenteredModal">Change Password</button>
							<!-- Modal -->
							<div class="modal fade" id="exampleVerticallycenteredModal" tabindex="-1" aria-hidden="true">
								<div class="modal-dialog modal-dialog-centered">
									<form action="{{url('change_password')}}" method="POST">
										@csrf
										<div class="modal-content">
											<div class="modal-header">
												<h5 class="modal-title">Change Password</h5>
												<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
											</div>
											<div class="modal-body">
												<div class="form-group">
													<div class="row">
														<div class="col-md-6">
															<label for="current_password">Enter Current Password</label>
														</div>
														<div class="col-md-6">
															<input class="form-control" type="password" name="current_password" id="current_password" autocomplete="off" required>
														</div>
													</div>
													<div class="row">
														<div class="col-md-6">
															<label for="current_password">Enter New Password</label>
														</div>
														<div class="col-md-6">
															<input class="form-control" type="password" name="new_password" id="new_password" autocomplete="off" onkeyup="check_new_password()" required>
														</div>
													</div>
													<div class="row">
														<div class="col-md-6">
															<label for="confirm_new_password">Confirm New Password</label>
														</div>
														<div class="col-md-6">
															<input class="form-control" type="password" name="confirm_new_password" autocomplete="off" id="confirm_new_password" onkeyup="check_new_password()" required>
														</div>
													</div>
													<div class="row">
														<div class="col-md-6">
														</div>
														<div class="col-md-6">
															<span id='password_match_msg' style="display: none;"><font color="red">Password Does Not Match</font></span>
														</div>
													</div>
												</div>
											</div>
											<div class="modal-footer">
												<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
												<button type="submit" name="update_password_btn" id="update_password_btn" class="btn btn-primary" disabled>Update</button>
											</div>
										</div>
									</form>
								</div>
							</div>
							//commented on 250124 because of mobile view
							--}}

							{{--
							<button type="button" class="btn btn-primary split-bg-primary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown">	<span class="visually-hidden">Toggle Dropdown</span>
							</button>
							<div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-end">	<a class="dropdown-item" href="javascript:;">Action</a>
								<a class="dropdown-item" href="javascript:;">Another action</a>
								<a class="dropdown-item" href="javascript:;">Something else here</a>
								<div class="dropdown-divider"></div>	<a class="dropdown-item" href="javascript:;">Separated link</a>
							</div>
							--}}
						</div>
					</div>
				</div>
				<!--end breadcrumb-->
				<div class="container">
					<div class="main-body">
						<div class="row">
							<div class="col-lg-4">
								<div class="card">
									
									<div class="card-body">
										
										<div class="d-flex flex-column align-items-center text-center">
											<?php 
												$image_path = !empty($user_arr['photo'])?$user_arr['photo']:'';
											?>
											

											<img src="{{asset($image_path)}}" alt="Profile Picture" class="rounded-circle p-1 bg-primary" width="110">
											
											<div class="mt-3">
												<h4>{{!empty($user_arr['user_profile_data']->name)?$user_arr['user_profile_data']->name:''}}</h4>
												{{--
												<p class="text-secondary mb-1">Full Stack Developer</p>
												<p class="text-muted font-size-sm">Bay Area, San Francisco, CA</p>
												<button class="btn btn-primary">Follow</button>
												<button class="btn btn-outline-primary">Message</button>
												--}}
											</div>
										</div>
										@if(!empty($user_arr['college']))
										<hr class="my-4" />
										<ul class="list-group list-group-flush">
											<li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
												<h6 class="mb-0">College</h6>
												<span class="text-secondary">{{$user_arr['college']}}</span>
											</li>
										</ul>
										@endif
									</div>
								</div>
							</div>

							<div class="col-lg-8">
								<div class="card">
									<div class="float-right">
								{{--<a class="btn btn-primary ms-2 mt-2 " style="width:250px;height:40px;"  target="_blank" href="https://www.antiragging.in/affidavit_affiliated_form.php">AntiRaging Form</a>--}}
									</div>
									<div class="card-body">
										
									
										<form action="{{url('update_summary_profile')}}" method="POST" enctype="multipart/form-data">
											@csrf
										<div class="row mb-3">
											<div class="col-sm-3">
												<h6 class="mb-0">Full Name</h6>
											</div>
											<div class="col-sm-9 text-secondary">
												<input type="text" style="background-color: aliceblue;" class="form-control" value="{{!empty($user_arr['name'])?$user_arr['name']:''}}" readonly />
											</div>
										</div>
										<div class="row mb-3">
											<div class="col-sm-3">
												<h6 class="mb-0">Username<font color="red"><b>*</b></font></h6>
											</div>
											<div class="col-sm-9 text-secondary">
												<input type="text" name="email" class="form-control" value="{{!empty($user_arr['email'])?$user_arr['email']:''}}"  required />
											</div>
										</div>
										<div class="row mb-3">
											<div class="col-sm-3">
												<h6 class="mb-0">Profile Picture</h6>
											</div>
											<div class="col-sm-9 text-secondary">
												<input type="file" name="profile_picture" accept=".jpg,.png,.jpeg" class="form-control" />
											</div>
										</div>
										
											@if(Auth::user()->role_id==3)
											@if(Auth::user()->college_id == 67)
											<div class="row mb-3">
											<div class="col-sm-3">
												<h6 class="mb-0">Examination Roll No.</h6>
											</div>
											<div class="col-sm-9 text-secondary">
												<input type="text" style="background-color: aliceblue;" class="form-control" name="college_roll_no" value="{{!empty($user_arr['user_profile_data']->examination_roll_no)?$user_arr['user_profile_data']->examination_roll_no:''}}"  readonly />
											</div>
										</div>
										@else
										<div class="row mb-3">
											<div class="col-sm-3">
												<h6 class="mb-0">College Roll No.</h6>
											</div>
											<div class="col-sm-9 text-secondary">
												<input type="text" style="background-color: aliceblue;" class="form-control" name="college_roll_no" value="{{$college_roll_no}}"  readonly />
											</div>
										</div>
										@endif
										@endif
										
											{{--<div class="col-sm-3">
												<h6 class="mb-0">Payment Refrence Number</h6>
											</div>
											<div class="col-sm-4 text-secondary">
												<input type="text" style="background-color: aliceblue;"  class="form-control" value="" readonly />
											</div>
										</div>--}}
										<div class=" form-group row">
											<div class="col-md-3 " style="margin-top: 30px;">
												<input type="submit"  class="btn btn-warning" value="Update Profile">
											</div>
										</form>
											<div class="col-sm-3">
								{{--<a class="btn btn-primary btn-sm" target="_blank" href="https://www.antiragging.in/affidavit_affiliated_form.php">AntiRaging Form</a>--}}
											</div>
											<div class="col-md-4" style="margin-top: 30px; margin-left: 90px;">
												<!-- Button trigger modal -->
												@if(Auth::user()->college_id == 44)
													@if(Auth::user()->role_id != 4)
													<button type="button" class="btn btn-primary "  data-bs-toggle="modal" data-bs-target="#exampleVerticallycenteredModal">Change Password</button>
													@endif
												@else
												<button type="button" class="btn btn-primary "  data-bs-toggle="modal" data-bs-target="#exampleVerticallycenteredModal">Change Password</button>
												@endif
												<!-- Modal -->
												<div class="modal fade" id="exampleVerticallycenteredModal" tabindex="-1" aria-hidden="true">
													<div class="modal-dialog modal-dialog-centered">
														<form action="{{url('change_password')}}" method="POST">
															@csrf
															<div class="modal-content">
																<div class="modal-header">
																	<h5 class="modal-title">Change Password</h5>
																	<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
																</div>
																<div class="modal-body">
																	<div class="form-group">
																		<div class="row">
																			<div class="col-md-6">
																				<label for="current_password">Enter Current Password</label>
																			</div>
																			<div class="col-md-6">
																				<input class="form-control" type="password" name="current_password" id="current_password" autocomplete="off" required>
																			</div>
																		</div>
																		<div class="row">
																			<div class="col-md-6">
																				<label for="current_password">Enter New Password</label>
																			</div>
																			<div class="col-md-6">
																				<input class="form-control" type="password" name="new_password" id="new_password" autocomplete="off" onkeyup="check_new_password()" required>
																			</div>
																		</div>
																		<div class="row">
																			<div class="col-md-6">
																				<label for="confirm_new_password">Confirm New Password</label>
																			</div>
																			<div class="col-md-6">
																				<input class="form-control" type="password" name="confirm_new_password" autocomplete="off" id="confirm_new_password" onkeyup="check_new_password()" required>
																			</div>
																		</div>
																		<div class="row">
																			<div class="col-md-6">
																			</div>
																			<div class="col-md-6">
																				<span id='password_match_msg' style="display: none;"><font color="red">Password Does Not Match</font></span>
																			</div>
																		</div>
																	</div>
																</div>
																<div class="modal-footer">
																	<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
																	<button type="submit" name="update_password_btn" id="update_password_btn" class="btn btn-primary" disabled>Update</button>
																</div>
															</div>
														</form>
													</div>
												</div>
											</div>
										</div>
										{{--
										<div class="row mb-3">
											<div class="col-sm-3">
												<h6 class="mb-0">Address</h6>
											</div>
											<div class="col-sm-9 text-secondary">
												<input type="text" class="form-control" value="Bay Area, San Francisco, CA" />
											</div>
										</div>
										--}}

										{{--
										<div class="row">
											<div class="col-sm-3"></div>
											<div class="col-sm-9 text-secondary">
												<?php 
													$user_profile_id = !empty($user_arr['user_profile_data']->id)?$user_arr['user_profile_data']->id:'';
													if(!empty($user_profile_id)) {
														$encid = Crypt::encrypt($user_profile_id);
														$link = 'UserProfileMast/'.$encid.'/edit';
													}
													else {
														$link = 'UserProfileMast/create';
													}
												 ?>
												<a href="{{$link}}" class="btn btn-warning px-4">Edit Profile</a>
												
											</div>
										</div>
										--}}
									</div>
								</div>
								
								{{--
								<div class="row">
									<div class="col-sm-12">
										<div class="card">
											<div class="card-body">
												<h5 class="d-flex align-items-center mb-3">Project Status</h5>
												<p>Web Design</p>
												<div class="progress mb-3" style="height: 5px">
													<div class="progress-bar bg-primary" role="progressbar" style="width: 80%" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
												</div>
												<p>Website Markup</p>
												<div class="progress mb-3" style="height: 5px">
													<div class="progress-bar bg-danger" role="progressbar" style="width: 72%" aria-valuenow="72" aria-valuemin="0" aria-valuemax="100"></div>
												</div>
												<p>One Page</p>
												<div class="progress mb-3" style="height: 5px">
													<div class="progress-bar bg-success" role="progressbar" style="width: 89%" aria-valuenow="89" aria-valuemin="0" aria-valuemax="100"></div>
												</div>
												<p>Mobile Template</p>
												<div class="progress mb-3" style="height: 5px">
													<div class="progress-bar bg-warning" role="progressbar" style="width: 55%" aria-valuenow="55" aria-valuemin="0" aria-valuemax="100"></div>
												</div>
												<p>Backend API</p>
												<div class="progress" style="height: 5px">
													<div class="progress-bar bg-info" role="progressbar" style="width: 66%" aria-valuenow="66" aria-valuemin="0" aria-valuemax="100"></div>
												</div>
											</div>
										</div>
									</div>
								</div>
								--}}
							</div>
							
						</div>
					</div>
				</div>
			</div>
		</div>
		<!--end page wrapper -->
@endsection
@section('js')




<script type="text/javascript">
	function check_new_password() {
		var current_password = document.getElementById('current_password').value;
		var new_password = document.getElementById('new_password').value;
		var confirm_password = document.getElementById('confirm_new_password').value;
		if(current_password == '' || current_password == undefined) {
			alert('Please Enter Current Password First');
			document.getElementById('new_password').value = '';
			document.getElementById('confirm_new_password').value = '';
			document.getElementById('update_password_btn').disabled = true;
		}
		else if(new_password != confirm_password) {
			document.getElementById('password_match_msg').style.display = 'block';
			document.getElementById('update_password_btn').disabled = true;
		}
		else {
			document.getElementById('password_match_msg').style.display = 'none';
			document.getElementById('update_password_btn').disabled = false;
		}
	}
</script>
<script type="text/javascript">
	var totalAttendance = 50;
        var presentCount = 20;
        var absentCount = totalAttendance - presentCount;

        // Create a data array for the pie chart
        var data = {
            labels: ['Present', 'Absent'],
            datasets: [{
                data: [presentCount, absentCount],
                backgroundColor: ['#36A2EB', '#FFCE56']
            }]
        };

        // Get the canvas element and create a pie chart
        var ctx = document.getElementById('attendanceChart').getContext('2d');
        var myPieChart = new Chart(ctx, {
            type: 'pie',
            data: data
        });
    </script>
    @endsection