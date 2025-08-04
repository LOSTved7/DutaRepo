<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use App\Models\College;
use DB;
use Auth;
use Crypt;
use Session;
use App\Models\DU_colleges;

class Staff_detailController extends Controller
{
    
    public function __construct() {
        $this->current_menu = 'staff_details';
      } 

    public function index(Request $request)
    {
        $users_id=Auth::user()->id;
        $college_name = !empty($request->college_name) ? $request->college_name : NULL;
        $grade = !empty($request->grade) ? $request->grade : NULL;
        $department = !empty($request->department) ? $request->department : NULL;
        $designation = !empty($request->designation) ? $request->designation : NULL;
        $user_profile = DB::table('users')->whereIn('role_id',[59,60])->pluck('name', 'id');
        $staff_profile = DB::table('staff_profile')->where('users_id',$users_id)->first();
        $staff_college_mapping = DB::table('staff_college_mapping')->join('staff_detail','staff_detail.college_name','staff_college_mapping.college_name');
        if(Auth::user()->role_id ==60 && !empty($staff_profile)){
            $staff_college_mapping = $staff_college_mapping->where('staff_profile_id', $staff_profile->id);
        }
        $staff_college_mapping =$staff_college_mapping->distinct()->pluck('staff_detail.college_name');
        $data=DB::table('staff_detail')
                ->where('status','!=',9);
                if(Auth::user()->role_id ==60 && !empty($staff_profile)){
                    $data = $data->whereIn('college_name', $staff_college_mapping);
                }
                if(!empty($college_name)){
                    $data->where('college_name', $college_name);
                }
                if(!empty($grade)){
                    $data->where('grade', $grade);
                }
                if(!empty($designation)){
                    $data->where('designation', $designation);
                }
                if(!empty($department)){
                    $data->where('department', $department);
                }
                $data = $data->get();
        $duColleges = DB::table('staff_detail');
        if(!empty($department)){
            $duColleges->where('department', $department);
        }
        if(!empty($designation)){
            $duColleges->where('designation', $designation);
        }
        $duColleges=$duColleges->where('status', 1)->groupBy('college_name')->pluck('college_name');
        // dd($duColleges);

        $department_mast = DB::table('staff_detail');
        if(!empty($college_name)){
            $department_mast->where('college_name', $college_name);
        }
        if(Auth::user()->role_id ==60 && !empty($staff_profile)){
            $department_mast = $department_mast->whereIn('college_name', $staff_college_mapping);
        }
        if(!empty($designation)){
            $department_mast->where('designation', $designation);
        }
        $department_mast=$department_mast->where('status', 1)->groupBy('department')->pluck('department');
        // dd($college_name);

        $designation_mast = DB::table('staff_detail');
        if(!empty($college_name)){
            $designation_mast->where('college_name', $college_name);
        }
        if(Auth::user()->role_id ==60 && !empty($staff_profile)){
            $designation_mast = $designation_mast->whereIn('college_name', $staff_college_mapping);
        }
        if(!empty($department)){
            $designation_mast->where('department', $department);
        }
        $designation_mast=$designation_mast->where('status', 1)->groupBy('designation')->pluck('designation');
        return view('staff_details/index',[
            'current_menu' => $this->current_menu,
            'data' => $data,
            'department' => $department,
            'department_mast' => $department_mast,
            'designation_mast' => $designation_mast,
            'user_profile' => $user_profile,
            'duColleges' => $duColleges,
            'staff_college_mapping' => $staff_college_mapping,
        ]);
    }

