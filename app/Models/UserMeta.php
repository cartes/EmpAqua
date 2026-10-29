<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\UserMeta
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserMeta newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserMeta newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserMeta query()
 * @mixin \Eloquent
 * @property int $id
 * @property int $id_user
 * @property string $pretentions
 * @property string $phone
 * @property string $address
 * @property string $comune
 * @property string $city
 * @property string $state
 * @property string $objectives
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $User
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserMeta whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserMeta whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserMeta whereComune($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserMeta whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserMeta whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserMeta whereIdUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserMeta whereObjectives($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserMeta wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserMeta wherePretentions($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserMeta whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserMeta whereUpdatedAt($value)
 * @property-read \App\Models\User $user
 * @property string|null $country
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserMeta whereCountry($value)
 * @property string|null $path
 * @property string|null $filename
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserMeta whereFilename($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserMeta wherePath($value)
 */
class UserMeta extends Model
{
    protected $table = "aquabe_users_meta";
    protected $primaryKey = 'id';

    protected $fillable = ['id_user', 'pretentions', 'phone', 'address', 'country', 'comune', 'city', 'state', 'objectives', 'path', 'filename', 'extra_path', 'extra_filename', 'support_doc_path', 'support_doc_name'];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
