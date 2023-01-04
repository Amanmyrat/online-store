<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\OrderRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class OrderCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class OrderCrudController extends CrudController
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
        CRUD::setModel(\App\Models\Order::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/order');
        CRUD::setEntityNameStrings('order', 'orders');
        
        $this->crud->denyAccess('delete');
        $this->crud->denyAccess('create');
        $this->crud->allowAccess('show');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::column('user_id');
        CRUD::column('guest_id');
        CRUD::column('user_name');
        CRUD::column('user_email');
        CRUD::column('address');
        CRUD::column('status');
        CRUD::column('total');
        CRUD::column('products');
        CRUD::column('created_at');
        CRUD::column('updated_at');

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
        CRUD::setValidation(OrderRequest::class);

        CRUD::field('user_id');
        CRUD::field('guest_id');
        CRUD::field('user_name');
        CRUD::field('user_email');
        CRUD::field('address');
        CRUD::field('status')->type('enum')
        ->options([
                'Pending' => 'Pending',
                'Processing' => 'Processing',
                'Completed' => 'Completed',
                'Failed' => 'Failed',
            ]);

        CRUD::field('total');
        CRUD::field('products')->type('repeatable')->fields([ 
            [
                'name'    => 'name',
                'type'    => 'text',
                'label'   => 'Name',
                'wrapper' => ['class' => 'form-group col-md-12'],
            ],
            [
                'name'    => 'quantity',
                'type'    => 'number',
                'label'   => 'Quantity',
                'wrapper' => ['class' => 'form-group col-md-12'],
            ],
        ])->new_item_label("Add product");

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
