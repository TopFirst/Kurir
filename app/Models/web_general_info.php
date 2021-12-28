<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class web_general_info extends Model
{
    use HasFactory;

    protected $guard=['id'];
    protected $fillable=['nama','hp1','hp2','email1','email2','alamat1','alamat2','url_logo','fb','twitter','ig','yt','judul','subjudul','excerpt1','excerpt2','url_mainpic'];
}
