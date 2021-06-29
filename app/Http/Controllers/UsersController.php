<?php

namespace App\Http\Controllers;

use App\User;
use App\Role;
use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;


class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::orderBy('id', 'desc')
            ->when(auth()->user()->hasRole('user'), function($query, $role) {
                $query->whereHas('roles', function($query) {
                    // $query->where('slug', 'supervisor');
                });
            })
            ->get();

        return view('admin.users.index', ['users' => $users]);

        // $data = DB ::table('users')
        // ->join('users_roles','users.id','users_roles.user_id')
        // ->get();
        // echo "<pre>";
        // print_r($data);
        
    }
    public function indexStud()
    {
        $sv = User::orderBy('id', 'desc')
            ->when(auth()->user()->hasRole('user'), function($query, $role) {
                $query->whereHas('roles', function($query) {
                    $query->where('slug', 'supervisor');
                });
            })
            ->get();
            // dd($sv);
        return view('admin.users.indexStud', ['svs' => $sv]);

        
        
    }
    public function dashboardS()
    {
        $quota = \Auth::user()->quota;
        $maxquota = \Auth::user()->maxquota;

        $svS = User::orderBy('id', 'desc')
            ->when(auth()->user()->hasRole('user'), function($query, $role) {
                $query->whereHas('roles', function($query) {
                    $query->where(['slug' => 'supervisor']);
                });
            })
            ->count();
        $svF = User::orderBy('id', 'desc')
            ->when(auth()->user()->hasRole('user'), function($query, $role) {
                $query->whereHas('roles', function($query) {
                    $query->where('slug', 'supervisor');
                });
            })
            ->whereColumn('quota', 'maxquota')
            ->count();
        $totalA = $svS - $svF;
        $ps = Post::where('userId', \Auth::user()->id)->orderBy('id', 'desc')
        ->count();
        $acc = Post::where('userId', \Auth::user()->id)->orderBy('id', 'desc')->where('published', '1')
        ->count();
        // $svF = $svF->quota;
        // dd($svF);
        return view('admin.users.dashboardS', ['svS' => $svS, 'svF' => $svF, 'ps' => $ps, 'acc' => $acc, 'totalA' => $totalA]);

        
        
    }
    public function indexLect()
    {
        $lc = User::orderBy('id', 'desc')
            ->when(auth()->user()->hasRole('lecturer'), function($query, $role) 
                {
                    $query->whereHas('roles', function($query) 
                        {
                            $query->where('slug', 'supervisor');
                        }
                    );
                }
            )
            ->get();
            // dd($lc);
        return view('admin.users.indexLect', ['lcl' => $lc]);   
    }
    public function indexLectStud()
    {
        $st = User::orderBy('id', 'desc')
            ->when(auth()->user()->hasRole('lecturer'), function($query, $role) 
                {
                    $query->whereHas('roles', function($query) 
                        {
                            $query->where('slug', 'user');
                        }
                    );
                }
            )
            ->get();
        
        $stuID = Post::all();
        
        // dd($stuID->where('id', 3)->pluck('studId')[0]);
        // $stuID = \Auth::post()->studId;
      
        return view('admin.users.indexLectStud', ['stl' => $st], compact('stuID') );   
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if($request->ajax()){
            $roles = Role::where('id', $request->role_id)->first();
            $permissions = $roles->permissions;

            return $permissions;
        }

        $roles = Role::all();
        
        return view('admin.users.create', ['roles' => $roles]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //validate the fields
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|unique:users|email|max:255',
            'password' => 'required|between:8,255|confirmed',
            'password_confirmation' => 'required'
        ]);
        
        

        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();

        if($request->role != null){
            $user->roles()->attach($request->role);
            $user->save();
        }

        if($request->permissions != null){            
            foreach ($request->permissions as $permission) {
                $user->permissions()->attach($permission);
                $user->save();
            }
        }

        return redirect('/users');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('admin.users.show', ['user'=>$user]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $roles = Role::get();
        $userRole = $user->roles->first();
        if($userRole != null){
            $rolePermissions = $userRole->allRolePermissions;
        }else{
            $rolePermissions = null;
        }
        $userPermissions = $user->permissions;

        // dd($rolePermission);

        return view('admin.users.edit', [
            'user'=>$user,
            'roles'=>$roles,
            'userRole'=>$userRole,
            'rolePermissions'=>$rolePermissions,
            'userPermissions'=>$userPermissions
            ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {

        //validate the fields
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|max:255',
            'password' => 'confirmed',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        if($request->password != null){
            $user->password = Hash::make($request->password);
        }
        $user->save();

        $user->roles()->detach();
        $user->permissions()->detach();

        if($request->role != null){
            $user->roles()->attach($request->role);
            $user->save();
        }

        if($request->permissions != null){            
            foreach ($request->permissions as $permission) {
                $user->permissions()->attach($permission);
                $user->save();
            }
        }

        return redirect('/users');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->roles()->detach();
        $user->permissions()->detach();
        $user->delete();

        return redirect('/users');
    }
    public function dropdown(Request $request, User $user)
    {
        // $quotas = $user->maxquota;
        // dd($user);
        // return view('admin.users.dropdown', compact('user'));
        // $maxquota= $_GET['maxquota'];
        // dd($maxquota);
        // $maxquota = User::find($user->id);

        //call the view admin.posts.create 
        return view('admin/users/dropdown', compact('user') );
    }

    public function updatedropdown(Request $request, User $user)
    {
    
        // $request->validate([
        //     'maxquota' => 'confirmed',
        // ]);

        // $quotas = User::where('id', $request->id)->get();
        $user->maxquota = $request->maxquota;
        $user->save();
        // dd($user);

        // $user->maxquota = $request->maxquota;
        // if($request->maxquota != null){
        //     $user->maxquota= Hash::make($request->maxquota);
        // }
        // $user->save();
    
       return redirect('/users/indexLect');
    }
}
