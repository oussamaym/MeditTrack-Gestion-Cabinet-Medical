<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Planning extends Model
{
    use CrudTrait;
    protected $fillable=[
        'jours_travail', 
        'heure_debut',
        'heure_fin',
        'medecin_id',       
        'rendezvous_id'
    ];

    use HasFactory;
    public function medecin(){
        return $this->belongsTo(Medecin::class);
    }
    //plqnning has many rendezvous
        public function rendezvous()
    {
        return $this->hasMany(RendezVous::class);
    }

}
