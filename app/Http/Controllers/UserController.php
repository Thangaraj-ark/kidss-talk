<?php

namespace App\Http\Controllers;

use App\DataTables\UserDataTable;
use App\Models\User;
use Illuminate\Http\Request;

use App\Traits\RestResource;

class UserController extends Controller
{
    use RestResource;

    protected $datatableClass = UserDataTable::class;

    protected $index = 'users.index';

    protected $create = 'users.create';

    protected $edit = 'users.edit';

    //protected $show = 'users.show';

    protected $modelClass = User::class;
    //protected $modelIndexRoute = 'users.index';

    // protected function _validate(Request $request)
    // {
    //     $validatedData = $request->validate([
    //         'name' => 'required',
    //         'status' => 'required',
    //     ], [
    //         'name.required' => 'Name is required',
    //         'status.required' => 'status is required',
    //     ]);

    //     return $validatedData;

    // }

}