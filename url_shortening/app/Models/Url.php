<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Url extends Model
{
    use HasFactory;
    protected $table = 'url';
    protected $fillable = [
        'original_url',
        'short_url',
        'user_id',
        'clicks',
        'expiration_date',
    ];

    protected $casts = [
        'expiration_date' => 'datetime',
    ];
    public $timestamps = true;
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}



