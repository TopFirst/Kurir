<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppConfig extends Model
{
    public $timestamps = false;
    use HasFactory;
    protected $fillable=[
        'slug',
        'parameter_name',
        'parameter_value',
        'parameter_unit',
    ];
    protected $guard=['id'];
}