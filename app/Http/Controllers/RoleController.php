<?php
 namespace App\Http\Controllers;
 use App\Http\Requests\StoreRoleRequest;
 use App\Http\Requests\UpdateRoleRequest;
 use Spatie\Permission\Models\Role;
 use Spatie\Permission\Models\Permission;
 use Illuminate\View\View;
 use Illuminate\Http\RedirectResponse;
 use DB;
 class RoleController extends Controller
 {
 public function __construct()
 {
 $this->middleware('auth');
 $this->middleware('permission:create-role|edit-role|delete-role', ['only' => ['index','show']]);
 $this->middleware('permission:create-role', ['only' => ['create','store']]);
 $this->middleware('permission:edit-role', ['only' => ['edit','update']]);
 $this->middleware('permission:delete-role', ['only' => ['destroy']]);
 }
 /**
 *Displayalistingoftheresource.
 */
 public function index(): View
 {
 return view('roles.index', [
 'roles' => Role::orderBy('id','DESC')->paginate(3)
 ]);
 }
 /**
 *Showtheformforcreatinganewresource.
 */
 public function create(): View
 {
 return view('roles.create', [
 'permissions' => Permission::get()
 ]);
 }
 /**
 *Storeanewlycreatedresourceinstorage.
 */
 public function store(StoreRoleRequest $request): RedirectResponse
 {
 $role = Role::create(['name' => $request->name]);
 $permissions = Permission::whereIn('id', $request->permissions)->get(['name'])->toArray();
 $role->syncPermissions($permissions);
 return redirect()->route('roles.index')->withSuccess('New role is added successfully.');
 }
 /**
 *Displaythespecifiedresource.
 */
 public function show(Role $role): View
 {
 $rolePermissions = Permission::join("role_has_permissions","permission_id","=","id")->where("role_id",$role->id)->select('name')->get();
 return view('roles.show', [
 'role' => $role,
 'rolePermissions' => $rolePermissions
 ]);
 }
 /**
 *Showtheformforeditingthespecifiedresource.
 */
 public function edit(Role $role): View
 {
 if($role->name=='Super Admin'){
 abort(403, 'SUPER ADMIN ROLE CAN NOT BE EDITED');
 }
 $rolePermissions = DB::table("role_has_permissions")->where("role_id",$role->id)->pluck('permission_id')

 ->all();
 return view('roles.edit', [
 'role' => $role,
 'permissions' => Permission::get(),
 'rolePermissions' => $rolePermissions
 ]);
 }
 /**
 *Updatethespecifiedresourceinstorage.
 */
 public function update(UpdateRoleRequest $request, Role $role): RedirectResponse
 {
 $input = $request->only('name');
 $role->update($input);
 $permissions = Permission::whereIn('id', $request->permissions)->get(['name'])->toArray();
 $role->syncPermissions($permissions);
 return redirect()->back()->withSuccess('Role is updated successfully.');
 }
 /**
 *Removethespecifiedresourcefromstorage.
 */
 public function destroy(Role $role): RedirectResponse
 {
 if($role->name=='Super Admin'){
 abort(403, 'SUPER ADMIN ROLE CAN NOT BE DELETED');
 }
 if(auth()->user()->hasRole($role->name)){
 abort(403, 'CAN NOT DELETE SELF ASSIGNED ROLE');
 }
 $role->delete();
 return redirect()->route('roles.index')->withSuccess('Role is deleted successfully.');
 }
 }