<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Auth;
use Session;
// use DB;

class Modules extends Model 
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = "modules";
    protected $guarded = [];
    // protected $fillable = [
    //     'name',
    //     'email',
    //     'password',
    // ];

    public static function getAllRecords() {
        return Modules::where('status','!=',9)
                    ->orderBy('parent_id', 'asc')
                    ->get();
    }

    public static function pluckCodeAndName() {
        return Modules::where('status','!=', 9)
                    ->pluck('name', 'id');
    }

    public static function pluckUrlAndNameByCollege() {
        return Modules::where('status','!=', 9)
                    ->pluck('name', 'url');
    }
    
    public static function pluckActiveParent() {
        return Modules::where('status', 1)
                    ->where('parent_id','=',Null)
                    ->orderBy('sequence','asc')
                    ->orderBy('name','asc')
                    ->pluck('name', 'id');
    }
    public static function getActiveParent() {
        return Modules::where('status', 1)
                    ->where('parent_id','=',Null)
                    ->orderBy('sequence','asc')
                    ->orderBy('name','asc')
                    ->get();
    }
    public static function pluckActiveChilds() {
        return Modules::where('status', 1)
                    ->where('parent_id','!=','Null')
                    ->orderBy('sequence','asc')
                    ->orderBy('name','asc')
                    ->get();
    }
    public static function getDataFromId($id) {
        return Modules::where('id', $id)
                    ->first();
                }

    public static function updateDataFromId($id, $arr_to_update) {
        return Modules::where('id', $id)
                    ->update($arr_to_update);
    }       

    public static function getAssignedModules($role_id) {
    // public static function getAssignedModules() {
        // dd(Auth::user());
        $data = Modules::join('module_assigning', 'modules.id', 'module_assigning.modules_id')
                        ->select('modules.id as id', 'modules.parent_id as parent_id', 'modules.name as name', 'modules.url as url', 'modules.icon as icon', 'modules.sequence as sequence')
                        ->where('module_assigning.role_id', $role_id)
                        ->where('modules.status', 1)
                        ->where('module_assigning.status', 1);

        $final_data = $data->orderBy('modules.name','asc')
                            ->get();

        // dd($final_data);

        $module_arr = [];
        $parent_arr = [];
        $child_arr = [];
        foreach($final_data as $key => $value) {
            if($value->parent_id == NULL) {
                $parent_arr[$value->id]['name'] = $value->name;
                $parent_arr[$value->id]['icon'] = $value->icon;
                $parent_arr[$value->id]['url'] = $value->url;
            }
            else {
                $child_arr[$value->parent_id][$value->id]['name'] = $value->name;
                $child_arr[$value->parent_id][$value->id]['icon'] = $value->icon;
                $child_arr[$value->parent_id][$value->id]['url'] = $value->url;
            }
        }   
             
        $module_arr['parent'] = $parent_arr;
        $module_arr['child'] = $child_arr;

        return $module_arr;
    }    

    public static function check_access($role_id, $url) {
        
        $data = Modules::join('module_assigning', 'modules.id', 'module_assigning.modules_id')
                        ->select('modules.id as id', 'modules.parent_id as parent_id', 'modules.name as name', 'modules.url as url', 'modules.icon as icon', 'modules.sequence as sequence')
                        ->where('module_assigning.role_id', $role_id)
                        ->where('modules.url', $url)
                        ->where('modules.status', 1)
                        ->where('module_assigning.status', 1);

        if(!empty($register_type)) {
            $data->where('module_assigning.register_type', $register_type);
        }
        
        $final_data = $data->first();
                        
        // dd($data);
        if(!empty($final_data)) {
            $access = true;
        }
        else {
            $access = false;   
        }
        return $access;
    } 

    public static function getCompanyModules() {
        return Modules::where('college_id', NULL)
                    ->where('status',1)
                    ->orderBy('sequence', 'asc')
                    ->pluck('id');
    }

}