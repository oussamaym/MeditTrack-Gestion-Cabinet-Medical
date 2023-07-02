<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Traitement extends Model
{
    use CrudTrait;
    protected $fillable=[
        'ordonnance',
    ];
    use HasFactory;
    public function consultation(){
        return $this->hasOne(Consultation::class); 
    }
}
