<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dokumentasi extends Model
{
    use HasFactory;
    protected $fillable=[
        'title',
        'desc',
        'link',
    ];
    protected $guard=['id','created_at','updated_at'];

}
