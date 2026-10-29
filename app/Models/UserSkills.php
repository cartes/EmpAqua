<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\UserSkills
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserSkills newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserSkills newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserSkills query()
 * @mixin \Eloquent
 * @property int $id_skills
 * @property int $id_user
 * @property string $skill
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserSkills whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserSkills whereIdSkills($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserSkills whereIdUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserSkills whereSkill($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserSkills whereUpdatedAt($value)
 */
class UserSkills extends Model
{
    protected $table = "aquabe_users_skills";
    protected $primaryKey = "id_skills";
    protected $fillable = ['skill'];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }
}
