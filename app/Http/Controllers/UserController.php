<?php
 namespace App\Http\Controllers;
 use App\Models\User;
 use App\Http\Requests\StoreUserRequest;
 use App\Http\Requests\UpdateUserRequest;
 use Illuminate\View\View;
 use Illuminate\Http\RedirectResponse;
 use Spatie\Permission\Models\Role;
 use Illuminate\Support\Facades\Hash;
 class UserController extends Controller
 {
 public function __construct()
 {
 $this->middleware('auth');
 $this->middleware('permission:create-user|edit-user|delete-user', ['only' => ['index','show']]);
 $this->middleware('permission:create-user', ['only' => ['create','store']]);
 $this->middleware('permission:edit-user', ['only' => ['edit','update']]);
 $this->middleware('permission:delete-user', ['only' => ['destroy']]);
 }
 public function index(): View
 {
 return view('users.index', [
 'users' => User::latest('id')->paginate(3)
 ]);
 }
 /**
 *Showtheformforcreatinganewresource.
 */
 public function create(): View
 {
 return view('users.create', [
 'roles' => Role::pluck('name')->all()
 ]);

}
/**
*Storeanewlycreatedresourceinstorage.
*/
public function store(StoreUserRequest $request): RedirectResponse
{
$input = $request->all();
$input['password'] = Hash::make($request->password);
$user = User::create($input);
$user->assignRole($request->roles);
return redirect()->route('users.index')->withSuccess('New user is added successfully.');
}
/**
*Displaythespecifiedresource.
*/
public function show(User $user): View
{
return view('users.show', [
'user' => $user
]);
}
/**
*Showtheformforeditingthespecifiedresource.
*/
public function edit(User $user): View
{
//CheckOnlySuperAdmincanupdatehisownProfile
if ($user->hasRole('Super Admin')){
if($user->id != auth()->user()->id){
abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSIONS');
}
}
return view('users.edit', [
'user' => $user,
'roles' => Role::pluck('name')->all(),
'userRoles' => $user->roles->pluck('name')->all()
]);
}
/**
*Updatethespecifiedresourceinstorage.
*/
public function update(UpdateUserRequest $request, User $user): RedirectResponse
{
$input = $request->all();
if(!empty($request->password)){
$input['password'] = Hash::make($request->password);
}else{
$input = $request->except('password');
}
$user->update($input);
$user->syncRoles($request->roles);
return redirect()->back()->withSuccess('User is updated successfully.');
}
/**
*Removethespecifiedresourcefromstorage.
*/
public function destroy(User $user): RedirectResponse
{
//AboutifuserisSuperAdminorUserIDbelongstoAuthUser
if ($user->hasRole('Super Admin') || $user->id == auth()->user()->id)
{
abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSIONS');
}
$user->syncRoles([]);
$user->delete();
return redirect()->route('users.index')->withSuccess('User is deleted successfully.');
}
}