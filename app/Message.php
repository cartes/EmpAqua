<?php

namespace App;

use App\Traits\DatesTranslator;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Message
 *
 * @property int $id
 * @property string|null $subject
 * @property int $offer_id
 * @property int $user_id
 * @property string $content
 * @property string|null $message_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Offers $offer
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Message newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Message newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Message query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Message whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Message whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Message whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Message whereMessageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Message whereOfferId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Message whereSubject($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Message whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Message whereUserId($value)
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
