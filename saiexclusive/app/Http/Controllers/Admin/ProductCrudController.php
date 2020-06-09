<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ProductRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Size;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class ProductCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ProductCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        $this->crud->setModel('App\Models\Product');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/product');
        $this->crud->setEntityNameStrings('product', 'products');
    }

    protected function setupListOperation()
    {
        // TODO: remove setFromDb() and manually define Columns, maybe Filters
        $this->crud->setFromDb();
        $this->crud->removeColumns(['category_id', 'brand_id', 'mrp', 'sale_price', 'images', 'description']);
        $this->crud->addColumns([
            [  // Select
                'label' => "Category",
                'type' => 'text',
                'name' => 'category.name', // the db column for the foreign key
            ],
            [  // Select
                'label' => "Brand",
                'type' => 'text',
                'name' => 'brand.name', // the db column for the foreign key
            ],
            [
                'label' => "MRP",
                'type' => 'model_function',
                'name' => 'mrp',
                'function_name' => 'getFormattedAmount',
                'function_parameters' => ['mrp'],
            ],
            [
                'label' => "Sale Price",
                'type' => 'model_function',
                'name' => 'sale_price',
                'function_name' => 'getFormattedAmount',
                'function_parameters' => ['sale_price'],
            ],
            // [
            //     'name'      => 'image', // The db column name
            //     'label'     => 'Image', // Table column heading
            //     'type'      => 'image',
            //     // 'prefix' => 'folder/subfolder/',
            //     // image from a different disk (like s3 bucket)
            //     'disk'   => 'public',
            //     // optional width/height if 25px is not ok with you
            //     'height' => '80px',
            //     'width'  => '80px',
            // ]
        ]);

        $this->crud->addFilter([
            'name'  => 'category_id',
            'type'  => 'select2',
            'label' => 'Category'
        ], function () {
            return Category::all()->pluck('name', 'id')->toArray();
        }, function ($value) { // if the filter is active
            $this->crud->addClause('where', 'catgeory_id', $value);
        });
        $this->crud->addFilter([
            'name'  => 'brand_id',
            'type'  => 'select2',
            'label' => 'Brand'
        ], function () {
            return Brand::all()->pluck('name', 'id')->toArray();
        }, function ($value) { // if the filter is active
            $this->crud->addClause('where', 'brand_id', $value);
        });
    }

    protected function setupCreateOperation()
    {
        $this->crud->setValidation(ProductRequest::class);

        // TODO: remove setFromDb() and manually define Fields
        $this->crud->setFromDb();
        $this->crud->removeFields(['category_id', 'brand_id', 'images']);
        $this->crud->addField([  // Select
            'label' => "Category",
            'type' => 'select',
            'name' => 'category_id', // the db column for the foreign key
            'entity' => 'category', // the method that defines the relationship in your Model
            'attribute' => 'name', // foreign key attribute that is shown to user

            // optional
            'model' => "App\Models\Category",
            'options'   => (function ($query) {
                return $query->orderBy('name', 'ASC')->get();
            }), // force the related options to be a custom query, instead of all(); you can use this to filter the results show in the select
        ]);
        $this->crud->addField([  // Select
            'label' => "Brand",
            'type' => 'select',
            'name' => 'brand_id', // the db column for the foreign key
            'entity' => 'brand', // the method that defines the relationship in your Model
            'attribute' => 'name', // foreign key attribute that is shown to user

            // optional
            'model' => "App\Models\Brand",
            'options'   => (function ($query) {
                return $query->orderBy('name', 'ASC')->get();
            }), // force the related options to be a custom query, instead of all(); you can use this to filter the results show in the select
        ]);
        $this->crud->addField([   // Upload
            'name'      => 'images',
            'label'     => 'Images',
            'type'      => 'upload_multiple',
            'upload'    => true,
            'disk'      => 'public', // if you store files in the /public folder, please ommit this; if you store them in /storage or S3, please specify it;
            // optional:
            //'temporary' => 10 // if using a service, such as S3, that requires you to make temporary URL's this will make a URL that is valid for the number of minutes specified
        ]);
        $this->crud->addField([
            'name' => 'size_type',
            'label' => 'Size Type',
            'type' => 'select_from_array',
            'options'     => ['letter' => 'S-M-L-XL', 'number' => '30-32-34'],
        ]);
        $this->crud->addField([
            'name' => 'details',
            'label' => 'Product Details',
            'type' => 'repeatable',
            'fields' => [
                [
                    // 1-n relationship
                    'label'       => "Size", // Table column heading
                    'type'        => "select2_from_ajax",
                    'name'        => 'size', // the column that contains the ID of that connected entity
                    //'entity'      => 'size', // the method that defines the relationship in your Model
                    //'attribute'   => "name", // foreign key attribute that is shown to user
                    'data_source' => url("size/selected"), // url to controller search function (with /{id} should return model)

                    // OPTIONAL
                    // 'placeholder'             => "Select a category", // placeholder for the select
                    // 'minimum_input_length'    => 2, // minimum characters to type before querying results
                    // 'model'                   => "App\Models\Category", // foreign key model
                    'dependencies'            => ['size_type'], // when a dependency changes, this select2 is reset to null
                    'method'                  => 'GET', // optional - HTTP method to use for the AJAX call (GET, POST)
                    //'include_all_form_fields' => false, // optional - only send the current field through AJAX (for a smaller payload if you're not using multiple chained select2s)
                ],
                [
                    'name' => 'answer',
                    'label' => 'Answer',
                    'type' => 'textarea',
                    'wrapperAttributes' => [
                        'class' => 'form-group col-md-6'
                    ],
                ],
            ],
        ]);
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }

    protected function setupShowOperation()
    {
        $this->crud->set('show.setFromDb', false);
        //$this->crud->removeColumns(['category_id', 'brand_id', 'mrp', 'sale_price', 'images']);
        $this->crud->addColumn('description');
        $this->crud->addColumns([
            [  // Select
                'label' => "Category",
                'type' => 'text',
                'name' => 'category.name', // the db column for the foreign key
            ],
            [  // Select
                'label' => "Brand",
                'type' => 'text',
                'name' => 'brand.name', // the db column for the foreign key
            ],
            [
                'label' => "MRP",
                'type' => 'model_function',
                'name' => 'mrp',
                'function_name' => 'getFormattedAmount',
                'function_parameters' => ['mrp'],
            ],
            [
                'label' => "Sale Price",
                'type' => 'model_function',
                'name' => 'sale_price',
                'function_name' => 'getFormattedAmount',
                'function_parameters' => ['sale_price'],
            ],
            [
                'name'      => 'images', // The db column name
                'label'     => 'Images', // Table column heading
                'type'      => 'upload_multiple',
                'disk'      => 'public',
                // 'prefix' => 'folder/subfolder/',
                // image from a different disk (like s3 bucket)
                // 'disk'   => 'disk-name',
                // optional width/height if 25px is not ok with you
                // 'height' => '30px',
                // 'width'  => '30px',
            ],
        ]);
        $this->crud->addColumn('description');
    }
}