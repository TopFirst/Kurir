<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seller extends Model
{
    use HasFactory;
    protected $fillable=[
        'hp',
        'nama',
        'deskripsi'
    ];
    protected $guard=['id','created_at','updated_at'];
    /**
     * Get daftar jemputan by user
     */
    public function jemputan()
    {
        return $this->hasMany(Tbljemput::class,'hp_seller','hp');
    }
}
