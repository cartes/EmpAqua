<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * App\Models\User
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Candidates[] $Candidates
 * @property-read int|null $candidates_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User query()
 * @mixin \Eloquent
 * @property-read \App\Models\UserMeta $UserMeta
 * @property-read \App\Models\UserExperience $UserExperience
 * @property-read \App\Models\UserLanguage $UserLanguage
 * @property int $id
 * @property string $rut_user
 * @property string $name
 * @property string $surname
 * @property string $email
 * @property string $password
 * @property string|null $nacionality
 * @property string|null $marital_status
 * @property string|null $gender
 * @property string|null $birthday
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Candidates[] $candidates
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\UserEducation[] $userEducation
 * @property-read int|null $user_education_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\UserExperience[] $userExperience
 * @property-read int|null $user_experience_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\UserLanguage[] $userLanguage
 * @property-read int|null $user_language_count
 * @property-read \App\Models\UserMeta $userMeta
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\UserSkills[] $userSkills
 * @property-read int|null $user_skills_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereBirthday($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereMaritalStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereNacionality($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereRutUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereSurname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereUpdatedAt($value)
 * @property-read mixed $age
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Offers[] $offers
 * @property-read int|null $offers_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Reference[] $userReferences
 * @property-read int|null $user_references_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Message[] $messages
 * @property-read int|null $messages_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Search[] $searches
 * @property-read int|null $searches_count
 */
class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'aquabe_users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'rut_user',
        'name',
        'surname',
        'email',
        'password',
        'nacionality',
        'marital_status',
        'gender',
        'birthday',
        'picture'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function profileAttachment() {
        return asset( "storage/profile/" . $this->path);
    }

    public function offers()
    {
        return $this->belongsToMany(Offers::class, 'aquabe_offers_candidates', 'id_user', 'id_offer')
            ->withTimestamps()
            ->withPivot('status');
    }

    public function candidates()
    {
        return $this->hasMany('App\Models\Candidates', 'id_user', 'id');
    }

    public function userMeta()
    {
        return $this->hasOne('App\Models\UserMeta', 'id_user', 'id');
    }

    public function userExperience()
    {
        return $this->hasMany('App\Models\UserExperience', 'id_user', 'id');
    }

    public function userLanguage()
    {
        return $this->hasMany('App\Models\UserLanguage', 'id_user', 'id');
    }

    public function userSkills()
    {
        return $this->hasMany('App\Models\UserSkills', 'id_user', 'id');
    }

    public function userEducation()
    {
        return $this->hasMany('App\Models\UserEducation', 'id_user', 'id')->orderBy('year_from', 'asc');
    }

    public function userReferences()
    {
        return $this->hasMany(Reference::class, 'id_user', 'id');
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function searches()
    {
        return $this->belongsToMany(Search::class);
    }

    public function getMaritalStatusAttribute($value)
    {
        switch ($value) {
            case "1":
                return "Soltero";
                break;
            case "2":
                return "Casado";
                break;
            case "3":
                return "Unión Libre";
                break;
            case "4":
                return "Divorciado";
                break;
            case "5":
                return "Pareja de Hecho";
                break;
            case "6":
                return "Viuda";
                break;
        }
    }

    public function getGenderAttribute($value)
    {
        switch ($value) {
            case "1":
                return "Masculino";
                break;
            case "2":
                return "Femenino";
                break;
            case "3":
                return "Otro";
                break;
        }
    }

    public function getAgeAttribute()
    {
        $birth = $this->attributes['birthday'];
        $date = Carbon::parse($birth);
        $age = Carbon::createFromDate($date->year, $date->month, $date->day)
            ->diff(Carbon::now())->format('%y Años');

        return $age;
    }

    public function getExperienceAttribute()
    {
        $experiences = UserExperience::whereIdUser($this->id)->get();

        $sum = 0;
        foreach ($experiences as $exp) {
            $year = (int) $exp->year_to - (int) $exp->year_from;
            $sum = $sum + $year;
        }
        return $sum;
    }

}
