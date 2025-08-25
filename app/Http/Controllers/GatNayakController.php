<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\Role;
use App\Models\User;
use Crypt;
use Session;
use Hash;
use DB;
use App\Models\User_Profile;
use App\Models\DU_colleges;
class GatNayakController extends Controller
{
    
     public function __construct() {
        $this->current_menu = 'GatNayak';
    }
    public function index(Request $request)
    {
        $user_data=Auth::user();
        $college_id=$user_data->college_id;

        $role_mast=Role::pluckActiveCodeAndName();

        $name=!empty($request->name)?$request->name:'';
        $contact_no=!empty($request->contact_no)?$request->contact_no:'';
        $role=!empty($request->role)?$request->role:'';
        $submit=!empty($request->submit)?$request->submit:'';
        $data= DB::table('staff_profile')->join('users', 'staff_profile.users_id', '=', 'users.id')
                        ->where('staff_profile.status', '!=', 9)
                        ->whereIn('users.role_id',[59,60])
                        ->where('staff_profile.gatnayak_or_candidate',2)
                        ->select('staff_profile.*','users.email as username');

        if (!empty($name)) {
            $data->where('staff_profile.name', 'like', '%' . $name . '%');
        }
        if (!empty($contact_no)) {
            $data->where('staff_profile.contact_no', $contact_no);
        }
        if (!empty($role)) {
            $data->where('users.role_id', $role);
        }
        $duColleges = DU_colleges::pluck('college_name','id');
            return view($this->current_menu.'/index', [
                    'current_menu'=>$this->current_menu,
                    'role_mast'=>$role_mast,    
                    'data'=>!empty($data->get())?$data->get():[],
                    'role'=>$role,
                    'duColleges'=>$duColleges,
                ]);
    }

    public function create()
    {
        $college_id = Auth::user()->college_id;
        $department_mast = DB::table('staff_detail')->distinct('department')->pluck('department');
        $role_id = Role::pluckActiveCodeAndName();
        $duColleges = DU_colleges::pluck('college_name','id');
    
         return view($this->current_menu.'/create_election', [
            'current_menu'=>$this->current_menu,
            'role_id'=>$role_id,
            'department_mast'=>$department_mast,
            'duColleges'=>$duColleges
        ]);
    }

    public function show($id)
    {
        //
    }

   
  public function store(Request $request)
{
    // dd($request);
    $user_data = Auth::user();
    $user_id = $user_data->id;
    $college_name = !empty($request->college_name) ? $request->college_name : null;
    $department = !empty($request->department) ? $request->department : null;
    $salutation = !empty($request->salutation) ? $request->salutation : '';
    $gender = !empty($request->gender) ? $request->gender : '';
    // $first_name = !empty($request->first_name) ? $request->first_name : '';
    // $middle_name = !empty($request->middle_name) ? $request->middle_name : '';
    // $last_name = !empty($request->last_name) ? $request->last_name : '';
    // $full_name = trim($salutation . ' ' . $first_name . ' ' . $middle_name . ' ' . $last_name);
    $fullname = !empty($request->fullname) ? $request->fullname : '';
    $employment_type = !empty($request->employment_type) ? $request->employment_type : null;
    $contact_no = !empty($request->contact_no) ? $request->contact_no : null;
    $email = !empty($request->email) ? $request->email : null;
    $grade = !empty($request->grade) ? $request->grade : null;
    $sangathan = !empty($request->sangathan) ? $request->sangathan : null;
    $status = !empty($request->status) ? $request->status : 1;
    $comments = !empty($request->comments) ? $request->comments : null;
    $username = $contact_no;
    $password = $contact_no;
    $existing_user = DB::table('staff_profile')->where('contact_no',$contact_no)->where('email', $username)->first();
    DB::beginTransaction();

        $user_arr = [
            'name' => $fullname,
            'email' => $username,
            'email_verified_at' => null,
            'password' => Hash::make($password),
            'role_id' => 60,
            'created_at' => date('Y-m-d H:i:s'),
        ];
        $user = User::create($user_arr);
        $profile_arr = [
            'users_id' => $user->id,
            'name' => $fullname,
            'gatnayak_or_candidate' => 2,
            'college_name' => $college_name,
            'department_name' => $department,
            'contact_no' => $contact_no,
            'status' => $status,
            'created_by' => $user_id,
            'created_at' =>  date('Y-m-d H:i:s'),
        ];
        DB::table('staff_profile')->insert($profile_arr);

        DB::commit();
        Session::flash('message', 'Entry Saved Successfully');
   
    return redirect($this->current_menu);
}

