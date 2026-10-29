<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Reference
 *
 * @property int $id_references
 * @property int $id_user
 * @property string $referencer_firstname
 * @property string $referencer_surname
 * @property string $referencer_email
 * @property string $referencer_business
 * @property string $referencer_phone
 * @property string $referencer_type
 * @property string $referencer_relation
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reference newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reference newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reference query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reference whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reference whereIdReferences($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reference whereIdUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reference whereReferencerBusiness($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reference whereReferencerEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reference whereReferencerFirstname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reference whereReferencerPhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reference whereReferencerRelation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reference whereReferencerSurname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reference whereReferencerType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reference whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Reference extends Model
{
    protected $table = "aquabe_users_references";
    protected $primaryKey = "id_references";

    protected $fillable = [
        'id_user',
        'referencer_firstname',
        'referencer_surname',
        'referencer_email',
        'referencer_business',
        'referencer_phone',
        'referencer_type',
        'referencer_relation'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
