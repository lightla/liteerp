<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BusinessRoleModel extends Model
{
    //
    public $table = "business_role";
    protected $fillable = ['user_id', 'business_id', 'role','deleted_flg'];
    public function business(){
        return $this->hasOne(BusinessModel::class,'id','business_id');
    }
}
