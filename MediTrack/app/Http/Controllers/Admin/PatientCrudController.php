<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\PatientRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Support\Facades\Hash;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

/**
 * Class PatientCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class PatientCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Patient::class);
        $this->crud->addButtonFromView('line', 'dossier', 'dossier', 'beginning');
        CRUD::setRoute(config('backpack.base.route_prefix') . '/patient');
        CRUD::setEntityNameStrings('patient', 'patients');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::column('nom');
        CRUD::column('prenom');
        CRUD::addColumn([
            'label' => "Photo",
            'name' => "photo",
            'type' => 'image',
            'upload' => true,
            'disk' => 'local',
            'width' => '50px',
            'height' => '50px',
        ]);
        CRUD::column('email');
        CRUD::column('CIN');
        CRUD::column('sexe');
        CRUD::column('date_naissance');
        CRUD::column('adresse');
        CRUD::column('telephone');
       

        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']); 
         */
    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(PatientRequest::class);
        //first letter in uppercase
        
        CRUD::field('nom')->label('Nom');
        CRUD::field('prenom')->label('Prénom');
        CRUD::field('email')->label('Email');
        CRUD::field('password')->label('Mot de passe')->type('password');
        CRUD::field('CIN');
        //sexe enum
        CRUD::addField([
            'name' => 'sexe',
            'label' => 'Sexe',
            'type' => 'select_from_array',
            'options' => ['Homme' => 'Homme', 'Femme' => 'Femme'],
            'allows_null' => false,
            
        ]);
        CRUD::field('date_naissance')->label('Date de naissance');
        CRUD::field('adresse')->label('Adresse');
        CRUD::field('telephone')->label('Téléphone');
        CRUD::addField([
            'label' => "Photo",
            'name' => "photo",
            'type' => 'upload',
            'upload' => true,
            'disk' => 'local',
            'rules' => 'image',
            'validation' => [
               'messages' => [
               'image' => 'Le fichier doit être une image',
        ],
    ],
        ]);

        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number'])); 
         */
    }
    public function dossier($id)
    {
        if (isset($_GET['patient_id'])) {
            unset($_GET['patient_id']); 
        }
    $admin=backpack_url();
        return redirect($admin.'/dossier-medical?patient_id='.$id);
    }
    public function login(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    $patient = Patient::where('email', $request->email)->first();

    if (!$patient || !Hash::check($request->password, $patient->password)) {
        throw ValidationException::withErrors(['email' => 'Les informations saisies sont incorrectes']);
    }

    return $patient->createToken($request->email)->plainTextToken;
}




    /**
     * Define what happens when the Update operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
