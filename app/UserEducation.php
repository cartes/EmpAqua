<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\UserEducation
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserEducation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserEducation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserEducation query()
 * @mixin \Eloquent
 * @property int $id_education
 * @property int $id_user
 * @property string $country
 * @property string $studies
 * @property string $condition
 * @property string $title
 * @property string $area
 * @property string $month_from
 * @property string $year_from
 * @property string $month_to
 * @property string $year_to
 * @property string $institution
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserEducation whereArea($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserEducation whereCondition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserEducation whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserEducation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserEducation whereIdEducation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserEducation whereIdUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserEducation whereInstitution($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserEducation whereMonthFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserEducation whereMonthTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserEducation whereStudies($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserEducation whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserEducation whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserEducation whereYearFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserEducation whereYearTo($value)
 * @property int|null $to_present
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserEducation whereToPresent($value)
 */
class UserEducation extends Model
{
    const COURSE = 1;
    const GRADUATE = 2;
    const ABANDONED = 3;

    protected $table = "aquabe_users_education";
    protected $fillable = ['country', 'studies', 'condition', 'title', 'area', 'month_from',
        'year_from', 'month_to', 'year_to', 'institution'];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getStudiesLevelAttribute()
    {
        $studies = $this->attributes['studies'];

        switch ($studies) {
            case "1":
                return "Secundario"; break;
            case "2":
                return "Técnico"; break;
            case "3":
                return "Universitario"; break;
            case "4":
                return "Posgrado"; break;
            case "5":
                return "Doctorado"; break;
            case "6":
                return "Otro"; break;
        }
    }

    public function getConditionAttribute($value)
    {
        switch ($value) {
            case "1":
                return "En Curso";
                break;
            case "2":
                return "Graduado";
                break;
            case "3":
                return "Abandonado";
                break;
        }
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
}
