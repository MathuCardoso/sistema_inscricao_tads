<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['name', 'email', 'cpf', 'phone'])]
class Participant extends Model {

    public function activities() {
        return $this->belongsToMany(Activity::class, 'registrations');
    }
}
