<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use App\Models\College;
use DB;
use Auth;
use Crypt;
use Session;
use App\Models\DU_colleges;

class Staff_personal_detailController extends Controller
{
    
    public function __construct() {
        $this->current_menu = 'staff_personal_details';
      } 

    public function index(Request $request)
    {
        $users_id=Auth::user()->id;
        $college_name = !empty($request->college_name) ? $request->college_name : NULL;
        $grade = !empty($request->grade) ? $request->grade : NULL;
        $duColleges_mast = DU_colleges::pluck('college_name','id');
        $user_profile = DB::table('users')->whereIn('role_id',[59,60])->pluck('name', 'id');
        $staff_profile = DB::table('staff_profile')->where('users_id',$users_id)->first();
        $staff_college_mapping = DB::table('gat_nayak_college_mapping')->join('staff_profile','staff_profile.id','gat_nayak_college_mapping.staff_profile_id');
        if(Auth::user()->role_id ==60 && !empty($staff_profile)){
            $staff_college_mapping = $staff_college_mapping->where('staff_profile_id', $staff_profile->id);
        }
        $staff_college_mapping =$staff_college_mapping->distinct()->pluck('gat_nayak_college_mapping.college_name');
       $data = DB::table('candidate_mappings')
                ->where('status','!=',9);

            if(Auth::user()->role_id==60 && !empty($staff_profile)){
                $data->whereIn('college_name', $staff_college_mapping);
            }
            if(!empty($college_name)){
                $data->where('college_name', $college_name);
            }
            $data = $data->get();
        $duColleges = DB::table('candidate_mappings');
        $duColleges=$duColleges->where('status', 1)->groupBy('college_name')->pluck('college_name');
        return view('staff_personal_details/index',[
            'current_menu' => $this->current_menu,
            'data' => $data,
            'user_profile' => $user_profile,
            'duColleges' => $duColleges,
            'duColleges_mast' => $duColleges_mast,
            'staff_college_mapping' => $staff_college_mapping,
        ]);
    }

    public function create()
    {
        $users_id = Auth::user()->id;
        // $duColleges = DU_colleges::getData();
        $duColleges_mast = DU_colleges::pluck('college_name','id');
        $department = DB::table('staff_detail')->where('status', 1)->groupBy('department')->pluck('department');
        $college_mapped = DB::table('staff_college_mapping')
                            ->join('staff_profile','staff_college_mapping.staff_profile_id','staff_profile.id')
                            ->where('staff_profile.users_id',$users_id)
                            ->where('staff_college_mapping.status',1)
                            ->pluck('staff_profile.college_name');

        return view('staff_personal_details/create', [
            'current_menu' => $this->current_menu,
            'department' => $department,
            'college_mapped'=>$college_mapped,
            'duColleges_mast'=>$duColleges_mast,
        ]);
    }

    public function store(Request $request)
    {
        $college_name = !empty($request->college_name) ? $request->college_name : NULL;
        $name = !empty($request->name) ? $request->name : NULL;
        $contact_no = !empty($request->contact_no) ? $request->contact_no : NULL;
        $email1 = !empty($request->email1) ? $request->email1 : NULL;
        $department = !empty($request->department) ? $request->department : NULL;
        $status = !empty($request->status) ? $request->status : 1;
        $created_at = date('Y-m-d H:i:s');
        $created_by = Auth::user()->id;
       $Arr = [
            'name'=> $name,
            'mobile'=> $contact_no,
            'candidate_profile_id'=> $created_by,
            'email'=> $email1,
            'college_name'=> $college_name,
            'department'=> $department,
            'status'=> $status,
            'created_at'=> $created_at,
            'created_by'=> $created_by,
        ];
             $query = DB::table('candidate_mappings')->insert($Arr);
             $message = 'Entry Created Successfully';
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
        $staff_profile_id = DB::table('staff_profile')->where('users_id',Auth::user()->id)->pluck('id')->first();
        $data = DB::table('candidate_mappings')
            ->where('id', $decrypted_id)
            ->where('status', '!=', 9)
            ->first();
        $duColleges_mast = DU_colleges::pluck('college_name','id');
        if (!$data) {
            return redirect()->back()->with('error', 'Staff not found.');
        }
        $encrypted_id = $id;
        $department = DB::table('staff_detail')->where('status', 1)->groupBy('department')->pluck('department');
        return view('staff_personal_details.edit', [
            'data' => $data,
            'current_menu' => $this->current_menu,
            'encrypted_id' => $encrypted_id,
            'duColleges_mast' => $duColleges_mast,
            'department' => $department,
        ]);
    }
    
