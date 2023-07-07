<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class Medecin extends Authenticatable
{
    use CrudTrait;
    use HasApiTokens, HasFactory, Notifiable;
    protected $fillable=[
        'nom',
        'prenom',
        'email',
        'CIN',
        'password',
        'date_debut',
        'specialite',
        'photo',
    ];
    /* @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
    

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    public function plannings()
    {
        return $this->hasOne(Planning::class);
    }
    public function rendezvous()
    {
        return $this->hasMany(RendezVous::class);
    }    
    public function conversations()
    {
        return $this->hasMany(Conversation::class);
    }
    public function messages()
    {
        return $this->hasMany(Message::class);
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
   public static function boot()
    {
        parent::boot();
        static::deleting(function($obj) {
            \Storage::disk('public')->delete($obj->photo);
        });
    }
    public function setPhotoAttribute($value)
    {

        $attribute_name = "photo";
        $disk = "public";
        $destination_path = "images/medecins";
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