    public function create()
    {
        $users_id = Auth::user()->id;
        // $duColleges = DU_colleges::getData();
        $duColleges = DB::table('staff_detail')
                        ->where('status', 1)
                        ->groupBy('college_name')
                        ->pluck('college_name');

        // $department = DB::table('department_mast')->where('status', 1)->pluck('department_name', 'id');
        $college_mapped = DB::table('staff_college_mapping')
                            ->join('staff_profile','staff_college_mapping.staff_profile_id','staff_profile.id')
                            ->where('staff_profile.users_id',$users_id)
                            ->where('staff_college_mapping.status',1)
                            ->pluck('staff_college_mapping.college_name');

        return view('staff_details/create', [
            'current_menu' => $this->current_menu,
            // 'department' => $department,
            'duColleges'=>$duColleges,
            'college_mapped'=>$college_mapped
        ]);
    }

    public function store(Request $request)
    {
        // dd($request);
        $college_name = !empty($request->college_name) ? $request->college_name : NULL;
        $name = !empty($request->name) ? $request->name : NULL;
        $mobile_no1 = !empty($request->mobile_no1) ? $request->mobile_no1 : NULL;
        $mobile_no2 = !empty($request->mobile_no2) ? $request->mobile_no2 : NULL;
        $mobile_no3 = !empty($request->mobile_no3) ? $request->mobile_no3 : NULL;
        $email1 = !empty($request->email1) ? $request->email1 : NULL;
        $email2 = !empty($request->email2) ? $request->email2 : NULL;
        $grade = !empty($request->grade) ? $request->grade : NULL;
        $department = !empty($request->department) ? $request->department : NULL;
        $designation = !empty($request->designation) ? $request->designation : NULL;
        $status = !empty($request->status) ? $request->status : 1;
        $exsist = !empty($request->id) ? $request->id : NULL;
         $whatsapp = !empty($request->whatsapp) ? $request->whatsapp : NULL;
        if(empty($whatsapp)){
            return redirect()->back()->with('error','WhatsApp number is required.');
        }
        $created_at = date('Y-m-d H:i:s');
        $created_by = Auth::user()->id;
       $Arr = [
            'name'=> $name,
            'mobile_no1'=> $mobile_no1,
            'mobile_no2'=> $mobile_no2,
            'mobile_no3'=> $mobile_no3,
            'whatsapp'=> $whatsapp,
            'email1'=> $email1,
            'email2'=> $email2,
            'college_name'=> $college_name,
            'grade'=> $grade,
            'department'=> $department,
            'designation'=> $designation,
            'status'=> $status,
            'created_at'=> $created_at,
            'created_by'=> $created_by,
        ];
         if(!empty($exsist) && $exsist !==Null){
             $query = DB::table('staff_detail')->where('id',$exsist)->update([
                            'name'=> $name,
                            'mobile_no1'=> $mobile_no1,
                            'mobile_no2'=> $mobile_no2,
                            'mobile_no3'=> $mobile_no3,
                            'whatsapp'=> $whatsapp,
                            'email1'=> $email1,
                            'email2'=> $email2,
                            'college_name'=> $college_name,
                            'grade'=> $grade,
                            'department'=> $department,
                            'designation'=> $designation,
                            'status'=> $status,
                            'updated_at'=> $created_at,
                            'updated_by'=> $created_by,
                        ]);
            $message = 'Entry Updated Successfully';
        }else{
             $query = DB::table('staff_detail')->insert($Arr);
             $message = 'Entry Created Successfully';
        }
        if ($query) {
            DB::commit();
            Session::flash('message', $message);
        } else {
            DB::rollback();
            Session::flash('error', 'Something Went Wrong');
        }

        return redirect($this->current_menu);
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $decrypted_id = Crypt::decryptString($id);
        $data = DB::table('staff_detail')
            ->where('id', $decrypted_id)
            ->where('status', '!=', 9)
            ->first();
                $department = DB::table('department_mast')->where('status', 1)->pluck('department_name', 'id');

        if (!$data) {
            return redirect()->back()->with('error', 'Staff not found.');
        }
        $encrypted_id = $id;

        return view('staff_details.edit', [
            'data' => $data,
            'current_menu' => $this->current_menu,
            'encrypted_id' => $encrypted_id,
            'department' => $department,
        ]);
    }
    
