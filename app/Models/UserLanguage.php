<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\UserLanguage
 *
 * @property int $id_language
 * @property int $id_user
 * @property string $language
 * @property int $level_written
 * @property int $level_spoken
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $User
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserLanguage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserLanguage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserLanguage query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserLanguage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserLanguage whereIdLanguage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserLanguage whereIdUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserLanguage whereLanguage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserLanguage whereLevelSpoken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserLanguage whereLevelWritten($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserLanguage whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \App\Models\User $user
 */
class UserLanguage extends Model
{
    protected $table = "aquabe_users_language";
    protected $fillable = ['language', 'level_written', 'level_spoken'];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
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