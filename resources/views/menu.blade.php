<?php 
	use App\Models\Modules;
	use App\Models\Faculty;

	$auth_data = Auth::user();

	$role_id = !empty($auth_data->role_id)?$auth_data->role_id:NULL;
    $college_id = !empty($auth_data->college_id)?$auth_data->college_id:NULL;

	$module_arr = Modules::getAssignedModules( $role_id);
	// dd($module_arr,12121212);
	$parent_arr = $module_arr['parent'];
	$child_arr = $module_arr['child'];
 	$is_tic = 0;
	if($role_id == 4){
		$is_tic = Faculty::where('users_id',Auth::user()->id)->first()->Is_TIC;
	}
?>

@foreach($parent_arr as $parent_id => $parent_data)
	<li>
		@if($parent_data['url']=='#' || empty($parent_data['url']))
		<a class="has-arrow" href="javascript:;">
		@else
		<a  href="{{url($parent_data['url'])}}">
		@endif
			<div class="parent-icon"><i class="{{$parent_data['icon']}}"></i>
			</div>
			<div class="menu-title">{{$parent_data['name']}}</div>
		</a>

		@if(!empty($child_arr[$parent_id]))
			@foreach($child_arr[$parent_id] as $child_id => $child_data)
				<ul>
					<li><a  href="{{url($child_data['url'])}}"><i class="{{$child_data['icon']}}"></i>{{$child_data['name']}}</a></li>
				</ul>
			@endforeach
		@endif
	</li>
@endforeach

@if($is_tic == 1)
	<li>
		<a class="has-arrow" href="javascript:;">
			<div class="parent-icon"><i class="bx bx-message-square-edit"></i>
			</div>
			<div class="menu-title">Student NOC</div>
		</a>
				<ul>
					<li><a  href="{{url('list_noc_applications')}}"><i class="bx bx-radio-circle"></i>Student NOC Request</a></li>
				</ul>
	</li>
	<li>
		<a href="{{url('subjectwise_student_report')}}">
			<div class="parent-icon"><i class="bx bx-message-square-edit"></i>
			</div>
			<div class="menu-title">Subject-Wise Student List</div>
		</a>
	</li>
	<li>
		<a href="{{url('subject_approval_sem_7')}}">
			<div class="parent-icon"><i class="bx bx-message-square-edit"></i>
			</div>
			<div class="menu-title">Student Preference - Sem 7</div>
		</a>
	</li>
	<li>
		<a href="{{url('department_wise_time_table_index')}}">
			<div class="parent-icon"><i class="bx bx-message-square-edit"></i>
			</div>
			<div class="menu-title">Departmental Time Table</div>
		</a>
	</li>
@endif
