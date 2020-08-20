<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Routing\UrlGenerator;
use App\Http\Requests;
use App\CareeKiProfile;
use App\Contact;
use App\User;
use DB;
use Session;
use Auth;

class CkProfileController extends Controller
{
    protected $url;

    public function __construct(UrlGenerator $url)
    {
        $this->url = $url;
    }

    public function ckProfileApiData() {
        $article = CareeKiProfile::orderBy('id', 'desc')->get();
        return response($content = $article, $status = 200);
    }

    public function message() {
        $menu = ['message'];
        $message  = Contact::orderBy('id', 'desc')->get();
        return view('ckprofile.message', compact('message', 'menu'));

    }

    public function index()
    {
        $menu = ['ckprofile', 'ckprofile'];
        $profile = CareeKiProfile::orderBy('id', 'desc')->get();
        return view('ckprofile.index', compact('menu', 'profile'));
    }

    public function create()
    {
        $menu = ['ckprofile', 'ckprofile'];
        return view('ckprofile.create', compact('menu'));
    }

    public function store(Request $request)
    {
        request()->validate([
            'title' => 'required',
            'description' => 'required',
            'image' => 'required',
        ]);

        $url = $this->url->to('/');
        $imageName = time().'.'.request()->image->getClientOriginalExtension();
        request()->image->move(public_path('uploads/careerprofile'), $imageName);
        $imgpath =$url.'/uploads/careerprofile/'.$imageName;
       // dd($imgpath);

        $table = new CareeKiProfile();
        $table->title = $request->title;
        $table->description = $request->description;
        $table->image = $imgpath;
        $table->user_id = Auth::id();
        $table->status = $request->status;

        $table->save();
        return redirect()->route('ckprofile.index')
                        ->with('success','New Profile added');
    }

    public function show($id)
    {
        //
    }
    public function edit($id)
    {
        $menu = ['ckprofile', 'ckprofile'];
        $ckprofile = CareeKiProfile::findOrFail($id);

        return view('ckprofile.edit',compact('menu', 'ckprofile'));
    }

    public function update(Request $request, $id)
    {
        $url = $this->url->to('/');
        $data = CareeKiProfile::find($id);
        $data->title = $request->input('title');
        $data->description = $request->input('description');;
        $data->status = $request->input('status');
        if ($request->hasFile('image')) 
       {
            $f_imageName = time().'.'.request()->image->getClientOriginalExtension();
            request()->image->move(public_path('uploads/careerprofile'), $f_imageName);
            $data->image =$url.'/uploads/careerprofile/'.$f_imageName; 
        }
        else
        {
            $data->image = $request->input('image_hidden');    
        }
        $data->save();
        Session::flash('success', 'Career Profile has been updated');
        return redirect()->route('ckprofile.index');

    }

    public function destroy($id)
    {
        $careerprofile = CareeKiProfile::find($id);
        $careerprofile->delete();
        Session::flash('success', 'Career Profile has been deleted');
        return redirect()->route('ckprofile.index');
    }

        public function destroyMessage($id)
    {
        $contact = Contact::find($id);
        $contact->delete();
        Session::flash('success', 'Contact Message has been deleted');
        return redirect()->route('contact-message');
    }
}
