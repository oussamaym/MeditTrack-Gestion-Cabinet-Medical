<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\DossierMedicalRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Http\Request;
use App\Models\DossierMedical;
use Illuminate\Support\Facades\DB;
//use storage
use Illuminate\Support\Facades\Storage;

/**
 * Class DossierMedicalCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class DossierMedicalCrudController extends CrudController
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
        CRUD::setModel(\App\Models\DossierMedical::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/dossier-medical');
        CRUD::setEntityNameStrings('dossier medical', 'dossier medicals');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        if (request()->has('patient_id')) {
            $patientID = request()->input('patient_id');
            $this->crud->addClause('where', 'patient_id', '=', $patientID);
        }
        CRUD::column('description');
        //type image is file exists and type column otherwise
        
            CRUD::addColumn([
                'label' => "Fichier",
                'name' => "fichier",
                'type' => 'image',
                'upload' => true,
                'disk' => 'local',
                'width' => '100px',
                'height' => '150px',
            ]);
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
        CRUD::setValidation(DossierMedicalRequest::class);

        CRUD::field('description');
        CRUD::addField([
            'name' => 'fichier',
            'type' => 'upload',
            'upload' => true,
            'disk' => 'local', 
        ]);
        CRUD::field('patient_id');

        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number'])); 
         */
    }
    public function createdossier(Request $request)
    { 
        DB::beginTransaction();
        try{
        $dossier = new DossierMedical();
        $dossier->description = $request->description;
        $dossier->patient_id = $request->patient_id;
        if ($request->hasFile('fichier')) {
            $originalFileName = $request->file('fichier')->getClientOriginalName();
            $dossier->fichier = $request->file('fichier')->storeAs($request->fichier_path, $originalFileName, 'public');          
        } 
        else {
            $dossier->fichier = 'Pas de fichier';
        }
        $dossier->save();
        DB::commit();
        return response()->json(['success' => 'Dossier Medical ajoute avec succes'], 200);
         }
        catch(\Exception $e){
            DB::rollback();
            return response()->json(['error' => 'Dossier Medical non ajoute'], 500);
        }       
    }    
    //get dossier medical by patient id
    public function getDossierMedicalByPatientId($id)
    {
        $dossierMedical = DossierMedical::where('patient_id', $id)->get();
        return $dossierMedical;
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