    public function update(Request $request, $id)
{
    $decrypted_id = Crypt::decryptString($id);
    // dd($request,$decrypted_id);
    $college_name = !empty($request->college_name) ? $request->college_name : NULL;
        $name = !empty($request->name) ? $request->name : NULL;
        $contact_no = !empty($request->contact_no) ? $request->contact_no : NULL;
        $email1 = !empty($request->email1) ? $request->email1 : NULL;
        $department = !empty($request->department) ? $request->department : NULL;
        $status = !empty($request->status) ? $request->status : 1;
        $created_at = date('Y-m-d H:i:s');
        $created_by = Auth::user()->id;
     $Arr = [
            'name'=> $name,
            'mobile'=> $contact_no,
            'candidate_profile_id'=> $created_by,
            'email'=> $email1,
            'college_name'=> $college_name,
            'department'=> $department,
            'status'=> $status,
            'created_at'=> $created_at,
            'created_by'=> $created_by,
        ];
    // dd($staff_arr);
    DB::beginTransaction();

        $query = DB::table('candidate_mappings')->where('id', $decrypted_id)->update($Arr);

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
    $query=DB::table('candidate_mappings')->where('id',$decrypted_id)->update(['status' => 9]);
    DB::commit();

    return redirect()->route($this->current_menu.'.index');
    }
//     public function upload(Request $request){
//         $auth = Auth::user();
//         $staff_profile = DB::table('staff_profile')->where('users_id',$auth->id)->first();
//         $duColleges = DU_colleges::pluck('college_name','id');
//          if(Auth::user()->role_id==60){
//             $staff_profile_id = DB::table('staff_profile')->join('users', 'staff_profile.users_id', '=', 'users.id')->where('staff_profile.users_id',Auth::user()->id)->pluck( 'staff_profile.id');

//             $duColleges = DB::table('gat_nayak_college_mapping')
//                           ->where('staff_profile_id',$staff_profile_id)
//                           ->where('status',1) 
//                           ->pluck('college_name');
//         }
//         if($request->hasFile('excel')){
//                         $college_name = !empty($request->college_name) ? $request->college_name : NULL;
//                         if(empty($college_name)){
//                             Session::flash('message', 'Please select college name.');
//                             Session::flash('alert-class', 'alert-danger');
//                             return redirect()->back();
//                         }
//                         $file = !empty($request->file('excel'))?$request->file('excel'):null;
//                         $extension = $file->getClientOriginalExtension();
//                         $fileName = date('YmdHis').rand(10,99).trim($duColleges[$college_name]).'.'.$extension;
//                         $filePath =$file->move('staff_upload_file',$fileName);
//                         $final_arr = [];
//                     if (($getfile = fopen($filePath, "r")) !== FALSE) {
//                         $data = fgetcsv($getfile, 1000, ",");
//                         $exist_data1 = DB::table('candidate_mappings')->where('status',1)->whereNotNull('mobile_no1')->where('mobile_no1','!=','')->pluck('mobile_no1')->toArray();
//                         $exist_data2 = DB::table('candidate_mappings')->where('status',1)->whereNotNull('mobile_no2')->where('mobile_no2','!=','')->pluck('mobile_no2')->toArray();
//                         $exist_data3 = DB::table('candidate_mappings')->where('status',1)->whereNotNull('mobile_no3')->where('mobile_no3','!=','')->pluck('mobile_no3')->toArray();
//                         $exist_data = array_merge($exist_data1,$exist_data2,$exist_data3);
//                         while (($data = fgetcsv($getfile, 1000, ",")) !== FALSE) {
//                             if(in_array($data[6], $exist_data) || in_array($data[7], $exist_data) || in_array($data[8], $exist_data)){
//                               continue;
//                             }
//                             $final_arr[] = [
//                                 'college_name'=>$college_name,
//                                 'name'=> !empty($data[0])?$data[0]:'',
//                                 'grade'=> !empty($data[1])?$data[1]:'',
//                                 'department'=> !empty($data[2])?$data[2]:'',
//                                 'designation'=> !empty($data[3])?$data[3]:'',
//                                 'email1'=> !empty($data[4])?$data[4]:'',
//                                 'email2'=> !empty($data[5])?$data[5]:'',
//                                 'mobile_no1'=> !empty($data[6])?$data[6]:'',
//                                 'mobile_no2'=> !empty($data[7])?$data[7]:'',
//                                 'mobile_no3'=> !empty($data[8])?$data[8]:'',
//                                 'whatsapp'=> !empty($data[9])?$data[9]:'',
//                                 'college_code'=> !empty($data[10])?$data[10]:'',
//                                 'status'=> 1,
//                                 'created_at'=> date('Y-m-d H:i:s'),
//                                 'created_by'=> Auth::user()->id,
//                             ];
//                         }
//                     }
//                     // dd($final_arr);
//                     DB::beginTransaction();
//                     DB::table('candidate_mappings')->insert($final_arr);
//                     DB::commit();
//                     Session::flash('message', 'data uploaded successfully.');
//                     Session::flash('alert-class', 'alert-success');
//                     return redirect('staff_details');
//             }

//         return view('staff_details/upload', [
//             'current_menu' => $this->current_menu,
//             // 'college_name'=>$college_name,
//             'duColleges'=>$duColleges
//         ]);
// }


// public function get_staff_by_college(Request $request){
//     // dd($request);
//     $college_name = !empty($request->college_name)?$request->college_name:'';
//     $dept_filt = !empty($request->department)?$request->department:'';
//     $desig_filt = !empty($request->designation)?$request->designation:'';
//     $current_url = !empty($request->current_url)?$request->current_url:'';
//     $staff_profile = DB::table('staff_profile')->where('users_id',Auth::user()->id)->first();
//     $staff_college_mapping = DB::table('staff_college_mapping')->join('staff_detail','staff_detail.id','staff_college_mapping.staff_detail_id');
//     if(Auth::user()->role_id ==60 && !empty($staff_profile)){
//         $staff_college_mapping = $staff_college_mapping->where('staff_profile_id', $staff_profile->id);
//     }
//     $staff_college_mapping =$staff_college_mapping->distinct()->pluck('staff_detail.college_name');


//     $department_data = DB::table('candidate_mappings');
//     if(!empty($college_name)){
//            $department_data ->where('college_name',$college_name);
//     }else if(Auth::user()->role_id==60){
//         $department_data ->whereIn('college_name', $staff_college_mapping);
//     }
//     if(!empty($desig_filt)){
//            $department_data ->where('designation',$desig_filt);
//     }
//     if($current_url=='staff_details_create'){
//            $department_data ->where('college_name',$college_name);
//     }
//      $department_data = $department_data->groupBy('department')
//             ->pluck('department')->toArray();

            
//     $designation_data = DB::table('candidate_mappings');
//     if(!empty($college_name)){
//            $designation_data ->where('college_name',$college_name);
//     }else if(Auth::user()->role_id==60){
//         $designation_data ->whereIn('college_name', $staff_college_mapping);
//     }
//     if(!empty($dept_filt)){
//            $designation_data ->where('department',$dept_filt);
//     }
//     if($current_url=='staff_details_create'){
//            $designation_data ->where('college_name',$college_name);
//     }
//      $designation_data = $designation_data->groupBy('designation')
//             ->pluck('designation')->toArray();
//     $data['department']=$department_data;
//     $data['designation']=$designation_data;
            
//             return response()->json($data);
// }
// public function get_staff_by_department(Request $request){
//     $department = !empty($request->department)?$request->department:'';
//     $college_name = !empty($request->college_name)?$request->college_name:'';
//     $designation = !empty($request->designation)?$request->designation:'';
//      $staff_profile = DB::table('staff_profile')->where('users_id',Auth::user()->id)->first();
//     $staff_college_mapping = DB::table('staff_college_mapping')->join('staff_detail','staff_detail.id','staff_college_mapping.staff_detail_id');
//     if(Auth::user()->role_id ==60 && !empty($staff_profile)){
//         $staff_college_mapping = $staff_college_mapping->where('staff_profile_id', $staff_profile->id);
//     }
//     $staff_college_mapping =$staff_college_mapping->distinct()->pluck('staff_detail.college_name');
//     $college_data = DB::table('candidate_mappings');
//     if(!empty($department)){
//            $college_data ->where('department',$department);
//     }
//     if(!empty($designation)){
//            $college_data ->where('designation',$designation);
//     }
//      $college_data = $college_data->groupBy('college_name')
//             ->pluck('college_name')->toArray();
            
//     $designation_data = DB::table('candidate_mappings');
//     if(!empty($department)){
//            $designation_data ->where('department',$department);
//     }
//     if(!empty($college_name)){
//            $designation_data ->where('college_name',$college_name);
//     }else if(Auth::user()->role_id==60){
//         $designation_data ->whereIn('college_name', $staff_college_mapping);
//     }
//      $designation_data = $designation_data->groupBy('designation')
//             ->pluck('designation')->toArray();
//     $data['college_name']=$college_data;
//     $data['designation']=$designation_data;
            
//             return response()->json($data);
// }
// public function get_staff_by_designation(Request $request){
//     $designation = !empty($request->designation)?$request->designation:'';
//     $department = !empty($request->department)?$request->department:'';
//     $college_name = !empty($request->college_name)?$request->college_name:'';
//      $staff_profile = DB::table('staff_profile')->where('users_id',Auth::user()->id)->first();
//     $staff_college_mapping = DB::table('staff_college_mapping')->join('staff_detail','staff_detail.id','staff_college_mapping.staff_detail_id');
//     if(Auth::user()->role_id ==60 && !empty($staff_profile)){
//         $staff_college_mapping = $staff_college_mapping->where('staff_profile_id', $staff_profile->id);
//     }
//     $staff_college_mapping =$staff_college_mapping->distinct()->pluck('staff_detail.college_name');
//     $college_data = DB::table('candidate_mappings');
//     if(!empty($designation)){
//            $college_data->where('designation',$designation);
//     }
//     if(!empty($department)){
//            $college_data->where('department',$department);
//     }
//      $college_data = $college_data->groupBy('college_name')
//             ->pluck('college_name')->toArray();
//     $department_data = DB::table('candidate_mappings');
//     if(!empty($designation)){
//            $department_data->where('designation',$designation);
//     }
//     if(!empty($college_name)){
//            $department_data ->where('college_name',$college_name);
//     }else if(Auth::user()->role_id==60){
//         $department_data->whereIn('college_name', $staff_college_mapping);
//     }
//      $department_data = $department_data->groupBy('department')
//             ->pluck('department')->toArray();
//     $data['college_name']=$college_data;
//     $data['department']=$department_data;

//     return response()->json($data);
// }
// public function find_staff_by_contact_no(Request $request){
//     $contact_no = !empty($request->contact_no)?$request->contact_no:'';
//     $data = DB::table('candidate_mappings')->where('mobile_no1',$contact_no)->first();
//     return response()->json($data);
// }
// public function getStaffByGatNayak(Request $request){
//     $gat_nayak_id = !empty($request->gat_nayak_id)?$request->gat_nayak_id:'';
//     $data = DB::table('staff_college_mapping')
//               ->join('staff_detail','staff_detail.id','staff_college_mapping.staff_detail_id')
//               ->where('staff_college_mapping.staff_profile_id',$gat_nayak_id)
//               ->pluck('staff_detail.name','staff_detail_id');
//     return response()->json($data);
// }
// public function get_Mappedcollege_by_staff(Request $request){
//     $gat_nayak_id = !empty($request->gat_nayak_id)?$request->gat_nayak_id:'';
//     $data = DB::table('gat_nayak_college_mapping')
//               ->join('staff_profile','staff_profile.id','gat_nayak_college_mapping.staff_profile_id')
//               ->where('gat_nayak_college_mapping.staff_profile_id',$gat_nayak_id)
//               ->where('gat_nayak_college_mapping.status',1)
//               ->pluck('gat_nayak_college_mapping.college_name');
//     return response()->json($data);
// }
public function find_staff_personal_detail_by_contact_no(Request $request){
    $contact_no = !empty($request->contact_no)?$request->contact_no:'';
    $data = DB::table('candidate_mappings')
              ->where('mobile',$contact_no)
              ->first();
    return response()->json($data);
}

}