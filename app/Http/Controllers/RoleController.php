<?php

// namespace App\Http\Controllers;
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\User_Profile;
use App\Models\College;

use DB;
use Auth;
use Crypt;
use Session;

class RoleController extends Controller
{
     public function __construct() {
        $this->current_menu = 'RoleMast';
      } 

    public function index()
    {
        $college_id = Auth::user()->college_id;
        
       $data=Role::getAllRecords($college_id);
        // dd($data,$college_id);
       // $role_mast =Role::pluckActiveCodeAndName();
       return view($this->current_menu.'/index',[
            'data' => $data,
            // 'role_mast'=>$role_mast,
            'current_menu' => $this->current_menu,
                ]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {   
        $college_id = Auth::user()->college_id;
        $college = College::pluckActiveCodeAndName($college_id);
        return view($this->current_menu.'/create', [
            'college' => $college,
            'current_menu' => $this->current_menu,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $role_name=!empty($request->role)?$request->role:NULL;
        $status = !empty($request->status)?$request->status:1;
        $updated_at = NULL;
        $updated_by = NULL;
        $created_at = date('Y-m-d H:i:s');
        $created_by = Auth::user()->id;


        $myArr = [
            'name'=>$role_name,
            'status'=>$status,
            'updated_at'=>$updated_at,
            'updated_by'=>$updated_by,
            'created_at'=>$created_at,
            'created_by'=>$created_by,

        ];
        // dd($myArr);


        DB::beginTransaction();
        $query = Role::create($myArr);
        
        if($query) {
            DB::commit();
            $message = 'Entry Saved Successfuly';
            Session::flash('message', $message);

        }else {
            DB::rollback();
            $message = 'Something Went Wrong';
            Session::flash('error', $message);

        }

        return redirect($this->current_menu);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // dd($id);
              $decrypted_id = Crypt::decryptString($id);
              $data =Role::getDataFromId($decrypted_id);
              // dd($data);
              $encrypted_id=$id;
        $college = College::pluckActiveCodeAndName();

              return view($this->current_menu.'/edit', [
                    'data'=>$data,
                    'current_menu' => $this->current_menu,
                    'college'=>$college,
                    'encrypted_id'=>$encrypted_id,
                ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update( $id,Request $request)
    { 
        // dd($request);
        $decrypted_id = Crypt::decryptString($id);
        $role_name=!empty($request->role)?$request->role:NULL;
        $status = !empty($request->status)?$request->status:1;
        $updated_at = NULL;
        $updated_by = NULL;
        $created_at = date('Y-m-d H:i:s');
        $created_by = Auth::user()->id;


        $myArr = [
            'name'=>$role_name,
            'status'=>$status,
            'updated_at'=>$updated_at,
            'updated_by'=>$updated_by,
            'created_at'=>$created_at,
            'created_by'=>$created_by,

        ];
        // dd($myArr);

        DB::beginTransaction();
        $query = Role::updateDataFromId($decrypted_id, $myArr);
        
        if($query) {
            DB::commit();
            $message = 'Entry Saved Successfuly';
            Session::flash('message', $message);

        }else {
            DB::rollback();
            $message = 'Something Went Wrong';
            Session::flash('error', $message);

        }

        return redirect($this->current_menu);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
{
    $decrypted_id = Crypt::decryptString($id);
    
    DB::beginTransaction();
    $department = Role::findOrFail($decrypted_id);
    $department->status = 9; // Assuming 1 represents active and 9 represents inactive
    $department->save();
    DB::commit();

    return redirect()->route($this->current_menu.'.index');
}
public function importData(Request $request)
    {
        $csv_file = $request->excelFile;
        // dd($request);
        if (($getfile = fopen($csv_file, "r")) !== FALSE) {
            $arr_to_insert = [];
            $data = fgetcsv($getfile, 1000, ",");
            $total_updates = 0;
            $total_inserts = 0;
            DB::beginTransaction();
            while (($data = fgetcsv($getfile, 1000, ",")) !== FALSE) {
                $curr_date = date('Y-m-d H:m:s');

                        $result = $data;
                        $result1  = str_replace(",","",$result);  
                        $str = implode(",", $result1);
                        $slice = explode(",", $str);
                        if(count($slice) >= 9) {
                            $new_arr = [
                                'id' => !empty($slice[0])?$slice[0]:NULL,
                                'name' => !empty($slice[2])?$slice[2]:NULL,
                                'status' => !empty($slice[3])?$slice[3]:NULL,
                                'sequence' => !empty($slice[4])?$slice[4]:NULL,
                                'updated_at' => !empty($slice[5])?$slice[5]:NULL,
                                'updated_by' => !empty($slice[6])?$slice[6]:NULL,
                                'created_at' => !empty($slice[7])?$slice[7]:NULL,
                                'created_by' => !empty($slice[8])?$slice[8]:NULL,
                                ];


                            $key = $slice[0];

                            if(!empty($key)) {
                                $present_data = DB::table('role_mast')->where('id', $key)->first();
                                if(!empty($present_data)) {
                                    $update_data = DB::table('role_mast')
                                                    ->where('id', $key)
                                                    ->update($new_arr);

                                    $total_updates += 1;

                                }
                                else {
                                    $arr_to_insert[] = $new_arr;
                                    //dd($arr_to_insert);
                                }
                            }                      
                        }
                    }
                   
                    if(count($arr_to_insert) > 0) {
                        $collected = collect($arr_to_insert);
                        $chunked_array = $collected->chunk(1000);
                        foreach ($chunked_array as $value) {
                            # code...
                            $query = DB::table('role_mast')->insert($value->toArray());
                        }
                    }

            if ($total_updates || $query) {
                DB::commit();
                Session::flash('message', 'Uploaded Successfully');
                Session::flash('alert-class', 'alert-success');
            } else {
                DB::rollback();
                Session::flash('message', 'Something went wrong!');
                Session::flash('alert-class', 'alert-danger');
            }
        }
        // 
        // return redirect()->route('importData');
        // return redirect('importData');
        return redirect()->route('role.index')->with('success', 'Data imported successfully.');
    }



}
