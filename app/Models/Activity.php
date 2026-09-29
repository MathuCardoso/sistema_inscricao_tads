<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['activity_type', 'start_time', 'end_time', 'description', 'date'])]
class Activity extends Model {

    public function participants() {
        return $this->belongsToMany(Participant::class, 'registrations');
    }
}
