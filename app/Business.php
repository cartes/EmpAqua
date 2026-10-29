<?php

namespace App;

use App\Traits\DatesTranslator;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Business
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
 * @property-read \App\BusinessMeta $business_meta
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Offers[] $offers
 * @property-read int|null $offers_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Business newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Business newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Business query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Business whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Business whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Business whereFirstname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Business whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Business wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Business wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Business wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Business whereRutUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Business whereSurname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Business whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Business onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Business whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Business withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Business withoutTrashed()
 * @property-read mixed $expirated_at
 * @property string $email_user
 * @property string $phone_user
 * @property int|null $migrated
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Business whereEmailUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Business whereMigrated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Business wherePhoneUser($value)
 */
class Business extends Model
{
    use SoftDeletes, DatesTranslator;

    protected $fillable = ['rut_user', 'password', 'firstname', 'surname', 'email_user', 'position', 'phone_user'];
    protected $table = "aquabe_business";
    protected $hidden = "password";
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
