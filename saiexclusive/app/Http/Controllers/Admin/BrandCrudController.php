<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\BrandRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class BrandCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class BrandCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        $this->crud->setModel('App\Models\Brand');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/brand');
        $this->crud->setEntityNameStrings('brand', 'brands');
    }

    protected function setupListOperation()
    {
        // TODO: remove setFromDb() and manually define Columns, maybe Filters
        $this->crud->setFromDb();
        $this->crud->removeColumns(['image']);
        $this->crud->addColumn(
            [
                'name'      => 'image', // The db column name
                'label'     => 'Brand image', // Table column heading
                'type'      => 'image',
                // 'prefix' => 'folder/subfolder/',
                // image from a different disk (like s3 bucket)
                'disk'   => 'public',
                // optional width/height if 25px is not ok with you
                'height' => '80px',
                'width'  => '80px',
            ]
        );
    }

    protected function setupCreateOperation()
    {
        $this->crud->setValidation(BrandRequest::class);

        // TODO: remove setFromDb() and manually define Fields
        $this->crud->setFromDb();
        $this->crud->removeFields(['image']);
        $this->crud->addField(
            [   // Upload
                'name'      => 'image',
                'label'     => 'Image',
                'type'      => 'upload',
                'upload'    => true,
                'disk'      => 'public', // if you store files in the /public folder, please ommit this; if you store them in /storage or S3, please specify it;
                // optional:
                //'temporary' => 10 // if using a service, such as S3, that requires you to make temporary URL's this will make a URL that is valid for the number of minutes specified
            ],
        );
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}