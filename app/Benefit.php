<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Benefit
 *
 * @property int $id
 * @property int $offer_id
 * @property string $benefit
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Offers $Offers
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Benefit newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Benefit newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Benefit query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Benefit whereBenefit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Benefit whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Benefit whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Benefit whereOfferId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Benefit whereUpdatedAt($value)
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
