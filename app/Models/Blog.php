<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'display_name'
    ];

    public function getRouteKeyName()
    {
        return 'name';
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
