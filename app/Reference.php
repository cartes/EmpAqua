<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Reference
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
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Reference newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Reference newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Reference query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Reference whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Reference whereIdReferences($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Reference whereIdUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Reference whereReferencerBusiness($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Reference whereReferencerEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Reference whereReferencerFirstname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Reference whereReferencerPhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Reference whereReferencerRelation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Reference whereReferencerSurname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Reference whereReferencerType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Reference whereUpdatedAt($value)
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
