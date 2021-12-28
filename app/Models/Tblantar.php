<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tblantar extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'tbljemput_id',
        'user_id',
        'ongkir',
        'talangan',
        'status_id',
        'catatan',
        'created_at',
        'created_at',

    ];
    // protected $guard=['created_at'];
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
    public function status()
    {
        return $this->belongsTo(Status::class);
    }
    public function jemput()
    {
        return $this->belongsTo(Tbljemput::class,'tbljemput_id','id');
    }
}
