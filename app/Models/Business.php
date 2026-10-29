<?php

namespace App\Models;

use App\Traits\DatesTranslator;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Business
 *
 * @property int $id
 * @property string $rut_user
 * @property string $password
 * @property string $firstname
 * @property string $surname
 * @property string $email
 * @property string $position
 * @property string $phone
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\BusinessMeta $business_meta
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Offers[] $offers
 * @property-read int|null $offers_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Business newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Business newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Business query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Business whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Business whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Business whereFirstname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Business whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Business wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Business wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Business wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Business whereRutUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Business whereSurname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Business whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Business onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Business whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Business withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Business withoutTrashed()
 * @property-read mixed $expirated_at
 * @property string $email_user
 * @property string $phone_user
 * @property int|null $migrated
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Business whereEmailUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Business whereMigrated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Business wherePhoneUser($value)
 */
class Business extends Model
{
    use SoftDeletes, DatesTranslator;

    protected $fillable = ['rut_user', 'password', 'firstname', 'surname', 'email_user', 'position', 'phone_user'];
    protected $table = "aquabe_business";
    protected $hidden = ['password'];
    protected $withCount = ['offers'];

    public function business_meta()
    {
        return $this->hasOne(BusinessMeta::class, 'id_business', 'id');
    }

    public function offers()
    {
        return $this->hasMany(Offers::class, 'id_business', 'id')->withCount(['candidates' => function($q) {
            $q->whereDate('created_at', '>=', Carbon::now()->subDays(7));
        }]);
    }

    public function roles() {
        return $this->hasOne(Role::class, 'id_business', 'id');
    }
}
