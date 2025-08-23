<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class RoleMast extends Model
{
  protected $table = 'role_mast';
  protected $guarded = [];
  public $timestamps = false;
  public static function updateDataFromId($id, $arr_to_update)
  {
    return RoleMast::where('id', $id)
      ->update($arr_to_update);
  }
  public static function getAllRecords()
  {
    return RoleMast:: where('status', '!=', 9)->get();
  }
}