<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\UserLanguage
 *
 * @property int $id_language
 * @property int $id_user
 * @property string $language
 * @property int $level_written
 * @property int $level_spoken
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\User $User
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserLanguage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserLanguage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserLanguage query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserLanguage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserLanguage whereIdLanguage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserLanguage whereIdUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserLanguage whereLanguage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserLanguage whereLevelSpoken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserLanguage whereLevelWritten($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserLanguage whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \App\User $user
 */
class UserLanguage extends Model
{
    protected $table = "aquabe_users_language";
    protected $fillable = ['language', 'level_written', 'level_spoken'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function getLevelWrittenAttribute($value)
    {
        switch ($value) {
            case 1:
                return 'Básico';
                break;
            case 2:
                return 'Intermedio';
                break;
            case 3:
                return 'Avanzado';
                break;
            case 4:
                return 'Nativo';
                break;
        }
    }

    public function getLevelSpokenAttribute($value)
    {
        switch ($value) {
            case 1:
                return 'Básico';
                break;
            case 2:
                return 'Intermedio';
                break;
            case 3:
                return 'Avanzado';
                break;
            case 4:
                return 'Nativo';
                break;
        }
    }
}