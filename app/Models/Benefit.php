<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Benefit
 *
 * @property int $id
 * @property int $offer_id
 * @property string $benefit
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Offers $Offers
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Benefit newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Benefit newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Benefit query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Benefit whereBenefit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Benefit whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Benefit whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Benefit whereOfferId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Benefit whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Benefit extends Model
{
    protected $table = "aquabe_offers_benefit";
    protected $fillable = ['offer_id', 'benefit'];

    public function Offers()
    {
        return $this->belongsTo(Offers::class, 'id', 'offer_id');
    }
}
