<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Search
 *
 * @property int $id
 * @property string $search_term
 * @property int|null $user_id
 * @property int|null $quantity
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Search newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Search newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Search query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Search whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Search whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Search whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Search whereSearchTerm($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Search whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Search whereUserId($value)
 * @mixin \Eloquent
 */
class Search extends Model
{

    protected $table = "aquabe_searches";
    protected $fillable = ['search_term', 'user_id', 'quantity'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
