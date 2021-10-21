<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Encryption extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public $timestamps = true;
}
