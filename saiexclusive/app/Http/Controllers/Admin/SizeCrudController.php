<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\SizeRequest;
use App\Models\Size;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Http\Request;

/**
 * Class SizeCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class SizeCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        $this->crud->setModel('App\Models\Size');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/size');
        $this->crud->setEntityNameStrings('size', 'sizes');
    }

    protected function setupListOperation()
    {
        // TODO: remove setFromDb() and manually define Columns, maybe Filters
        $this->crud->setFromDb();
        $this->crud->removeColumns(['type']);
        $this->crud->addColumn([
            'label' => 'Type',
            'type' => 'model_function',
            'name' => 'type',
            'function_name' => 'getTypeDisplayText',
        ]);
    }

    protected function setupCreateOperation()
    {
        $this->crud->setValidation(SizeRequest::class);

        // TODO: remove setFromDb() and manually define Fields
        $this->crud->setFromDb();
        $this->crud->removeField('type');
        $this->crud->addField([   // select_from_array
            'name'        => 'type',
            'label'       => "Type",
            'type'        => 'select_from_array',
            'options'     => ['letter' => 'S-M-L-XL', 'number' => '30-32-34'],
            'allows_null' => false,
            'default'     => 'letter',
            // 'allows_multiple' => true, // OPTIONAL; needs you to cast this to array in your model;
        ]);
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }

    public function getSelectedSize(Request $request)
    {
        $search_term = $request->input('q');
        $form = collect($request->input('form'))->pluck('value', 'name');

        $options = Size::query();

        // if no category has been selected, show no options
        if (!$form['size_type']) {
            return [];
        }

        // if a category has been selected, only show articles in that category
        if ($form['size_type']) {
            $options = $options->where('type', $form['size_type']);
        }

        if ($search_term) {
            $results = $options->where('name', 'LIKE', '%' . $search_term . '%')->paginate(10);
        } else {
            $results = $options->paginate(10);
        }

        return $options->paginate(10);
    }
}