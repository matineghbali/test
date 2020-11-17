<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;

    protected $fillable = [
        'house_name_number',
        'postcode'
    ];

    public function users()
    {
        return $this->belongsToMany('App\Models\User','owners')->withPivot(['main_owner']);
    }
}
