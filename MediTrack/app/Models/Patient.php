<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class Patient extends Authenticatable
{
    use CrudTrait;
    use HasApiTokens, HasFactory, Notifiable;
    protected $fillable=[
        'nom',
        'prenom',
        'email',
        'CIN',
        'password',
        'sexe',
        'date_naissance',
        'adresse',
        'telephone',
        'photo',
    ];
    use HasFactory;
    public function rendezvous()
    {
        return $this->hasMany(RendezVous::class);
    }
    public static function boot()
    {
        parent::boot();
        static::deleting(function($obj) {
            \Storage::disk('public')->delete($obj->photo);
        });
    }
    public function setPasswordAttribute($value)
    {
    if (!empty($value) && Hash::needsRehash($value)) {
        $this->attributes['password'] = Hash::make($value);
    }
    else{
        $this->attributes['password'] = $value;
    }
    }
    public function setPhotoAttribute($value)
    {

        $attribute_name = "photo";
        $disk = "public";
        $destination_path = "images/patients";
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
}