 public function edit($id)
    {
        $decrypted_id=Crypt::DecryptString($id);
        $duColleges = DU_colleges::pluck('college_name','id');
        $role_id = Role::pluckActiveCodeAndName();
        $department_mast = DB::table('staff_detail')->distinct('department')->pluck('department');
        $data = DB::table('staff_profile')->join('users','staff_profile.users_id','users.id')->where('staff_profile.gatnayak_or_candidate',2)->where('staff_profile.id',$decrypted_id)->select('staff_profile.*')->first();
        return view($this->current_menu.'.edit_election', [
            'current_menu'=>$this->current_menu,
            'data'=>$data,
            'id'=>$id,    
            'role_id'=>$role_id,
            'duColleges'=>$duColleges,
            'department_mast'=>$department_mast,
            ]);


                             
    }
 public function destroy($id)
    {
        $decrypted_id=Crypt::DecryptString($id);
        $data = DB::table('staff_profile')->where('id',$decrypted_id)->first();
        DB::beginTransaction();
        DB::table('users')->where('id',$data->users_id)->delete();
        DB::table('staff_profile')->where('id',$decrypted_id)->update(['status'=>9]);
        DB::commit();
        Session::flash('message', 'Entry Deleted Successfully');
       return redirect($this->current_menu);


                             
    }
public function update(Request $request, $id)
{
    $user_data = Auth::user();
    $user_id = $user_data->id;

    $college_name = !empty($request->college_name) ? $request->college_name : null;
    $department = !empty($request->department) ? $request->department : null;
    // $salutation = !empty($request->salutation) ? $request->salutation : '';
    // $gender = !empty($request->gender) ? $request->gender : '';
    $full_name = !empty($request->full_name) ? $request->full_name : '';
    // $middle_name = !empty($request->middle_name) ? $request->middle_name : '';
    // $last_name = !empty($request->last_name) ? $request->last_name : '';
    // $full_name = trim($salutation . ' ' . $first_name . ' ' . $middle_name . ' ' . $last_name);
    // $employment_type = !empty($request->employment_type) ? $request->employment_type : null;
    $contact_no = !empty($request->contact_no) ? $request->contact_no : null;
    // $email = !empty($request->email) ? $request->email : null;
    // $grade = !empty($request->grade) ? $request->grade : null;
    // $sangathan = !empty($request->sangathan) ? $request->sangathan : null;
    $status = !empty($request->status) ? $request->status : 1;
    // $comments = !empty($request->comments) ? $request->comments : null;

    DB::beginTransaction();
        $user =  DB::table('staff_profile')->where('id',$id)->first();
        User::where('id',$user->users_id)->update([
            'name' => $full_name,
            'email' => $contact_no,
            'password' => Hash::make($contact_no),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        DB::table('staff_profile')
            ->where('id', $id)
            ->update([
                'name' => $full_name,
                'college_name' => $college_name,
                'department_name' => $department,
                'contact_no' => $contact_no,
                'gatnayak_or_candidate' => 2,
                'status' => $status,
                'updated_by' => $user_id,
                'updated_at' => date('Y-m-d H:i:s'),
            ]);

        DB::commit();
        Session::flash('message', 'Entry Updated Successfully');
    
    return redirect($this->current_menu);
}
 public function upload(Request $request){
        if($request->hasFile('excel')){
        $duColleges = DU_colleges::selectRaw('UPPER(college_name) as college_name, id')
    ->pluck('id', 'college_name');


            $file = !empty($request->file('excel'))?$request->file('excel'):null;
            $extension = $file->getClientOriginalExtension();
            $fileName = date('YmdHis').rand(10,99).'.'.$extension;
            $filePath =$file->move('staff_upload_file',$fileName);
            $final_arr = [];
        DB::beginTransaction();
        if (($getfile = fopen($filePath, "r")) !== FALSE) {
            $data = fgetcsv($getfile, 1000, ",");
            while (($data = fgetcsv($getfile, 1000, ",")) !== FALSE) {
                $user_arr = [
                   'name' => !empty($data[0])?$data[0]:'',
                   'email' => $data[3],
                   'email_verified_at' => null,
                   'password' => Hash::make($data[3]),
                   'role_id' => 60,
                   'created_at' => date('Y-m-d H:i:s'),
               ];
                $user = User::create($user_arr);

                $final_arr[] = [
                    'name'=> !empty($data[0])?$data[0]:'',
                    'users_id'=>$user->id,
                    'college_name'=>!empty($duColleges[strtoupper($data[1])])?$duColleges[strtoupper($data[1])]:'',
                    'department_name'=> !empty($data[2])?$data[2]:'',
                    'contact_no'=> !empty($data[3])?$data[3]:'',
                    'status'=> 1,
                                    'gatnayak_or_candidate' => 2,
                    'created_at'=> date('Y-m-d H:i:s'),
                    'created_by'=> Auth::user()->id,
                ];
            }
        }
        DB::table('staff_profile')->insert($final_arr);
        DB::commit();
        Session::flash('message', 'data uploaded successfully.');
        Session::flash('alert-class', 'alert-success');
        return redirect($this->current_menu);
            }

        return view($this->current_menu.'/upload', [
            'current_menu' => $this->current_menu,
        ]);
}

}
