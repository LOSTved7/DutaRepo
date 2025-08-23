<?php

// namespace App\Http\Controllers;
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Modules;
use App\Models\College;

use DB;
use Auth;
use Crypt;
use Session;

class ModuleMasterController extends Controller
{
     public function __construct() {
        $this->current_menu = 'ModuleMaster';
      }

    public function index() {
        $college_id=Auth::user()->college_id;
        // dd($college_id);
       $data=Modules::getAllRecords($college_id);
       // dd($data);
       $parent_name = [];
       foreach($data as $key => $value) {
            if(empty($value->parent_id)){
            $parent_arr[$value->id] = $value->name;
            }
            else{
            $child_arr[$value->parent_id][] = $value->name;

            }
       }
       // dd($parent_arr,$child_arr);
        return view($this->current_menu.'/index',[
            'data' => $data,
            'parent_arr'=>$parent_arr,
            'current_menu' => $this->current_menu,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $college_id=Auth::user()->college_id;
        // $college_mast=College::pluckActiveCodeAndName($college_id);
        // dd($college_mast);

        
        $module =Modules::pluckActiveParent($college_id);
        return view($this->current_menu.'/create', [
            'module'=> $module,
            'current_menu' => $this->current_menu,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request);
        $college_id=Auth::user()->college_id;
        $parent_id=!empty($request->parent_id)?$request->parent_id:NULL;
        $module_name=!empty($request->name)?$request->name:NULL;
        $url=!empty($request->url)?$request->url:'#';
        $icon=!empty($request->icon)?$request->icon:NULL;
        $status = !empty($request->status)?$request->status:1;
        $sequence = !empty($request->sequence)?$request->sequence:1;
        $updated_at = NULL;
        $updated_by = NULL;
        $created_at = date('Y-m-d H:i:s');
        $created_by = Auth::user()->id;


        $myArr = [
            // 'college_id'=>$college_id,
            'parent_id'=>$parent_id,
            'name'=>$module_name,
            'url'=>$url,
            'icon'=>$icon,
            'status'=>$status,
            'sequence'=>$sequence,
            'updated_at'=>$updated_at,
            'updated_by'=>$updated_by,
            'created_at'=>$created_at,
            'created_by'=>$created_by,

        ];

        // dd($myArr);
        DB::beginTransaction();
        $query = Modules::create($myArr);
        
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
    public function edit($id) {
        // dd($id);
        $college_id=Auth::user()->college_id;
        $decrypted_id = Crypt::decryptString($id);
        $data =Modules::getDataFromId($decrypted_id);
        $module =Modules::pluckActiveParent($college_id);
        // dd($data);
        // $college_mast=College::pluckActiveCodeAndName($college_id);
        return view($this->current_menu.'/edit', [
            'data'=>$data,
            'module'=> $module,
            // 'college_mast'=>$college_mast,
            'current_menu' => $this->current_menu,
            'encrypted_id'=>$id,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id,Request $request)
    { 
        // dd($request);
        $decrypted_id = Crypt::decryptString($id);
        // $college_id = Auth::user()->college_id;
        $parent_id = !empty($request->parent_id)?$request->parent_id:NULL;
        $module_name = !empty($request->name)?$request->name:NULL;
        $url = !empty($request->url)?$request->url:'#';
        $icon = !empty($request->icon)?$request->icon:NULL;
        $status = !empty($request->status)?$request->status:1;
        $sequence = !empty($request->sequence)?$request->sequence:1;
        $updated_at = date('Y-m-d H:i:s');
        $updated_by =Auth::user()->id;

        $myArr = [
            // 'college_id' =>$college_id,
            'parent_id'=>$parent_id,
            'name'=>$module_name,
            'url'=>$url,
            'icon'=>$icon,
            'status'=>$status,
            'sequence' => $sequence,
            'updated_at'=>$updated_at,
            'updated_by'=>$updated_by
        ];

        DB::beginTransaction();
        $query = Modules::updateDataFromId($decrypted_id, $myArr);
        
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
    public function destroy($id) {
    $decrypted_id = Crypt::decryptString($id);
    
    DB::beginTransaction();
    $department = Modules::findOrFail($decrypted_id);
    $department->status = 9; // Assuming 1 represents active and 9 represents deleted
    $department->save();
    DB::commit();

    return redirect()->route($this->current_menu.'.index');
}

}
