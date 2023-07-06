<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\RendezVousRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\RendezVous; 

/**
 * Class RendezVousCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class RendezVousCrudController extends CrudController
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
        CRUD::setModel(\App\Models\RendezVous::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/rendez-vous');
        CRUD::setEntityNameStrings('rendez vous', 'rendez vous');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::column('date');
        CRUD::column('jour');
        CRUD::column('temps')->label('Heure');
    
        CRUD::addColumn([
            'name' => 'nom_p',
            'type' => 'select',
            'label' => 'Nom de patient',
            'entity' => 'patient',
            'attribute' => 'nom',
            'model' => "App\Models\patient",
        ]);
        CRUD::addColumn([
            'name' => 'prenom_p',
            'type' => 'select',
            'label' => 'Prenom de patient',
            'entity' => 'patient',
            'attribute' => 'prenom',
            'model' => "App\Models\patient",
        ]);
        CRUD::addColumn([
            'name' => 'CIN_p',
            'type' => 'select',
            'label' => 'CIN de patient',
            'entity' => 'patient',
            'attribute' => 'CIN',
            'model' => "App\Models\patient",
        ]);
        CRUD::addColumn([
            'name' => 'nom_m',
            'type' => 'select',
            'label' => 'Nom de medecin',
            'entity' => 'medecin',
            'attribute' => 'nom',
            'model' => "App\Models\medecin",
        ]);
        CRUD::addColumn([
            'name' => 'prenom_m',
            'type' => 'select',
            'label' => 'Prenom de medecin',
            'entity' => 'medecin',
            'attribute' => 'prenom',
            'model' => "App\Models\medecin",
        ]);
        CRUD::addColumn([
            'name' => 'CIN_m',
            'type' => 'select',
            'label' => 'CIN de medecin',
            'entity' => 'medecin',
            'attribute' => 'CIN',
            'model' => "App\Models\medecin",
        ]);
    
        CRUD::column('etat');
        CRUD::column('consultation_id');

        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']); 
         */
    }
    //setupshowoperation
    protected function setupShowOperation()
{
    CRUD::column('date');
    CRUD::column('jour');
    CRUD::column('temps')->label('Heure');
    //add label above column
    CRUD::addColumn([
        'type' => 'raw',
        'label' => '',
    ]);

    CRUD::addColumn([
        'name' => 'nom_p',
        'type' => 'select',
        'label' => 'Nom de patient',
        'entity' => 'patient',
        'attribute' => 'nom',
        'model' => "App\Models\patient",
    ]);
    CRUD::addColumn([
        'name' => 'prenom_p',
        'type' => 'select',
        'label' => 'Prenom de patient',
        'entity' => 'patient',
        'attribute' => 'prenom',
        'model' => "App\Models\patient",
    ]);
    CRUD::addColumn([
        'name' => 'CIN_p',
        'type' => 'select',
        'label' => 'CIN de patient',
        'entity' => 'patient',
        'attribute' => 'CIN',
        'model' => "App\Models\patient",
    ]);
    CRUD::addColumn([
        'type' => 'raw',
        'label' => '',
    ]);

    CRUD::addColumn([
        'name' => 'nom_m',
        'type' => 'select',
        'label' => 'Nom de medecin',
        'entity' => 'medecin',
        'attribute' => 'nom',
        'model' => "App\Models\medecin",
    ]);
    CRUD::addColumn([
        'name' => 'prenom_m',
        'type' => 'select',
        'label' => 'Prenom de medecin',
        'entity' => 'medecin',
        'attribute' => 'prenom',
        'model' => "App\Models\medecin",
    ]);
    CRUD::addColumn([
        'name' => 'CIN_m',
        'type' => 'select',
        'label' => 'CIN de medecin',
        'entity' => 'medecin',
        'attribute' => 'CIN',
        'model' => "App\Models\medecin",
    ]);
    CRUD::addColumn([
        'type' => 'raw',
        'label' => '',
    ]);
    CRUD::column('etat');
    CRUD::column('consultation_id');
}
     public function store(Request $request)
     {
         
            $rendezvous = new RendezVous();
            $rendezvous->patient_id = $request->get('patient_id');
            $rendezvous->medecin_id = $request->get('medecin_id');
            $rendezvous->consultation_id = '0';
            $rendezvous->date= $request->get('date');
            $rendezvous->jour= $request->get('jour');
            $rendezvous->temps= $request->get('temps');
            $rendezvous->etat= 'A venir';
            
            $rendezvous->save();
            return response()->json([
                'success' => 'Un nouveau rendez-vous a ete ajoute avec succès!'], 200);
     }     /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(RendezVousRequest::class);

        CRUD::field('date');
        CRUD::field('jour');
        CRUD::field('temps');
        CRUD::field('patient_id');
        CRUD::field('medecin_id');
        //etat enum
        CRUD::addField([
            'name' => 'etat',
            'label' => 'Etat',
            'type' => 'select_from_array',
            'options' => ['A Venir' => 'A Venir', 'Confirme' => 'Confirme', 'Annule' => 'Annule','Non Confirme' => 'Non Confirme','Effectue' => 'Effectue'],
            'allows_null' => false,
        ]);
    
        CRUD::field('consultation_id');

        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number'])); 
         */
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
