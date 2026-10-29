<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\UserMeta
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserMeta newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserMeta newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserMeta query()
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
 * @property-read \App\User $User
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserMeta whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserMeta whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserMeta whereComune($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserMeta whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserMeta whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserMeta whereIdUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserMeta whereObjectives($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserMeta wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserMeta wherePretentions($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserMeta whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserMeta whereUpdatedAt($value)
 * @property-read \App\User $user
 * @property string|null $country
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserMeta whereCountry($value)
 * @property string|null $path
 * @property string|null $filename
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserMeta whereFilename($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserMeta wherePath($value)
 */
class UserMeta extends Model
{
    protected $table = "aquabe_users_meta";
    protected $primaryKey = 'id';

    protected $fillable = ['id_user', 'pretentions', 'phone', 'address', 'country', 'comune', 'city', 'state', 'objectives', 'path', 'filename', 'extra_path', 'extra_filename', 'support_doc_path', 'support_doc_name'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
