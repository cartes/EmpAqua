<?php

namespace App\Traits;

use Carbon\Carbon;

trait DatesTranslator
{
    public function getCreatedAtAttribute($created_at)
    {
        return Carbon::parse($created_at);
    }

    public function getUpdatedAtAttribute($updated_at)
    {
        return Carbon::parse($updated_at);
    }

    public function getDeletedAtAttribute($deleted_at)
    {
        return $deleted_at ? Carbon::parse($deleted_at) : null;
    }

    public function getExpiratedAtAttribute($expirated_at)
    {
        return Carbon::parse($expirated_at);
    }
}
