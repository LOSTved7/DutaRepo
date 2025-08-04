<!DOCTYPE html>
<html lang="en">

<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!--favicon-->
	<link rel="icon" href="{{asset('assets/images/favicon-32x32.png')}}" type="image/png" />
	<!-- loader-->
	{{--
	<link href="{{asset('assets/css/pace.min.css')}}" rel="stylesheet" />
	<script src="{{asset('assets/js/pace.min.js')}}"></script>
	--}}
	<!-- Bootstrap CSS -->
	<link href="{{asset('assets/css/bootstrap.min.css')}}" rel="stylesheet">
	<link href="{{asset('assets/css/bootstrap-extended.css')}}" rel="stylesheet">
	<link href="{{asset('assets/css/app.css')}}" rel="stylesheet">
	<link href="{{asset('assets/css/icons.css')}}" rel="stylesheet">
	<link href="{{asset('assets/css/pace.min.css')}}" rel="stylesheet" />

	<style type="text/css">
		#overlay{ 
		  	position: fixed;
		  	top: 0;
		  	z-index: 100;
		  	width: 100%;
		  	height:100%;
		  	display: none;
		  	background: rgba(0,0,0,0.6);
		}
		.cv-spinner {
		  	height: 100%;
		  	display: flex;
		  	justify-content: center;
		  	align-items: center;  
		}
		.spinner {
		  	width: 40px;
		  	height: 40px;
		  	border: 4px #ddd solid;
		  	border-top: 4px #2e93e6 solid;
		  	border-radius: 50%;
		  	animation: sp-anime 0.8s infinite linear;
		}
		@keyframes sp-anime {
		  	100% { 
		    	transform: rotate(360deg); 
		  	}
		}
	</style>

	<title>College ERP</title>
</head>

<body class="">
	<div id="overlay">
	    <div class="cv-spinner">
	        <span class="spinner"></span>
	    </div>
	</div>
	<!-- wrapper -->
	<div class="wrapper">
		<div class="authentication-forgot d-flex align-items-center justify-content-center">
			<div class="card forgot-box">
				<div class="card-body">
					<div class="p-3">
						<div class="text-center">
							<img src="assets/images/icons/forgot-2.png" width="100" alt="" />
						</div>
						<h4 class="mt-5 font-weight-bold" id="main_heading">Enter OTP</h4>
						<p class="text-muted" id="supporting_text">OTP has been sent on your registered email id.</p>
							
							<div class="my-4">
								<label class="form-label"><b>One Time Password (OTP)</b></label>
								<input type="text" name="otp" id="otp" class="form-control" placeholder="" required />
							</div>
						
						
							<div class="d-grid gap-2" id="submit_btn_div">
								<button type="submit" class="btn btn-primary" onclick="submit_form()">SUBMIT</button>
								 {{--<a href="{{url('/')}}" class="btn btn-light">--}}
								 <a href="javascript:history.go(-1)">
								 	<i class='bx bx-arrow-back me-1'></i>
								 Go Back
								</a>
							</div>
						

					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end wrapper -->
</body>
{{--
	<script src="{{asset('assets/js/pace.min.js')}}"></script>
--}}

<script type="text/javascript" src="{{asset('assets/js/jquery.min.js')}}"></script>
<script type="text/javascript">
	var token = '';
	function submit_form() {
		var otp = document.getElementById('otp').value;
		if(otp == undefined || otp == '') {
			alert('Please Enter OTP');
		}
		else {	//user id is passed
			//call ajax
			$("#overlay").show();
			$.ajaxSetup({
			    headers: {
			        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			    }
			});
			$.ajax({
			    type: "post",
			    url:  '{{route("verify_otp_submit")}}',
			    dataType: 'json',
			    data: {
			    	'otp': otp,
			    	'_token' : '{{ csrf_token() }}'
			    },
			    success: function (data) {
			    	 $( "#overlay").hide();
			        if(data.code == 401) { }

			        else if(data.code == 200) { 
			            if(data.alert_message == undefined) {
			            	if(data.token==undefined) {
			            		// alert('Please Try Again Later');
			            		window.location.href = data.url;
			            	}
			            	else {
			            		
			            	}
			            }
			            else{
			                alert(data.alert_message);
			            }
			        }
			    }
			});
		}
	}
</script>

</html>