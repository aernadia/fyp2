<?php

namespace App\Http\Controllers;

use App\User;
use App\Post;
use App\Role;
use App\Documents;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class PostsController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * INDEXES
     */
    public function index()
    {

        $sv = User::all();
        $stu1 = User::all();
        

        if(!\Auth::user()->hasRole('admin') && !\Auth::user()->hasRole('lecturer') ){
            $posts = Post::where('userId', \Auth::user()->id)->orderBy('id', 'desc')
            ->get();
            
        }else{
            $posts = Post::orderBy('id', 'desc')->get();
        }
   
       
        $quota = \Auth::user()->quota;
      

        return view('admin.posts.index', ['posts' => $posts, 'svu' => $sv, 'stu1' => $stu1, 'quota' => $quota]);
    }

    public function indexSv()
    {
            $postpublished = Post::all();
            $usu = User::orderBy('id', 'desc')
            ->when(auth()->user()->hasRole('supervisor'), function($query, $role) 
                {
                    $query->whereHas('roles', function($query) 
                        {
                            $query->where('slug', 'user');
                        }
                    );
                }
            )
            ->get();
            
            // dd($usu);
        
            $quota = \Auth::user()->quota;
            $maxquota = \Auth::user()->maxquota;

            if($quota == $maxquota){
                $svPost = Post::where(['svId' => \Auth::user()->id , 'published' => '1'])->orderBy('id', 'desc')
                ->get();
            }else{
                // nak post yg sv tu punya
                // nak post yg userId ->quota =/ 1
                $svPost = Post::where('svId', \Auth::user()->id)->orderBy('id', 'desc')
                ->get();
                // $svA = Post::where('userId', );
                // dd($svA);

            }
            // dd($svPost);
        return view('admin.posts.indexSv', ['svPosts' => $svPost, 'quota' => $quota, 'maxquota' => $maxquota, 'postpublished' => $postpublished]);
    }

    public function supervisee()
    {
        
            // $quota = \Auth::user()->quota;
            // $maxquota = \Auth::user()->maxquota;

            // if($quota == $maxquota){
                $svee = Post::where(['svId' => \Auth::user()->id , 'published' => '1'])->orderBy('id', 'desc')
                ->get();
            // }else{
            //     $svPost = Post::where('svId', \Auth::user()->id)->orderBy('id', 'desc')
            //     ->get();
            // }
            // dd($svPost);
        return view('admin.posts.supervisee', ['svEe' => $svee]);
    }

    public function indexAd()
    {

        if(!\Auth::user()->hasRole('admin') ){
            $adlist = Post::where('userId', \Auth::user()->id)->orderBy('id', 'desc')
            ->get();
            
        }else{
            $adlist = Post::orderBy('id', 'desc')->get();
        }
        $quota = auth()->user()->quota;
        // dd(Post::document());
        return view('admin.posts.indexAd', ['adlists' => $adlist, 'quota' => $quota ]);
    }
    

    /**
     * CREATE
     */
    public function create()
    {
        $this->authorize('create', Post::class);
        $svId = $_GET['svId'];
        //dd($svId);

        //call the view admin.posts.create 
        return view('admin.posts.create',['svId' => $svId] );
    }

     /**
     * STORE
     */
    public function store(Request $request)
    {
        
        //validate the field
        $data = request()->validate([
            'title' => 'required|max:255',
            'studId' => 'required',
            'post_content' => 'required',
            'date' => 'required|date_format:Y-m-d'

        ]);

        $doc=new Documents;
        if($request->file('file')){
            $file=$request->file;
            $filename=time().'.'.$file->getClientOriginalExtension();
            $request->file->move('storage/', $filename);
 
            $doc->file=$filename;

        }
    
        $doc->save();
        $file = $doc->id;


        $user = auth()->user();
        $post = new Post();

        $post->title = request('title');
        $post->content = request('post_content');
        $post->studId = request('studId');
        $post->file = $file;
        $post->userId = $user->id;
        $post->svId = request('svId');
        $post->date = request('date');
        $post->save();
        // dd($request->all());
        return redirect('/posts')->with('success', 'Post Created Successfully!');
    }

     /**
     * SHOW LISTS
     */
    public function show(Post $post)
    {
        return view('admin.posts.show', ['post'=>$post]);
    }

    /**
     * EDIT LISTS
     */
    public function edit(Post $post)
    {
        $this->authorize('edit', $post);

        
        $post = Post::find($post->id);
        

        // return view
        return view('admin/posts/edit', ['post' => $post]);
        
    }

    /**
     * UPDATE LISTS
     */
    public function update(Request $request, Post $post)
    {
       
        $userId = $post->userId;
        // dd($userId);
        $posts = Post::where('id', $request->id)->get();
        $student = User::where('id', $userId)->first();
        $changes = $request->published;
        $current = $post->published;

        $user = \Auth::user();

        if ($current == 0){
            if($changes == 1)
            {  
                $user->quota = $user->quota + 1;
                $student->quota = 1;
                $user->save();
                $student->save();
            }
        }elseif($current == 1){
            if($changes == 0 || $changes == 2 ){
                $user->quota = $user->quota - 1 ; 
                $student->quota = 0;
                $student->save();
                $user->save();
            }
        }elseif($current == 2){
            if($changes == 1){
                $user->quota = $user->quota + 1;
                $student->quota = 1;
                $student->save();
                $user->save();
            }
            if($changes == 0){
                $student->quota = 0;
                $student->save();
            }
        }
        else{
            echo "You have reached the limit";
        }
        $post->published = $request->published;
        $post->save();
     

        return redirect('/posts/indexSv');
    }

    /**
     * DELETE LISTS
     */
    public function destroy(Post $post, Request $request)
    {
        
        //find the post
        $post = Post::find($request->post_id);
        
        $this->authorize('delete', $post);

        //delete the post
        $post->delete();

        //redirect to posts
        return redirect('/posts/indexSv');
    }


    /**
     * SHOW FILE
     */
    public function showUpload($id)
    {
        $data=Documents::find($id);
        return view('admin.document.details',compact('data'));
    }

    /**
     * DOWNLOAD FILE
     */
    public function download(Post $post)
    {
       return response()->download($file);
    }

    public function dashboardA()
    {  
           
        $svCount = User::orderBy('id', 'desc')
            ->when(auth()->user()->hasRole('admin'), function($query, $role) {
                $query->whereHas('roles', function($query) {
                    $query->where(['slug' => 'supervisor']);
                });
            })
            ->count ();

        $userCount = User::orderBy('id', 'desc')
            ->when(auth()->user()->hasRole('admin'), function($query, $role) {
                $query->whereHas('roles', function($query) {
                    $query->where('slug', 'user');
                });
            })
            ->count ();
        $lectCount = User::orderBy('id', 'desc')
            ->when(auth()->user()->hasRole('admin'), function($query, $role) {
                $query->whereHas('roles', function($query) {
                    $query->where('slug', 'lecturer');
                });
            })
            ->count ();
        $adCount = User::orderBy('id', 'desc')
            ->when(auth()->user()->hasRole('admin'), function($query, $role) {
                $query->whereHas('roles', function($query) {
                    $query->where('slug', 'admin');
                });
            })
            ->count (); 
         $no = Post::orderBy('id', 'desc')->count();
         $n1 = Post::orderBy('id', 'desc')->where('published', '0')->count();
         $n2 = Post::orderBy('id', 'desc')->where('published', '2')->count();
         $n3 = Post::orderBy('id', 'desc')->where('published', '1')->count();
        // dd($svCount);
        return view('admin.posts.dashboardA', ['svc' => $svCount, 'usc' => $userCount,
         'lcs' => $lectCount, 'ads' => $adCount, 'no' => $no, 'n1' => $n1, 'n2' => $n2, 'n3' => $n3]);
    }

    public function dashboardB()
    {
       

         $sc = User::orderBy('id', 'desc')
            ->when(auth()->user()->hasRole('lecturer'), function($query, $role) {
                $query->whereHas('roles', function($query) {
                    $query->where(['slug' => 'supervisor']);
                });
            })
            ->count ();

        $uc = User::orderBy('id', 'desc')
            ->when(auth()->user()->hasRole('lecturer'), function($query, $role) {
                $query->whereHas('roles', function($query) {
                    $query->where('slug', 'user');
                });
            })
            ->count (); 
        $u1 = User::orderBy('id', 'desc')
            ->when(auth()->user()->hasRole('lecturer'), function($query, $role) {
                $query->whereHas('roles', function($query) {
                    $query->where('slug', 'user')->where('quota', '1');
                });
            })
            ->count();
        $u2 = User::orderBy('id', 'desc')
            ->when(auth()->user()->hasRole('lecturer'), function($query, $role) {
                $query->whereHas('roles', function($query) {
                    $query->where('slug', 'supervisor');
                });
             })
            ->whereColumn('quota', 'maxquota')
            ->count();
        $full = Post::orderBy('id', 'desc')->count();
        $pen = Post::orderBy('id', 'desc')->where('published', '0')->count();
        $rej = Post::orderBy('id', 'desc')->where('published', '2')->count();
        $app = Post::orderBy('id', 'desc')->where('published', '1')->count();
        // dd($u2);
        return view('admin.posts.dashboardB', ['sc' => $sc, 'uc' => $uc, 'u1' => $u1, 'u2' => $u2,
        'full' => $full, 'pen' => $pen, 'rej' => $rej, 'app' => $app]);
    }

    public function dashboardSV()
    {
       

        $sc  = Post::orderBy('id', 'desc')->where('svId', \Auth::user()->id)->count();
        
        $uc = Post::where(['svId' => \Auth::user()->id , 'published' => '1'])->orderBy('id', 'desc')
        ->count(); 

        $u1 = User::orderBy('id', 'desc')
            ->when(auth()->user()->hasRole('supervisor'), function($query, $role) {
                $query->whereHas('roles', function($query) {
                    $query->where('slug', 'user')->where('quota', '1');
                });
            })
            ->count();
        $u2 = User::orderBy('id', 'desc')
            ->when(auth()->user()->hasRole('supervisor'), function($query, $role) {
                $query->whereHas('roles', function($query) {
                    $query->where('slug', 'supervisor');
                });
             })
            ->whereColumn('quota', 'maxquota')
            ->count();
        $full = Post::orderBy('id', 'desc')->count();
        $pen = Post::orderBy('id', 'desc')->where('published', '0')->count();
        $rej = Post::orderBy('id', 'desc')->where('published', '2')->count();
        $app = Post::orderBy('id', 'desc')->where('published', '1')->count();
        // dd($uc);
        return view('admin.posts.dashboardSV', ['sc' => $sc, 'uc' => $uc, 'u1' => $u1, 
        'full' => $full, 'pen' => $pen, 'rej' => $rej, 'app' => $app]);
    }
}
