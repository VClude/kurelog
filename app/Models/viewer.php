<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class viewer extends Model
{
    protected $table = 'viewer';
    public $timestamps = false;
    use HasFactory;
}
