<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consultation extends Model
{
    use CrudTrait;
    protected $fillable=[
        'diagnostic',
        'traitement_id',
    ];
    use HasFactory;
    public function traitement(){
        return $this->belongsTo(Traitement::class);
    }
    public function rendezvous(){
        return $this->hasMany(RendezVous::class);
    }
}
