<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Crypt;
use App\Models\User;
use App\Models\DU_colleges;

class StaffCollegeMappingController extends Controller
{
    protected $current_menu;

    public function __construct()
    {
        $this->current_menu = 'StaffCollegeMapping';
    }

    public function index()
    {
        // $staffProfiles = DB::table('staff_profile')->where('status',1)->pluck('name', 'id');
        $staffProfiles = DB::table('staff_detail')->where('status',1)->pluck('name', 'id');
        $staff_Profile_id = DB::table('staff_profile')->where('users_id', Auth::user()->id)->pluck( 'id')->first();
        $data = DB::table('staff_college_mapping')
                  ->where('staff_college_mapping.status',1)
                  ->join('staff_detail', 'staff_college_mapping.staff_detail_id', '=', 'staff_detail.id')
                  ->where('staff_detail.status',1);
        if(Auth::user()->role_id == 60) {
            $data->where('staff_profile_id', $staff_Profile_id);
        }
        $data = $data->get();
        return view($this->current_menu . '.index', [
            'current_menu' => $this->current_menu,
            'data' => $data,
            'staffProfiles' => $staffProfiles,
        ]);
    }

    public function create(Request $request)
    {
        $college_name = !empty($request->college_name)?$request->college_name:'';
        $staff_profile_id = !empty($request->staff_profile_id)?$request->staff_profile_id:'';
        $staffProfiles = DB::table('staff_profile')->pluck('name', 'id');
        $duColleges = DU_colleges::pluck('college_name');
        if(Auth::user()->role_id==60){
            $staffProfiles = DB::table('staff_profile')->where('users_id',Auth::user()->id)->pluck('name', 'id');
        }
        $data = DB::table('staff_detail')->where('college_name',$college_name)->get();
        $exist = DB::table('staff_college_mapping')
                  ->where('status',1)
                  ->where('staff_profile_id', $staff_profile_id)
                  ->pluck('staff_detail_id')->toArray();
        return view($this->current_menu . '.create', [
            'current_menu' => $this->current_menu,
            'staffProfiles' => $staffProfiles,
            'duColleges' => $duColleges,
            'data' => $data,
            'exist' => $exist,
            'college_name' => $college_name,
            'staff_profile_id' => $staff_profile_id,
        ]);
    }

    public function store(Request $request)
    {
        $staff_profile_id = !empty($request->staff_profile_id)?$request->staff_profile_id:'';
        $staff_id = !empty($request->staff_id)?$request->staff_id:'';
        $status = !empty($request->status)?$request->status:1;
        $data = [];
        foreach ($staff_id as $staff_detail_id) {
            $data[] = [
                'staff_profile_id' => $staff_profile_id,
                'staff_detail_id' => $staff_detail_id,
                'status' => $status,
                'created_at' => date('Y-m-d H:i:s'),
                'created_by' => Auth::user()->id
            ];
            DB::table('staff_college_mapping')
            ->where('staff_profile_id', $staff_profile_id)
            ->whereIn('staff_detail_id', $staff_id)
            ->update([
                    'status' => 9,
                    'updated_at' => date('Y-m-d H:i:s'),
                    'updated_by' => Auth::user()->id
                ]);
        }
        // dd($data);
        DB::beginTransaction();
            DB::table('staff_college_mapping')->insert($data);
            DB::commit();
            Session::flash('message', 'Staff Mapped successfully.');

        return redirect()->route($this->current_menu . '.index');
    }

    public function edit($encid)
    {
        $id = Crypt::decryptString($encid);
        $mapping = DB::table('staff_college_mapping')->where('status',1)->where('staff_profile_id',$id)->get();
        $staffProfiles = DB::table('staff_profile')->pluck('name', 'id');
        $duColleges = DU_colleges::pluck('college_name');

        return view($this->current_menu . '.edit', [
            'current_menu' => $this->current_menu,
            'data' => $mapping,
            'encrypted_id' => $encid,
            'duColleges' => $duColleges,
            'staffProfiles' => $staffProfiles,
        ]);
    }

    public function update(Request $request, $encid)
    {
        $id = Crypt::decryptString($encid);

        $staff_profile_id = $id;
        $college_name = !empty($request->college_name)?$request->college_name:'';
        $status = !empty($request->status)?$request->status:1;
        $data = [];
        foreach ($college_name as $college) {
            $data[] = [
                'staff_profile_id' => $staff_profile_id,
                'college_name' => $college,
                'status' => $status,
                'created_at' => date('Y-m-d H:i:s'),
                'created_by' => Auth::user()->id
            ];
            DB::table('staff_college_mapping')
            ->where('staff_profile_id', $staff_profile_id)
            ->where('status', 1)
            ->update([
                    'status' => 9,
                    'updated_at' => date('Y-m-d H:i:s'),
                    'updated_by' => Auth::user()->id
                ]);
        }
        // dd($data);
        DB::beginTransaction();
            DB::table('staff_college_mapping')->insert($data);
            DB::commit();
            Session::flash('message', 'Staff college mapping Updated successfully.');

        return redirect()->route($this->current_menu . '.index');
    }

    public function destroy($encid)
    {
        $id = Crypt::decryptString($encid);

        DB::beginTransaction();
            DB::table('staff_college_mapping')->where('staff_profile_id', $id)->update([
                'status' => 9,
                    'updated_at' => date('Y-m-d H:i:s'),
                    'updated_by' => Auth::user()->id
            ]);
            DB::commit();
            Session::flash('message', 'Mapping deleted successfully.');
        return redirect()->route($this->current_menu . '.index');
    }
}
