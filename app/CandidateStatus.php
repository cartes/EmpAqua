<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class CandidateStatus extends Model
{
    protected $table = 'aquabe_candidate_statuses';

    protected $fillable = [
        'candidate_id', 
        'offer_id', 
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'candidate_id');
    }

    public function offer()
    {
        return $this->belongsTo(Offer::class, 'offer_id');
    }
}