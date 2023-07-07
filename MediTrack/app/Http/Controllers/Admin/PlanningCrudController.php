<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\PlanningRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class PlanningCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class PlanningCrudController extends CrudController
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
        CRUD::setModel(\App\Models\Planning::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/planning');
        CRUD::setEntityNameStrings('planning', 'plannings');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::column('jours_travail');
        CRUD::column('heure_debut');
        CRUD::column('heure_fin');
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
        CRUD::setValidation(PlanningRequest::class);

        CRUD::field('jours_travail');
        CRUD::field('heure_debut');
        CRUD::field('heure_fin');
        CRUD::field('medecin_id');
        //add field rendezvous_id by patient name
       


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
