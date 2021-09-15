<?php

namespace App\Http\Controllers\Admin;

//use App\Blacklist;
//use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Permission;
use App\Services\PermissionService;
//use App\Services\RoleRightService;

class PermissionController extends Controller
{

    private $permissionService;
    public function __construct(
        PermissionService $permissionService//,
        //RoleRightService $roleRightService
    ) {

        $this->permissionService = $permissionService;
        //$this->roleRightService = $roleRightService;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // $rolesPermissions = $this->roleRightService->hasPermissions("Permissions Maintenance");

        // if (!$rolesPermissions['view']) {
        //     abort(401);
        // }

        // $create = $rolesPermissions['create'];
        // $edit = $rolesPermissions['edit'];

        $modules = $this->permissionService->getModule();
        $permissions = Permission::orderBy('module_type', 'asc')->orderBy('description', 'asc')->get();
        //$permissions = Permission::all();

        return view('admin.permissions', compact(
            'permissions',
            'modules'
            //'create',
            //'edit',
        ));
    }

    public function store(Request $request)
    {

        $request->validate([
            'module_type' => 'required',
            'description' => 'required',
        ]);

        $status = $request->has('active');

        $permission = new Permission([
            'module_type' => $request->get('module_type'),
            'description' => $request->get('description'),
            'active' => $status
        ]);

        $permission->save();

        return back();
    }

    public function search(Request $request)
    {

        $rolesPermissions = $this->roleRightService->hasPermissions("Permissions Maintenance");     
        if (!$rolesPermissions['view']) {
            abort(401);
        }

        $create = $rolesPermissions['create'];
        $edit = $rolesPermissions['edit'];

        $modules = $this->permissionService->getModule();        
        $q = $request->get('q');

        $permissions = Permission::where('description', 'LIKE', '%' . $q . '%')
            ->orWhere('id', 'LIKE', '%' . $q . '%')
            ->select('*')
            ->paginate(15)->setPath('');

        $permissions->appends(array(
            'q' => $request->get('q')
        ));

        return view('admin.permissions', compact(
            'permissions',
            'modules',
            'create',
            'edit'
        ));
    }
    public function edit(Request $request)
    {
        return response()->json($this->permissionService->getById($request->id));
    }
    public function update(Request $request)
    {
        return $this->permissionService->update($request);
    }

    public function destroy(Request $request, $id)
    {
        return $this->permissionService->destroy($request, $id);
    }
}
