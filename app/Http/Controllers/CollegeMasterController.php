<?php

namespace App\Http\Controllers;
use App\Models\College;
use App\Models\State;
use Auth;
use DB;
use Crypt;
use Session;
use Illuminate\Http\Request;

class CollegeMasterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct() {
        $this->current_menu = 'CollegeMaster';
    }
    public function index(Request $request)
    {    
        // dd($request);
        $college_id=!empty($request->college_id)?$request->college_id:null;
        $college_mast=College::pluckActiveCodeAndName();
        $data = College::getAllRecords($college_id);
        // dd($data);

        return view($this->current_menu.'/index', [
            'data' => $data,
            'college_mast'=>$college_mast,
            'current_menu' => $this->current_menu,

        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $current_menu = 'CollegeMaster';

        return view('CollegeMaster/create', [
            'current_menu' => $this->current_menu,
            
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $college_name = !empty($request->college_name)?$request->college_name: NULL;
        $short_name = !empty($request->short_name)?$request->short_name: NULL;
        $exist =  College::where('college_id', $short_name)->where('status', '!=', 9)->first();
        if($exist){
            $message = 'College CODE already exists';
            Session::flash('error', $message);
            return redirect($this->current_menu.'/create')->withInput();
        }

        $status = !empty($request->status)?$request->status: 1;
        $sequence = !empty($request->sequence)?$request->sequence: 100;
        $updated_at = NULL;
        $updated_by = NULL;
        $created_at = date('Y-m-d H:i:s');
        $created_by = Auth::user()->id;

        $myArr = [
            'college_name' => $college_name,
            'college_id' => $short_name,
            'status' => $status,
                'updated_at' => $updated_at,
            'updated_by' => $updated_by,
            'created_at' => $created_at,
            'created_by' => $created_by,
        ];
        DB::beginTransaction();
        $query = College::create($myArr);
        
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
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $decrypted_id = Crypt::decryptString($id);
        $data = College::getDataFromId($decrypted_id);
        return view($this->current_menu.'/edit', [
            'data' => $data,
            'current_menu' => $this->current_menu,
            'encrypted_id' => $id,

        ]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $decrypted_id = Crypt::decryptString($id);
        
        $college_name = !empty($request->college_name)?$request->college_name: NULL;
        $short_name = !empty($request->short_name)?$request->short_name: NULL;
        $status = !empty($request->status)?$request->status: 1;
        $sequence = !empty($request->sequence)?$request->sequence: 100;
        $updated_at = date('Y-m-d H:i:s');
        $updated_by = Auth::user()->id;
        $created_at = NULL;
        $created_by = NULL;

         $exist =  College::where('college_id', $short_name)->where('status', '!=', 9)->first();
        if($exist){
            $message = 'College CODE already exists';
            Session::flash('error', $message);
            return redirect($this->current_menu.'/create')->withInput();
        }
        $myArr = [
            'college_name' => $college_name,
            'college_id' => $short_name,
            'status' => $status,
            'updated_at' => $updated_at,
            'updated_by' => $updated_by,
            'created_at' => $created_at,
            'created_by' => $created_by,
        ];
        DB::beginTransaction();
        $query = College::updateDataFromId($decrypted_id, $myArr);
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
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $decrypted_id = Crypt::decryptString($id);
        
        DB::beginTransaction();
        $department = College::findOrFail($decrypted_id);
        $department->status = 9; // Assuming 1 represents active and 9 represents inactive
        $department->save();
        DB::commit();

        return redirect()->route($this->current_menu.'.index');
    }
//     public function importData(Request $request)
//     {
//         $csv_file = $request->excelFile;
//         // dd($request);
//         if (($getfile = fopen($csv_file, "r")) !== FALSE) {
//             $arr_to_insert = [];
//             $data = fgetcsv($getfile, 1000, ",");
//             DB::beginTransaction();
//             while (($data = fgetcsv($getfile, 1000, ",")) !== FALSE) {
//                 $curr_date = date('Y-m-d H:m:s');

//                         $result = $data;
//                         $result1  = str_replace(",","",$result);  
//                         $str = implode(",", $result1);
//                         $slice = explode(",", $str);
//                         if(count($slice) >= 18) {
//                             $new_arr = [
//                                 'university_id' => !empty($slice[0])?$slice[0]:NULL,
//                                 'college_name' => !empty($slice[1])?$slice[1]:NULL,
//                                 'short_name' => !empty($slice[2])?$slice[2]:NULL,
//                                 'college_id' => !empty($slice[3])?$slice[3]:NULL,
//                                 'website_url' => !empty($slice[4])?$slice[4]:NULL,
//                                 'principal_name' => !empty($slice[5])?$slice[5]:NULL,
//                                 'contact_no' => !empty($slice[6])?$slice[6]:NULL,
//                                 'contact_no2' => !empty($slice[7])?$slice[7]:NULL,
//                                 'email_id' => !empty($slice[8])?$slice[8]:NULL,
//                                 'address' => !empty($slice[9])?$slice[9]:NULL,
//                                 'state' => !empty($slice[10])?$slice[10]:NULL,
//                                 'remarks' => !empty($slice[11])?$slice[11]:NULL,
//                                 'status' => 1,
//                                 'sequence' => 1000,
//                                 'updated_at' => date('Y-m-d H:i:s'),
//                                 'updated_by' => Auth::user()->id,
//                                 'created_at' => NULL,
//                                 'created_by' => NULL,
                                
//                                 ];

//                             $arr_to_insert[] = $new_arr;
//                             $key = $slice[0];

                            
                   
//                     if(count($arr_to_insert) > 0) {
//                         $collected = collect($arr_to_insert);
//                         $chunked_array = $collected->chunk(1000);
//                         foreach ($chunked_array as $value) {
//                             # code...
//                             $query = DB::table('college_mast')->insert($value->toArray());
//                         }
//                     }

//             if ($query>0) {
//                 DB::commit();
//                 Session::flash('message', 'Uploaded Successfully');
//                 Session::flash('alert-class', 'alert-success');
//             } else {
//                 DB::rollback();
//                 Session::flash('message', 'Something went wrong!');
//                 Session::flash('alert-class', 'alert-danger');
//             }
//         }
//         // 
//         // return redirect()->route('importData');
//         // return redirect('importData');
//         return redirect()->route('college.index')->with('success', 'Data imported successfully.');
//     }
// }
// }

public function importData(Request $request)
{
    
        $csv_file = $request->file('excelFile'); // Use file() method to get uploaded file

        if (($getfile = fopen($csv_file, "r")) !== FALSE) {
            $arr_to_insert = [];
            $total_updates = 0;

            $data = fgetcsv($getfile, 1000, ",");
            DB::beginTransaction();
            while (($data = fgetcsv($getfile, 1000, ",")) !== FALSE) {
                $curr_date = date('Y-m-d H:m:s');

                        $result = $data;
                        $result1  = str_replace(",","",$result);  
                        $str = implode(",", $result1);
                        $slice = explode(",", $str);
// dd($slice);
                        if(count($slice) >= 12) {
                            $new_arr = [
                                'university_id' => !empty($slice[0])?$slice[0]:NULL,
                                'college_name' => !empty($slice[1])?$slice[1]:NULL,
                                'short_name' => !empty($slice[2])?$slice[2]:NULL,
                                'college_id' => !empty($slice[3])?$slice[3]:NULL,
                                'website_url' => !empty($slice[4])?$slice[4]:NULL,
                                'principal_name' => !empty($slice[5])?$slice[5]:NULL,
                                'contact_no' => !empty($slice[6])?$slice[6]:NULL,
                                'contact_no2' => !empty($slice[7])?$slice[7]:NULL,
                                'email_id' => !empty($slice[8])?$slice[8]:NULL,
                                'address' => !empty($slice[9])?$slice[9]:NULL,
                                'state' => !empty($slice[10])?$slice[10]:NULL,
                                'remarks' => !empty($slice[11])?$slice[11]:NULL,
                                'status' => 1,
                                'sequence' => 1000,
                                'updated_at' => Null,
                                'updated_by' => Null,
                                'created_at' => date('Y-m-d H:i:s'),
                                'created_by' => Auth::user()->id,
                                
                                ];
            
// dd($new_arr);

                

                $arr_to_insert[] = $new_arr;

            }

            if (count($arr_to_insert) > 0) {
                $collected = collect($arr_to_insert);
                $chunked_array = $collected->chunk(1000);
                foreach ($chunked_array as $value) {
                    $query = DB::table('college_mast')->insert($value->toArray());
// dd($query);
                    
                }
            }

            if ($query) {
                DB::commit();
                return redirect()->route('college.index')->with('success', 'Data imported successfully.');
            } else {
                DB::rollback();
                return redirect()->route('college.index')->with('error', 'Something went wrong!');
            }
        }
    } 

    
}

    

}
