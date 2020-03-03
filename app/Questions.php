<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Questions extends Model
{
    protected $fillable = [
        'user_id',
        'level',
        'subject',
        'title',
        'details',
        'pages',
        'price'
    ];

   // protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
