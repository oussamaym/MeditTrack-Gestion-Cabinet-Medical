<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DossierMedical extends Model
{
    use CrudTrait;
    use HasFactory;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'dossier_medicals';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    protected $fillable = [
        'description',
        'fichier',
        'patient_id',
    ];
    // protected $hidden = [];
    // protected $dates = [];

    public static function boot()
    {
        parent::boot();
        static::deleting(function($obj) {
            \Storage::disk('public')->delete($obj->photo);
        });
    }

    public function setFichierAttribute($value)
    {

        $attribute_name = "fichier";
        $disk = "public";
        $destination_path = "fichiers/patients";
        //filename is the last name of the patient with extension
        $fileName = $this->nom.'.'.$value->getClientOriginalExtension();
        if ($value==null) {
            // delete the image from disk
            Storage::delete(Str::replaceFirst('storage/','public/',$this->{$attribute_name}));
            // set null in the database column
            $this->attributes[$attribute_name] =  $destination_path.'/'.$fileName;

        }
        $this->uploadFileToDisk($value, $attribute_name, $disk, $destination_path, $fileName);
      
    }
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