    public function update(Request $request, $id)
{
    $decrypted_id = Crypt::decryptString($id);
    $college_name = !empty($request->college_name) ? $request->college_name : NULL;
    $name = !empty($request->name) ? $request->name : NULL;
    $mobile_no1 = !empty($request->mobile_no1) ? $request->mobile_no1 : NULL;
    $mobile_no2 = !empty($request->mobile_no2) ? $request->mobile_no2 : NULL;
    $mobile_no3 = !empty($request->mobile_no3) ? $request->mobile_no3 : NULL;
    $email1 = !empty($request->email1) ? $request->email1 : NULL;
    $email2 = !empty($request->email2) ? $request->email2 : NULL;
    $grade = !empty($request->grade) ? $request->grade : NULL;
    $department = !empty($request->department) ? $request->department : NULL;
    $designation = !empty($request->designation) ? $request->designation : NULL;
    $status = !empty($request->status) ? $request->status : 1;
    $whatsapp = !empty($request->whatsapp) ? $request->whatsapp : NULL;
    if(empty($whatsapp)){
        return redirect()->back()->with('error','WhatsApp number is required.');
    }
    $updated_at = date('Y-m-d H:i:s');
    $updated_by = Auth::user()->id;

    $staff = DB::table('staff_detail')->where('id', $decrypted_id)->first();
    if (!$staff) {
        Session::flash('error', 'Staff record not found.');
        return redirect($this->current_menu);
    }
    $staff_arr = [
        'name'=> $name,
        'mobile_no1'=> $mobile_no1,
        'mobile_no2'=> $mobile_no2,
        'mobile_no3'=> $mobile_no3,
        'whatsapp'=> $whatsapp,
        'email1'=> $email1,
        'email2'=> $email2,
        'college_name'=> $college_name,
        'grade'=> $grade,
        'department'=> $department,
        'designation'=> $designation,
        'status'=> $status,
        'updated_at'=> $updated_at,
        'updated_by'=> $updated_by,
    ];
    DB::beginTransaction();

        $query = DB::table('staff_detail')->where('id', $decrypted_id)->update($staff_arr);

        if ($query !== false) {
            DB::commit();
            Session::flash('message', 'Entry Updated Successfully');
        } else {
            DB::rollBack();
            Session::flash('error', 'Something Went Wrong');
        }

    return redirect($this->current_menu);
}


