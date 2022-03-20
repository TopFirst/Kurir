<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tbljemput extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'user_id',
        'deskripsi',
        'hp_seller',
        'ongkir',
        'talangan',
        'created_at',
        'updated_at',
    ];
    // protected $guard=['created_at'];
    // protected $with=['kurir','seller','antar'];
    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';
    /**
     * Indicates if the model's ID is auto-incrementing.
     * id tidak boleh auto increment gegara tipe nya string
     * @var bool
     */
    public $incrementing = false;
    /**
     * The data type of the auto-incrementing ID.
     * memastikan bahwa id bukan integer, tapi string
     * @var string
     */
    protected $keyType = 'string';

    public function kurir()
    {
        return $this->belongsTo(User::class,'user_id');
    }
    public function seller()
    {
        return $this->belongsTo(Seller::class,'hp_seller','hp');
    }
    public function antar()
    {
        return $this->hasOne(Tblantar::class,'tbljemput_id','id');
    }
}
