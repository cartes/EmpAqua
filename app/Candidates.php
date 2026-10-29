<?php

namespace App;

use App\Traits\DatesTranslator;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Candidates
 *
 * @property int $id
 * @property int $id_offer
 * @property int $id_candidate
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Offers $Offers
 * @property-read \App\User $User
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Candidates newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Candidates newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Candidates query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Candidates whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Candidates whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Candidates whereIdCandidate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Candidates whereIdOffer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Candidates whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \App\Offers $offers
 * @property-read \App\User $user
 * @property int $id_user
 * @property-read mixed $date
 * @property-read mixed $postulated
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Candidates whereIdUser($value)
 * @property int|null $status
 * @property-read mixed $deleted_at
 * @property-read mixed $expirated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Candidates whereStatus($value)
 */
class Candidates extends Model
{
    use DatesTranslator;

    public const REVIEWED = 1;
    public const SCHEDULED = 2;

    protected $table = "aquabe_offers_candidates";
    protected $fillable = ['id_offer', 'id_user', 'status', 'favorite', 'created_at'];

    public function offers()
    {
        return $this->belongsTo('App\Offers', 'id_offer', 'id');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'id_user', 'id');
    }
    
    public function candidateStatus()
    {
        return $this->hasOne(CandidateStatus::class, 'candidate_id', 'id_user');
    }


    public function getPostulatedAttribute($value)
    {
        $publication = $this->attributes['created_at'];

        return Carbon::parse($publication)->diffForHumans();
    }
    
    public function getStatusAttribute() {
        $status = $this->attributes['status'];

        switch ($status) {
            case null:
                return [
                    'class' => "w-0",
                    "text" => "Sin cambio"
                ];
            case "1":
                return [
                    "class" => "w-50",
                    "text" => "CV visto"
                ];
            case "2":
                return [
                    "class" => "w-75",
                    "text" => "Entrevista agendada"
                ];
            case "3":
                return [
                    "class" => "w-100",
                    "text" => "xx xxx"
                ];
            case "4":
                return [
                    "class" => "w-100",
                    "text" => "favorite"
                ];

        }
    }

    public function getDateAttribute()
    {
        return Carbon::parse($this->attributes['created_at'])->format('d/m/Y');
    }

}
