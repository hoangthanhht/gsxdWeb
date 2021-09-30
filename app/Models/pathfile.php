<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pathfile extends Model
{
    use HasFactory;
    protected $fillable = [
        'idFile',
        'aliasTable',
        'path',
        'rootName'
    ];
}
