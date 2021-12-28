<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class web_layanan extends Model
{
    use HasFactory;
    protected $guard=['id'];
    protected $fillable=['nama','tipe','url_logo','jabatan'];
}
