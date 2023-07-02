<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Secretaire extends Model
{
    use CrudTrait;
    protected $fillable=[
        'nom',
        'prenom',
        'email',
        'password',
    ];
    use HasFactory;
}
