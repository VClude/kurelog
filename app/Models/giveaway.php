<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class giveaway extends Model
{
    protected $table = "giveaway";
    public $timestamps = false;
    use HasFactory;
}
