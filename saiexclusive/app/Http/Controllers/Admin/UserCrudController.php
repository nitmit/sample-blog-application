<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Role;
use App\User as AppUser;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Http\Request;

/**
 * Class UserCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class UserCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation {
        update as traitUpdate;
    }
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        $this->crud->setModel('App\Models\User');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/user');
        $this->crud->setEntityNameStrings('user', 'users');
    }

    protected function setupListOperation()
    {
        // TODO: remove setFromDb() and manually define Columns, maybe Filters
        $this->crud->setFromDb();
        $this->crud->addColumn([
            // 1-n relationship
            'label' => "Role", // Table column heading
            'type' => "select",
            'name' => 'role_id', // the column that contains the ID of that connected entity;
            'entity' => 'roles', // the method that defines the relationship in your Model
            'attribute' => "display_name", // foreign key attribute that is shown to user
            'model' => "App\Role", // foreign key model
        ]);
    }

    protected function setupCreateOperation()
    {
        $this->crud->setValidation(UserRequest::class);

        // TODO: remove setFromDb() and manually define Fields
        $this->crud->setFromDb();
        $this->crud->addFields([[
            'label'     => "Role",
            'type'      => 'select2',
            'model'     => "App\Role", // foreign key model
            'name'      => 'role_id', // the db column for the foreign key
            'entity'    => 'roles', // the method that defines the relationship in your Model
            'attribute' => 'display_name', // foreign key attribute that is shown to user

            // optional

            'options'   => (function ($query) {
                return $query->orderBy('name', 'ASC')->get();
            }),
            'wrapperAttributes' => [
                'class' => 'form-group col-md-6'
            ],
        ],]);
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
        $this->crud->removeField('role_id');
    }

    public function store()
    {
        $request = $this->crud->validateRequest();

        // insert item in the db
        // $item = $this->crud->create($this->crud->getStrippedSaveRequest());
        //$this->crud->setRequest($this->handlePasswordInput($this->crud->getRequest()));
        $saveReq = $this->crud->getStrippedSaveRequest();

        // foreach (json_decode($saveReq['details']) as $detail) {
        $user = new AppUser();
        $user->name = $saveReq['name'];
        $user->email = $saveReq['email'];
        $user->password = \Hash::make($saveReq['password']);
        $user->mobile = $saveReq['mobile'];
        $user->save();
        //}
        $role = Role::where('id', $saveReq['role_id'])->first();
        $user->attachRole($role);

        //$item = User::find($user->id)->first();

        $this->data['entry'] = $this->crud->entry = $user;

        // show a success message
        \Alert::success(trans('backpack::crud.insert_success'))->flash();

        // save the redirect choice for next time
        $this->crud->setSaveAction();

        return $this->crud->performSaveAction($user->id);
    }

    public function update()
    {
        $this->crud->setRequest($this->crud->validateRequest());
        $this->crud->setRequest($this->handlePasswordInput($this->crud->getRequest()));
        $this->crud->unsetValidation(); // validation has already been run

        return $this->traitUpdate();
    }

    protected function handlePasswordInput($request)
    {
        // Remove fields not present on the user.
        $request->request->remove('password_confirmation');
        $request->request->remove('roles_show');
        $request->request->remove('permissions_show');

        // Encrypt password if specified.
        if ($request->input('password')) {
            $request->request->set('password', \Hash::make($request->input('password')));
        } else {
            $request->request->remove('password');
        }

        return $request;
    }
}