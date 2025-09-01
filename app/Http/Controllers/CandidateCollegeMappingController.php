<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Crypt;
use App\Models\User;
use App\Models\DU_colleges;

class CandidateCollegeMappingController extends Controller
{
    protected $current_menu;

    public function __construct()
    {
        $this->current_menu = 'CandidateCollegeMapping';
    }

    public function index()
    {
        $staffProfiles = DB::table('staff_profile')
                           ->join('users','users.id','staff_profile.users_id')->where('staff_profile.status',1)->pluck('staff_profile.name', 'staff_profile.id');
        $data = DB::table('gat_nayak_college_mapping')->join('staff_profile','staff_profile_id','staff_profile.id')->where('staff_profile.gatnayak_or_candidate',Null)->where('gat_nayak_college_mapping.status',1)->select('gat_nayak_college_mapping.*')->get();
        $duColleges = DU_colleges::pluck('college_name','id');
        return view($this->current_menu . '.index', [
            'current_menu' => $this->current_menu,
            'data' => $data,
            'staffProfiles' => $staffProfiles,
            'duColleges' => $duColleges,
        ]);
    }

    public function create()
    {
        $staffProfiles = DB::table('staff_profile')->join('users','users.id','staff_profile.users_id')->where('staff_profile.status',1)->where('staff_profile.gatnayak_or_candidate',Null)->pluck('staff_profile.name', 'staff_profile.id');
        // $duColleges = DU_colleges::pluck('college_name','id');
        $duColleges = DB::table('staff_detail')
                        ->join('duta_colleges','duta_colleges.id','staff_detail.college_name')
                        ->where('staff_detail.status', 1)
                        ->groupBy('duta_colleges.college_name','duta_colleges.id')
                        ->pluck('duta_colleges.college_name','duta_colleges.id');
        return view($this->current_menu . '.create', [
            'current_menu' => $this->current_menu,
            'staffProfiles' => $staffProfiles,
            'duColleges' => $duColleges,
        ]);
    }

    public function store(Request $request)
    {
        $staff_profile_id = !empty($request->staff_profile_id)?$request->staff_profile_id:'';
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
            DB::table('gat_nayak_college_mapping')
            ->where('staff_profile_id', $staff_profile_id)
            ->where('college_name', $college)
            ->update([
                    'status' => 9,
                    'updated_at' => date('Y-m-d H:i:s'),
                    'updated_by' => Auth::user()->id
                ]);
        }
        // dd($data);
        DB::beginTransaction();
            DB::table('gat_nayak_college_mapping')->insert($data);
            DB::commit();
            Session::flash('message', 'Staff college mapping created successfully.');

        return redirect()->route($this->current_menu . '.index');
    }

    public function edit($encid)
    {
        $id = Crypt::decryptString($encid);
        $mapping = DB::table('gat_nayak_college_mapping')->where('status',1)->where('staff_profile_id',$id)->get();
        $staffProfiles = DB::table('staff_profile')->join('users','users.id','staff_profile.users_id')->where('staff_profile.gatnayak_or_candidate',Null)->where('staff_profile.status',1)->pluck('staff_profile.name', 'staff_profile.id');
        // $duColleges = DU_colleges::pluck('college_name','id');
        $duColleges = DB::table('staff_detail')
                        ->join('duta_colleges','duta_colleges.id','staff_detail.college_name')
                        ->where('staff_detail.status', 1)
                        ->groupBy('duta_colleges.college_name','duta_colleges.id')
                        ->pluck('duta_colleges.college_name','duta_colleges.id');

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
            DB::table('gat_nayak_college_mapping')
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
            DB::table('gat_nayak_college_mapping')->insert($data);
            DB::commit();
            Session::flash('message', 'Staff college mapping Updated successfully.');

        return redirect()->route($this->current_menu . '.index');
    }

    public function destroy($encid)
    {
        $id = Crypt::decryptString($encid);

        DB::beginTransaction();
            DB::table('gat_nayak_college_mapping')->where('staff_profile_id', $id)->update([
                'status' => 9,
                    'updated_at' => date('Y-m-d H:i:s'),
                    'updated_by' => Auth::user()->id
            ]);
            DB::commit();
            Session::flash('message', 'Mapping deleted successfully.');
        return redirect()->route($this->current_menu . '.index');
    }
}