<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\UserSkills
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserSkills newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserSkills newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserSkills query()
 * @mixin \Eloquent
 * @property int $id_skills
 * @property int $id_user
 * @property string $skill
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserSkills whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserSkills whereIdSkills($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserSkills whereIdUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserSkills whereSkill($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserSkills whereUpdatedAt($value)
 */
class UserSkills extends Model
{
    protected $table = "aquabe_users_skills";

    public function user()
    {
        return $this->belongsTo('App\User', 'id', 'id_user');
    }
}
