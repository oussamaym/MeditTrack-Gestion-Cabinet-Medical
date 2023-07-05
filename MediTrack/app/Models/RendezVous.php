<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RendezVous extends Model
{
    use CrudTrait;
    protected $fillable = [ 
        'date',
        'jour',
        'temps',
        'etat',
        'patient_id',
        'medecin_id',
        'consultation_id',
    ];
    use HasFactory;
    public function getTable()
    {
        return 'rendezvous';
    }
    public function patient(){
        return $this->belongsTo(Patient::class);
    }
    public function medecin(){
        return $this->belongsTo(Medecin::class);
    }
    public function consultation(){
        return $this->belongsTo(Consultation::class);
    }
    public function planning()
    {
        return $this->belongsTo(Planning::class);
    }

}
