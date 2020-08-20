<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Routing\UrlGenerator;
use App\Http\Requests;
use App\InfoGraph;
use App\CareeKiProfile;
use App\Article;
use App\Contact;
use App\LikedContent;
use App\User;
use DB;
use Session;
use Auth;

class ArticleController extends Controller
{
    protected $url;

    public function __construct(UrlGenerator $url)
    {
        $this->url = $url;
    }

    public function articleApiData() {
        $article = Article::orderBy('id', 'desc')->get();
        return response($content = $article, $status = 200);
    }

    public function index()
    {
        $menu = ['article', 'articles'];
        $article = Article::orderBy('id', 'desc')->get();
        //$headers= [];
        //return response($content = $article, $status = 200);
        //dd($article);
        return view('articles.index', compact('menu', 'article'));
    }

    public function create()
    {
        $menu = ['article', 'articles'];
        return view('articles.create', compact('menu'));
    }
    
    
    public function profilePic()
    {
        $menu = ['article', 'articles'];
        return view('articles.profilepic', compact('menu'));
    }

    public function saveProfilePic(Request $request) {
        $id = $request->id;
        $data = User::find($id);
        $profile_image = $request->profile_image;
        
        if ($data->profile_image != $profile_image &&  $profile_image != "") {
             $data->profile_image = $profile_image;
             $data->save();
             
             return response()->json([
            'status' => "success",
            'code' => "200",
            'data' =>  User::find($id)
        ], 200);
        }
    }

    public function message(Request $request) {
        $table = new Contact();
        $table->name = $request->name;
        $table->email = $request->email;
        $table->subject = $request->subject;
        $table->message = $request->message;

        $table->save();
        return response()->json([
            'status' => "success",
            'code' => "200"
        ], 200);
    }
    
    public function likecontent(Request $request) {
        $table = new LikedContent();
        $table->user_id = $request->user_id;
        $table->content_id =  $request->content_id;
        $table->type = $request->type;

        $table->save();
        return response()->json([
            'status' => "success",
            'code' => "200",
            'data' => "$table"
        ], 200);
    }

    public function userCreate()
    {
        $menu = ['article', 'articles'];
        return view('articles.user', compact('menu'));
    }

    public function userList()
    {
        $menu = ['article', 'articles'];
        $user = User::all();
        return view('articles.userlist', compact('user','menu'));
    }

    public function userdelete($id)
    {
        $user = User::find($id);
        $user->delete();
        Session::flash('success', 'user has been deleted');
        return redirect()->route('user.list');
    }

    public function register(Request $request) {

        request()->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        $table = new User();
        $table->name = $request->name;
        $table->email = $request->email;
        $table->password = bcrypt($request->password);

        $table->save();
         return redirect()->route('user.page')
                        ->with('success','New User Registered');
    }

    public function store(Request $request)
    {
       // dd($request->all());

        request()->validate([
            'title' => 'required',
            'description' => 'required',
        ]);

        $url = $this->url->to('/');

        $data = [];

        if(request()->image):
            foreach (request()->image as $key => $value):
                $imageName = $value->getClientOriginalName();  
                $value->move(public_path('uploads/articles'), $imageName);
                $imgpath =$url.'/uploads/articles/'.$imageName;
                $data[$key] = [
                    'image' => $imgpath,
                    'description' => $request->description[$key]
                ];        
            endforeach;
        endif;

        $f_imageName = time().'.'.request()->featured_image->getClientOriginalExtension();

        request()->featured_image->move(public_path('uploads/articles'), $f_imageName);
        $f_imgpath =$url.'/uploads/articles/'.$f_imageName;

        $table = new Article();
        $table->title = $request->title;
        $table->description = json_encode($data, JSON_UNESCAPED_UNICODE);
        $table->image = $f_imgpath;
        $table->user_id = Auth::id();
        $table->status = $request->status;

        $table->save();
        return redirect()->route('articles.index')
                        ->with('success','New Article added');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $menu = ['article', 'articles'];
        $article = Article::findOrFail($id);

        return view('articles.edit',compact('menu', 'article'));
    }

    public function update(Request $request, $id)
    {
        $url = $this->url->to('/');
        $data = Article::find($id);
        $data->title = $request->input('title');
        $data->description = $request->input('description');
        $data->status = $request->input('status');

       if ($request->hasFile('featured_image')) 
       {
            $f_imageName = time().'.'.request()->featured_image->getClientOriginalExtension();
            request()->featured_image->move(public_path('uploads/articles'), $f_imageName);
            $data->image =$url.'/uploads/articles/'.$f_imageName; 
        }
        else
        {
            $data->image = $request->input('image_hidden');    
        }

        $data->save();
        Session::flash('success', 'Article has been updated');
        return redirect()->route('articles.index');
    }

    public function destroy($id)
    {
        $article = Article::find($id);
        $article->delete();
        Session::flash('success', 'Article has been deleted');
        return redirect()->route('articles.index');
    }
    
    public function searchFilter($title){
        $url = $this->url->to('/');
        $filter = $title;
        
        $first = DB::table('articles')
            ->select('id','title', 'description', 'image')
            ->where('title', 'like', $filter.'%');

        $second = DB::table('info_graphs')
            ->select( 'id','title', 'description', 'image')
            ->where('title', 'like', $filter.'%');
            
       $third = DB::table('caree_ki_profiles')
            ->select( 'id','title', 'description', 'image')
            ->where('title', 'like', $filter.'%')
             ->union($first)
             ->union($second)
            ->get();  
            
         return response()->json([
            'status' => "success",
            'code' => "200",
            'data' => $third,
        ], 200);   
    }
    
    public function likecontentget($id) {
        $liked_data = DB::table('liked_contents')
                ->leftJoin('articles', function($join){
                    $join->on('articles.id', '=', 'liked_contents.content_id');
                    $join->on('articles.type', '=', 'liked_contents.type');
                })
                ->leftJoin('caree_ki_profiles', function($join){
                    $join->on('caree_ki_profiles.id', '=', 'liked_contents.content_id');
                    $join->on('caree_ki_profiles.type', '=', 'liked_contents.type');
                })
                
                ->leftJoin('info_graphs', function($join){
                    $join->on('info_graphs.id', '=', 'liked_contents.content_id');
                    $join->on('info_graphs.type', '=', 'liked_contents.type');
                })
                ->where('liked_contents.user_id', $id)
                ->select('articles.title as articles_title','caree_ki_profiles.title as caree_ki_profiles_title','info_graphs.title as info_graphs_title','articles.description as articles_description',
                'caree_ki_profiles.description as profile_description','info_graphs.description as infog_description','articles.image as article_image','caree_ki_profiles.image as ck_profile_image','info_graphs.image as infog_image', 'liked_contents.content_id', 'liked_contents.type')
                ->orderBy('liked_contents.id', 'desc')
                ->get();
        return response($content = $liked_data, $status = 200);
    }
    
    public function searchView($table, $id){
        $data = DB::table($table)
            ->where('id', '=', $id)
            ->first();
            
        return response()->json([
            'status' => "success",
            'code' => "200",
            'data' => $data,
        ], 200);      
    }
}
