<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\UserExperience
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserExperience newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserExperience newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserExperience query()
 * @mixin \Eloquent
 * @property int $id_experience
 * @property int $id_user
 * @property string $business_name
 * @property string $business_activity
 * @property string $business_position
 * @property string $experience_level
 * @property string $month_from
 * @property string $year_from
 * @property string $month_to
 * @property string $year_to
 * @property string $area
 * @property string $sub_area
 * @property string $description
 * @property int $dependents
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $User
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserExperience whereArea($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserExperience whereBusinessActivity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserExperience whereBusinessName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserExperience whereBusinessPosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserExperience whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserExperience whereDependents($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserExperience whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserExperience whereExperienceLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserExperience whereIdExperience($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserExperience whereIdUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserExperience whereMonthFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserExperience whereMonthTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserExperience whereSubArea($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserExperience whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserExperience whereYearFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserExperience whereYearTo($value)
 * @property-read \App\Models\User $user
 * @property string|null $business_country
 * @property int|null $to_present
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserExperience whereBusinessCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserExperience whereToPresent($value)
 * @property-read mixed $date_diff
 */
class UserExperience extends Model
{
    protected $table = "aquabe_users_experience";
    protected $fillable = [
        'business_name', 'business_activity', 'business_position', 'experience_level', 'country',
        'month_from', 'year_from', 'month_to', 'year_to', 'area', 'sub_area', 'description', 'dependents'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function getMonthFromAttribute($value)
    {
        switch ($value) {
            case '01':
                return "Ene";
                break;
            case '02':
                return "Feb";
                break;
            case '03':
                return "Mar";
                break;
            case '04':
                return "Abr";
                break;
            case '05':
                return "May";
                break;
            case '06':
                return "Jun";
                break;
            case '07':
                return "Jul";
                break;
            case '08':
                return "Ago";
                break;
            case '09':
                return "Sep";
                break;
            case '10':
                return "Oct";
                break;
            case '11':
                return "Nov";
                break;
            case '12':
                return "Dic";
                break;
        }
    }

    public function getMonthToAttribute($value)
    {
        switch ($value) {
            case '01':
                return "Ene";
                break;
            case '02':
                return "Feb";
                break;
            case '03':
                return "Mar";
                break;
            case '04':
                return "Abr";
                break;
            case '05':
                return "May";
                break;
            case '06':
                return "Jun";
                break;
            case '07':
                return "Jul";
                break;
            case '08':
                return "Ago";
                break;
            case '09':
                return "Sep";
                break;
            case '10':
                return "Oct";
                break;
            case '11':
                return "Nov";
                break;
            case '12':
                return "Dic";
                break;
        }
    }

    public function getLevelExperienceAttribute() {
        $level = $this->attributes['experience_level'];

        switch ($level) {
            case '01':
                return 'Training'; break;
            case '02':
                return 'Junior'; break;
            case '03':
                return 'Semisenior'; break;
            case '04':
                return 'Senior'; break;
        }
    }

    public function getDateDiffAttribute()
    {
        $monthTo = $this->attributes['month_to'];
        $yearTo = $this->attributes['year_to'];
        $monthFrom = $this->attributes['month_from'];
        $yearFrom = $this->attributes['year_from'];

        $dateFrom = Carbon::createFromDate($yearFrom, $monthFrom, 1);
        $dateTo = Carbon::createFromDate($yearTo, $monthTo, 1);

        return $dateFrom->diff($dateTo)->format('%y Años');
    }
}
