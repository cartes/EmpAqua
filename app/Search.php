<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Search
 *
 * @property int $id
 * @property string $search_term
 * @property int|null $user_id
 * @property int|null $quantity
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Search newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Search newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Search query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Search whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Search whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Search whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Search whereSearchTerm($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Search whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Search whereUserId($value)
 * @mixin \Eloquent
 */
class Search extends Model
{

    protected $table = "aquabe_searches";
    protected $fillable = ['search_term', 'user_id', 'quantity'];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
