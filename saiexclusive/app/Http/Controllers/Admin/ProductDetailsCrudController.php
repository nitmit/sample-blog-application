<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ProductDetailsRequest;
use App\Models\Colour;
use App\Models\Product;
use App\Models\ProductDetails;
use App\Models\Size;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class ProductDetailsCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ProductDetailsCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation {
        store as traitStore;
    }
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        $this->crud->setModel('App\Models\ProductDetails');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/productdetails');
        $this->crud->setEntityNameStrings('productdetails', 'product_details');
    }

    protected function setupListOperation()
    {
        // TODO: remove setFromDb() and manually define Columns, maybe Filters
        //$this->crud->setFromDb();
        $this->crud->addColumns([
            [  // Select
                'label' => "Product",
                'type' => 'text',
                'name' => 'product.name', // the db column for the foreign key
            ],
            [  // Select
                'label' => "Size",
                'type' => 'text',
                'name' => 'size.name', // the db column for the foreign key
            ],
            [  // Select
                'label' => "Colour",
                'type' => 'text',
                'name' => 'colour.name', // the db column for the foreign key
            ],
            [  // Select
                'label' => "Quantity",
                'type' => 'number',
                'name' => 'quantity', // the db column for the foreign key
            ],
        ]);

        $this->crud->addFilter([
            'name'  => 'product_id',
            'type'  => 'select2',
            'label' => 'Product'
        ], function () {
            return Product::all()->pluck('name', 'id')->toArray();
        }, function ($value) { // if the filter is active
            $this->crud->addClause('where', 'product_id', $value);
        });
        $this->crud->addFilter([
            'name'  => 'size_id',
            'type'  => 'select2',
            'label' => 'Size'
        ], function () {
            return Size::all()->pluck('name', 'id')->toArray();
        }, function ($value) { // if the filter is active
            $this->crud->addClause('where', 'size_id', $value);
        });
        $this->crud->addFilter([
            'name'  => 'colour_id',
            'type'  => 'select2',
            'label' => 'Colour'
        ], function () {
            return Colour::all()->pluck('name', 'id')->toArray();
        }, function ($value) { // if the filter is active
            $this->crud->addClause('where', 'colour_id', $value);
        });
    }

    protected function setupCreateOperation()
    {
        $this->crud->setValidation(ProductDetailsRequest::class);

        // TODO: remove setFromDb() and manually define Fields
        //$this->crud->setFromDb();
        $this->crud->addFields([
            [
                'label'     => "Product",
                'type'      => 'select2',
                'name'      => 'product_id', // the db column for the foreign key
                'entity'    => 'product', // the method that defines the relationship in your Model
                'attribute' => 'name', // foreign key attribute that is shown to user

                // optional
                'model'     => "App\Models\Product", // foreign key model
                'options'   => (function ($query) {
                    return $query->orderBy('name', 'ASC')->get();
                }),
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6'
                ],
            ],
            [   // select_from_array
                'name'        => 'size_type',
                'label'       => "Size Type",
                'type'        => 'select_from_array',
                'options'     => ['letter' => 'S-M-L-XL', 'number' => '30-32-34'],
                'allows_null' => false,
                'default'     => 'letter',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6'
                ],
                // 'allows_multiple' => true, // OPTIONAL; needs you to cast this to array in your model;
            ],
            [
                'name' => 'details',
                'label' => 'Details',
                'type' => 'repeatable',
                'fields' => [
                    [
                        // 1-n relationship
                        'label'       => "Size", // Table column heading
                        'type'        => "select2_from_ajax",
                        'name'        => 'size_id', // the column that contains the ID of that connected entity
                        'entity'      => 'size', // the method that defines the relationship in your Model
                        'attribute'   => "name", // foreign key attribute that is shown to user
                        'data_source' => url("api/getSize"), // url to controller search function (with /{id} should return model)

                        // OPTIONAL
                        'placeholder'             => "Select a size", // placeholder for the select
                        'minimum_input_length'    => 0, // minimum characters to type before querying results
                        'model'                   => "App\Models\Size", // foreign key model
                        'dependencies'            => ['size_type'], // when a dependency changes, this select2 is reset to null
                        'method'                  => 'GET', // optional - HTTP method to use for the AJAX call (GET, POST)
                        'include_all_form_fields' => true, // optional - only send the current field through AJAX (for a smaller payload if you're not using multiple chained select2s)
                        'wrapperAttributes' => [
                            'class' => 'form-group col-md-4'
                        ],
                    ],
                    [
                        'label'     => "Colour",
                        'type'      => 'select2',
                        'name'      => 'colour_id', // the db column for the foreign key
                        'entity'    => 'colour', // the method that defines the relationship in your Model
                        'attribute' => 'name', // foreign key attribute that is shown to user

                        // optional

                        'model'     => "App\Models\Colour", // foreign key model
                        'options'   => (function ($query) {
                            return $query->orderBy('name', 'ASC')->get();
                        }),
                        'wrapperAttributes' => [
                            'class' => 'form-group col-md-4'
                        ],
                    ],
                    [
                        'name' => 'quantity',
                        'label' => 'Quantity',
                        'type' => 'number',
                        'wrapperAttributes' => [
                            'class' => 'form-group col-md-4'
                        ],
                    ]
                ],
            ]
        ]);
        //$this->crud->addFields([]);
    }

    protected function setupUpdateOperation()
    {
        // $this->setupCreateOperation();
        $this->crud->addFields([
            [
                'label'     => "Product",
                'type'      => 'select2',
                'name'      => 'product_id', // the db column for the foreign key
                'entity'    => 'product', // the method that defines the relationship in your Model
                'attribute' => 'name', // foreign key attribute that is shown to user

                // optional
                'model'     => "App\Models\Product", // foreign key model
                'options'   => (function ($query) {
                    return $query->orderBy('name', 'ASC')->get();
                }),
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6'
                ],
            ],
            [   // select_from_array
                'name'        => 'size_type',
                'label'       => "Size Type",
                'type'        => 'select_from_array',
                'options'     => ['letter' => 'S-M-L-XL', 'number' => '30-32-34'],
                'allows_null' => false,
                'default'     => 'letter',
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-6'
                ],
                // 'allows_multiple' => true, // OPTIONAL; needs you to cast this to array in your model;
            ],
            [
                'label'     => "Size",
                'type'      => 'select2',
                'name'      => 'size_id', // the db column for the foreign key
                'entity'    => 'size', // the method that defines the relationship in your Model
                'attribute' => 'name', // foreign key attribute that is shown to user

                // optional
                'model'     => "App\Models\Size", // foreign key model
                'options'   => (function ($query) {
                    return $query->orderBy('name', 'ASC')->get();
                }),
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-4'
                ],
            ],
            [
                'label'     => "Coloue",
                'type'      => 'select2',
                'name'      => 'colour_id', // the db column for the foreign key
                'entity'    => 'colour', // the method that defines the relationship in your Model
                'attribute' => 'name', // foreign key attribute that is shown to user

                // optional
                'model'     => "App\Models\Colour", // foreign key model
                'options'   => (function ($query) {
                    return $query->orderBy('name', 'ASC')->get();
                }),
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-4'
                ],
            ],
            [
                'label'     => "Quantity",
                'type'      => 'number',
                'name'      => 'quantity', // the db column for the foreign key
                'wrapperAttributes' => [
                    'class' => 'form-group col-md-4'
                ],
            ]
        ]);
    }

    protected function setupShowOperation()
    {
        $this->crud->addColumns([
            [  // Select
                'label' => "Product",
                'type' => 'text',
                'name' => 'product.name', // the db column for the foreign key
            ],
            [  // Select
                'label' => "Size",
                'type' => 'text',
                'name' => 'size.name', // the db column for the foreign key
            ],
            [  // Select
                'label' => "Colour",
                'type' => 'text',
                'name' => 'colour.name', // the db column for the foreign key
            ],
            [  // Select
                'label' => "Quantity",
                'type' => 'number',
                'name' => 'quantity', // the db column for the foreign key
            ],
        ]);
    }

    public function store()
    {
        $request = $this->crud->validateRequest();

        // insert item in the db
        // $item = $this->crud->create($this->crud->getStrippedSaveRequest());
        $saveReq = $this->crud->getStrippedSaveRequest();

        foreach (json_decode($saveReq['details']) as $detail) {
            $item = new ProductDetails();
            $item->product_id = $saveReq['product_id'];
            $item->colour_id = $detail->colour_id;
            $item->size_id = $detail->size_id;
            $item->quantity = $detail->quantity;
            $item->save();
        }
        $this->data['entry'] = $this->crud->entry = $item;

        // show a success message
        \Alert::success(trans('backpack::crud.insert_success'))->flash();

        // save the redirect choice for next time
        $this->crud->setSaveAction();

        return $this->crud->performSaveAction($item->getKey());
    }
}