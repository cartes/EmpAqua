<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = "aquabe_roles";

    protected $fillable = ['id_business', 'role'];

    public function business()
    {
        return $this->belongsTo(Business::class, 'id_business', 'id');
    }
    
    public function business_meta()
    {
        return $this->hasOne(BusinessMeta::class, 'id_business', 'id_business');
    }
}
