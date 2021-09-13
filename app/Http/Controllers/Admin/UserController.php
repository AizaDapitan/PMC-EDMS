<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\UserService;
// use App\Services\RoleRightService;
use Notification;
use App\User;
use App\Role;
use App\Notifications\EmailNotification;

class UserController extends Controller
{
    private $userService;
    private $roleRightService;

    public function __construct(
        UserService $userService
        // RoleRightService $roleRightService
    ) {
        $this->userService = $userService;
        // $this->roleRightService = $roleRightService;
    }

    public function index()
    {
        // $rolesPermissions = $this->roleRightService->hasPermissions("User Maintenance");

        // $view = $rolesPermissions['view'];
        // if (!$view) {
        //     abort(401);
        // }
        $roles = Role::where('active', '1')->get();
        $users = User::all();
        // $create = $rolesPermissions['create'];
        // $edit = $rolesPermissions['edit'];
        // $activateDeactivate = $rolesPermissions['activateDeactivate'];
        // $delete = $rolesPermissions['delete'];

        return view('admin.users', compact(
            'roles',
            'users',
            // 'create',
            // 'edit',
            // 'activateDeactivate',
            // 'delete'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required|email',
            'username' => 'required',   
            'role_id' => 'required',
        ]);

        $user = User::where('username', $request->username)->first();
        if ($user) 
        {
            $request->session()->flash('errorMesssage', '<strong>Username!</strong> already exists.');                        
            return redirect()->back();
        }
        else
        {
            $userEmail = User::where('email', $request->email)->first();
            if ($userEmail) 
            {
                $request->session()->flash('errorMesssage', '<strong>Email!</strong> already exists.');                        
                return redirect()->back();
            }            
            else
            {
                $result = $this->userService->create($request);
                $user = User::orderBy('id','desc')->first();
                if ($request->session()->get('success') == "User has been added successfully!") 
                {
                    $user->notify(new EmailNotification($user));
                }
                return $result;
            }
        }
    }
    public function edit(Request $request)
    {
        return response()->json($this->userService->getById($request->id));
    }

    public function update(Request $request)    
    {
        return $this->userService->update($request);
    }               
    public function lock(Request $request, $id)
    {
        return $this->userService->lock($request, $id);
    }

    public function changeStatus(Request $request, $id)
    {
        return $this->userService->changeStatus($request, $id);
    }

    public function destroy($id)
    {
        return $this->userService->destroy($id);
    }

    public function logs(Request $request)
    {
        return view('admin.users.logs', [
            'actions' => $this->userService->getUserActions($request),
            'users' => $this->userService->all(),
        ]);
    }
}
