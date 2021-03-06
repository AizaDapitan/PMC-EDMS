<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Role;
use App\Services\RoleService;
use App\Services\RoleRightService;

class RoleController extends Controller
{
    private $roleService;

    public function __construct(
        RoleService $roleService,
        RoleRightService $roleRightService
    ) {

        $this->roleService = $roleService;
        $this->roleRightService = $roleRightService;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        //$role = auth()->user()->role;
        $rolesPermissions = $this->roleRightService->hasPermissions("Roles Maintenance");

        if (!$rolesPermissions['view']) {
           abort(401);
        }

        $create = $rolesPermissions['create'];
        $edit = $rolesPermissions['edit'];

        //$roles = Role::paginate(15);
        $roles = Role::all();
        return view('admin.roles', compact(
            'roles',
            'create',
            'edit'
        ));
    }

    public function store(Request $request)
    {

        $request->validate([
            'role' => 'required',
            'description' => 'required',
        ]);

        $role = Role::where('name', $request->role)->first();

        if ($role) 
        {
            $request->session()->flash('errorMesssage', '<strong>Role Name!</strong> already exists.');                        
            return redirect()->back();
        }
        else
        {
            $status = $request->has('active');

            $role = new Role([
                'name' => $request->get('role'),
                'description' => $request->get('description'),
                'active' => $status
            ]);
    
            $role->save();
    
            return back();
        }
    }

    public function search(Request $request)
    {

        //$rolesPermissions = $this->roleRightService->hasPermissions("Roles Maintenance");
        //if (!$rolesPermissions['view']) {
        //    abort(401);
        //}

        //$create = $rolesPermissions['create'];
        //$edit = $rolesPermissions['edit'];


        $q = $request->get('q');

        $roles = Role::where('name', 'LIKE', '%' . $q . '%')
            ->orWhere('id', 'LIKE', '%' . $q . '%')
            ->select('*')
            ->paginate(15)->setPath('');

        $roles->appends(array(
            'q' => $request->get('q')
        ));

        //$rolesPermissions = $this->roleRightService->hasPermissions("Roles Maintenance");

        //if (!$rolesPermissions['view']) {
        //    abort(401);
        //}

        //$create = $rolesPermissions['create'];
        //$edit = $rolesPermissions['edit'];

        return view('admin.roles', compact(
            'roles'
            //'create',
            //'edit'
        ));
    }

    public function edit(Request $request)
    {
        return response()->json($this->roleService->getById($request->id));
    }

    public function update(Request $request)
    {
        return $this->roleService->update($request);
    }
}
