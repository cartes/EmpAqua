<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\BusinessMeta
 *
 * @property int $id
 * @property int $id_business
 * @property string $rut_business
 * @property string $business_name
 * @property string $fantasy_name
 * @property string $activity
 * @property string $address
 * @property string $comune
 * @property string $city
 * @property string $state
 * @property string $phone
 * @property string $logo
 * @property string $entry
 * @property int $employees
 * @property string $rotation
 * @property-read \App\Models\Business $business
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BusinessMeta newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BusinessMeta newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BusinessMeta query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BusinessMeta whereActivity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BusinessMeta whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BusinessMeta whereBusinessName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BusinessMeta whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BusinessMeta whereComune($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BusinessMeta whereEmployees($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BusinessMeta whereEntry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BusinessMeta whereFantasyName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BusinessMeta whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BusinessMeta whereIdBusiness($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BusinessMeta whereLogo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BusinessMeta wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BusinessMeta whereRotation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BusinessMeta whereRutBusiness($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BusinessMeta whereState($value)
 * @mixin \Eloquent
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BusinessMeta whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BusinessMeta whereUpdatedAt($value)
 * @property string|null $country
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Offers[] $offers
 * @property-read int|null $offers_count
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\BusinessMeta onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BusinessMeta whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BusinessMeta whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\BusinessMeta withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\BusinessMeta withoutTrashed()
 * @property string|null $email
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BusinessMeta whereEmail($value)
 */
class BusinessMeta extends Model
{
    use SoftDeletes;

    protected $table = "aquabe_business_meta";
    protected $fillable = [
        'id_business',
        'rut_business',
        'business_name',
        'fantasy_name',
        'email',
        'activity',
        'address',
        'comune',
        'city',
        'state',
        'phone',
        'logo',
        'entry',
        'path',
        'picture',
        'employees',
        'rotation'
    ];

    public function pathAttachment()
    {
        if (!empty($this->path)) {
            return asset("storage/business/" . $this->path);
        } else {
            return ' ';
        }
    }

    public function business()
    {
        return $this->belongsTo(Business::class, 'id_business', 'id');
    }

    public function offers()
    {
        return $this->hasMany(Offers::class, 'id_business', 'id_business');
    }
}
