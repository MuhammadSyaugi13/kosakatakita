<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vocabularies extends Model
{
    use HasFactory;
    protected $table = 'vocabularies';
    protected $guarded = ['id'];
}
