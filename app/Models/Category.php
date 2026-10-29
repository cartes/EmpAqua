<?php

namespace App\Models;

use App\Traits\DatesTranslator;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use DatesTranslator;

    protected $table= "aquabe_categories";
    protected $fillable = [
        'title',
        'slug',
        'description',
    ];

    public function Offers()
    {
        return $this->hasMany(Offers::class);
    }
}
