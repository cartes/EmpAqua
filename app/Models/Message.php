<?php

namespace App\Models;

use App\Traits\DatesTranslator;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Message
 *
 * @property int $id
 * @property string|null $subject
 * @property int $offer_id
 * @property int $user_id
 * @property string $content
 * @property string|null $message_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Offers $offer
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Message newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Message newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Message query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Message whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Message whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Message whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Message whereMessageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Message whereOfferId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Message whereSubject($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Message whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Message whereUserId($value)
 * @mixin \Eloquent
 */
class Message extends Model
{
    use DatesTranslator;

    const SENDED = 0;
    const UNREAD = 1;
    const READED = 2;
    const REPLYED = 3;
    const FINISHED = 4;

    protected $table = "aquabe_messages";
    protected $fillable = [
        'subject',
        'offer_id',
        'user_id',
        'content',
        'message_id',
        'status',
        'sender_id'
    ];

    public function offer()
    {
        return $this->belongsTo(Offers::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function children()
    {
        return $this->hasMany(Message::class, 'message_id');
    }

    public function getCreatedAtAttribute()
    {
        $date = Carbon::parse($this->attributes['created_at'])->format("H\\:i d M");
        return $date;
    }
}