    public function destroy($id)
    {
        $decrypted_id = Crypt::decryptString($id);
    
    DB::beginTransaction();
    $query=DB::table('staff_detail')->where('id',$decrypted_id)->update(['status' => 9]);
    DB::commit();

    return redirect()->route($this->current_menu.'.index');
    }
    public function upload(Request $request){
        // dd($request);
        $auth = Auth::user();
        $staff_profile = DB::table('staff_profile')->where('users_id',$auth->id)->first();
        $college_name = DB::table('staff_college_mapping');
        if($auth->role_id != 59 && !empty($staff_profile)){
            $college_name = $college_name->where('staff_profile_id', $staff_profile->id);
        }
        $college_name =$college_name->pluck('college_name');
        $duColleges = DU_colleges::pluck('college_name');



        if($request->hasFile('excel')){
                        $college_name = !empty($request->college_name) ? $request->college_name : NULL;
                        if(empty($college_name)){
                            Session::flash('message', 'Please select college name.');
                            Session::flash('alert-class', 'alert-danger');
                            return redirect()->back();
                        }
                        $file = !empty($request->file('excel'))?$request->file('excel'):null;
                        $extension = $file->getClientOriginalExtension();
                        $fileName = date('YmdHis').rand(10,99).trim($college_name).'.'.$extension;
                        $filePath =$file->move('staff_upload_file',$fileName);
                        $final_arr = [];
                    if (($getfile = fopen($filePath, "r")) !== FALSE) {
                        $data = fgetcsv($getfile, 1000, ",");
                        $exist_data1 = DB::table('staff_detail')->where('status',1)->whereNotNull('mobile_no1')->where('mobile_no1','!=','')->pluck('mobile_no1')->toArray();
                        $exist_data2 = DB::table('staff_detail')->where('status',1)->whereNotNull('mobile_no2')->where('mobile_no2','!=','')->pluck('mobile_no2')->toArray();
                        $exist_data3 = DB::table('staff_detail')->where('status',1)->whereNotNull('mobile_no3')->where('mobile_no3','!=','')->pluck('mobile_no3')->toArray();
                        $exist_data = array_merge($exist_data1,$exist_data2,$exist_data3);
                        while (($data = fgetcsv($getfile, 1000, ",")) !== FALSE) {
                            if(in_array($data[6], $exist_data) || in_array($data[7], $exist_data) || in_array($data[8], $exist_data)){
                              continue;
                            }
                            $final_arr[] = [
                                'college_name'=>$college_name,
                                'name'=> !empty($data[0])?$data[0]:'',
                                'grade'=> !empty($data[1])?$data[1]:'',
                                'department'=> !empty($data[2])?$data[2]:'',
                                'designation'=> !empty($data[3])?$data[3]:'',
                                'email1'=> !empty($data[4])?$data[4]:'',
                                'email2'=> !empty($data[5])?$data[5]:'',
                                'mobile_no1'=> !empty($data[6])?$data[6]:'',
                                'mobile_no2'=> !empty($data[7])?$data[7]:'',
                                'mobile_no3'=> !empty($data[8])?$data[8]:'',
                                'whatsapp'=> !empty($data[9])?$data[9]:'',
                                'status'=> 1,
                                'created_at'=> date('Y-m-d H:i:s'),
                                'created_by'=> Auth::user()->id,
                            ];
                        }
                    }
                    // dd($final_arr);
                    DB::beginTransaction();
                    DB::table('staff_detail')->insert($final_arr);
                    DB::commit();
                    Session::flash('message', 'data uploaded successfully.');
                    Session::flash('alert-class', 'alert-success');
                    return redirect('staff_details');
            }

        return view('staff_details/upload', [
            'current_menu' => $this->current_menu,
            'college_name'=>$college_name,
            'duColleges'=>$duColleges
        ]);
}


public function get_staff_by_college(Request $request){
    // dd($request);
    $college_name = !empty($request->college_name)?$request->college_name:'';
    $dept_filt = !empty($request->department)?$request->department:'';
    $desig_filt = !empty($request->designation)?$request->designation:'';
    $current_url = !empty($request->current_url)?$request->current_url:'';
    $staff_profile = DB::table('staff_profile')->where('users_id',Auth::user()->id)->first();
    $staff_college_mapping = DB::table('staff_college_mapping')->join('staff_detail','staff_detail.college_name','staff_college_mapping.college_name');
    if(Auth::user()->role_id ==60 && !empty($staff_profile)){
        $staff_college_mapping = $staff_college_mapping->where('staff_profile_id', $staff_profile->id);
    }
    $staff_college_mapping =$staff_college_mapping->distinct()->pluck('staff_detail.college_name');


    $department_data = DB::table('staff_detail');
    if(!empty($college_name)){
           $department_data ->where('college_name',$college_name);
    }else if(Auth::user()->role_id==60){
        $department_data ->whereIn('college_name', $staff_college_mapping);
    }
    if(!empty($desig_filt)){
           $department_data ->where('designation',$desig_filt);
    }
    if($current_url=='staff_details_create'){
           $department_data ->where('college_name',$college_name);
    }
     $department_data = $department_data->groupBy('department')
            ->pluck('department')->toArray();

            
    $designation_data = DB::table('staff_detail');
    if(!empty($college_name)){
           $designation_data ->where('college_name',$college_name);
    }else if(Auth::user()->role_id==60){
        $designation_data ->whereIn('college_name', $staff_college_mapping);
    }
    if(!empty($dept_filt)){
           $designation_data ->where('department',$dept_filt);
    }
    if($current_url=='staff_details_create'){
           $designation_data ->where('college_name',$college_name);
    }
     $designation_data = $designation_data->groupBy('designation')
            ->pluck('designation')->toArray();
    $data['department']=$department_data;
    $data['designation']=$designation_data;
            
            return response()->json($data);
}
public function get_staff_by_department(Request $request){
    $department = !empty($request->department)?$request->department:'';
    $college_name = !empty($request->college_name)?$request->college_name:'';
    $designation = !empty($request->designation)?$request->designation:'';
     $staff_profile = DB::table('staff_profile')->where('users_id',Auth::user()->id)->first();
    $staff_college_mapping = DB::table('staff_college_mapping')->join('staff_detail','staff_detail.college_name','staff_college_mapping.college_name');
    if(Auth::user()->role_id ==60 && !empty($staff_profile)){
        $staff_college_mapping = $staff_college_mapping->where('staff_profile_id', $staff_profile->id);
    }
    $staff_college_mapping =$staff_college_mapping->distinct()->pluck('staff_detail.college_name');
    $college_data = DB::table('staff_detail');
    if(!empty($department)){
           $college_data ->where('department',$department);
    }
    if(!empty($designation)){
           $college_data ->where('designation',$designation);
    }
     $college_data = $college_data->groupBy('college_name')
            ->pluck('college_name')->toArray();
            
    $designation_data = DB::table('staff_detail');
    if(!empty($department)){
           $designation_data ->where('department',$department);
    }
    if(!empty($college_name)){
           $designation_data ->where('college_name',$college_name);
    }else if(Auth::user()->role_id==60){
        $designation_data ->whereIn('college_name', $staff_college_mapping);
    }
     $designation_data = $designation_data->groupBy('designation')
            ->pluck('designation')->toArray();
    $data['college_name']=$college_data;
    $data['designation']=$designation_data;
            
            return response()->json($data);
}
public function get_staff_by_designation(Request $request){
    $designation = !empty($request->designation)?$request->designation:'';
    $department = !empty($request->department)?$request->department:'';
    $college_name = !empty($request->college_name)?$request->college_name:'';
     $staff_profile = DB::table('staff_profile')->where('users_id',Auth::user()->id)->first();
    $staff_college_mapping = DB::table('staff_college_mapping')->join('staff_detail','staff_detail.college_name','staff_college_mapping.college_name');
    if(Auth::user()->role_id ==60 && !empty($staff_profile)){
        $staff_college_mapping = $staff_college_mapping->where('staff_profile_id', $staff_profile->id);
    }
    $staff_college_mapping =$staff_college_mapping->distinct()->pluck('staff_detail.college_name');
    $college_data = DB::table('staff_detail');
    if(!empty($designation)){
           $college_data->where('designation',$designation);
    }
    if(!empty($department)){
           $college_data->where('department',$department);
    }
     $college_data = $college_data->groupBy('college_name')
            ->pluck('college_name')->toArray();
    $department_data = DB::table('staff_detail');
    if(!empty($designation)){
           $department_data->where('designation',$designation);
    }
    if(!empty($college_name)){
           $department_data ->where('college_name',$college_name);
    }else if(Auth::user()->role_id==60){
        $department_data->whereIn('college_name', $staff_college_mapping);
    }
     $department_data = $department_data->groupBy('department')
            ->pluck('department')->toArray();
    $data['college_name']=$college_data;
    $data['department']=$department_data;

    return response()->json($data);
}
public function find_staff_by_contact_no(Request $request){
    $contact_no = !empty($request->contact_no)?$request->contact_no:'';
    $data = DB::table('staff_detail')->where('mobile_no1',$contact_no)->first();
    return response()->json($data);
}

}