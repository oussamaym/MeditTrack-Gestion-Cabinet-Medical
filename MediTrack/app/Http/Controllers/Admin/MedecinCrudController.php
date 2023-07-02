<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\MedecinRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class MedecinCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class MedecinCrudController extends CrudController
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
        CRUD::setModel(\App\Models\Medecin::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/medecin');
        CRUD::setEntityNameStrings('medecin', 'medecins');
    }

    //function to return all doctors
    public function getMedecins()
    {
        $medecins = \App\Models\Medecin::all();
        return $medecins;
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
        CRUD::column('email');
        CRUD::addColumn([
            'label' => "Photo",
            'name' => "photo",
            'type' => 'image',
            'upload' => true,
            'disk' => 'local',
            'width' => '50px',
            'height' => '50px',
        ]);
        CRUD::column('CIN');
        CRUD::column('password');
        CRUD::column('date_debut');
        CRUD::column('specialite');

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
        CRUD::setValidation(MedecinRequest::class);

        CRUD::field('nom');
        CRUD::field('prenom');
        CRUD::field('email');
        CRUD::field('CIN');
        CRUD::field('password');
        CRUD::field('date_debut');
        //specialite enum
        CRUD::addField([
            'name' => 'specialite',
            'label' => 'Specialite',
            'type' => 'select_from_array',
            'options' => ['Cardiologue' => 'Cardiologue', 'Dermatologue' => 'Dermatologue', 'Généraliste' => 'Généraliste', 'Gynécologue' => 'Gynécologue', 'Ophtalmologue' => 'Ophtalmologue', 'ORL' => 'ORL', 'Pédiatre' => 'Pédiatre', 'Psychiatre' => 'Psychiatre', 'Radiologue' => 'Radiologue', 'Urologue' => 'Urologue', 'Autre' => 'Autre'],
            'allows_null' => false,
        ]);
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
