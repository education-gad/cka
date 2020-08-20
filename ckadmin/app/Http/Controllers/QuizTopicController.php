<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Routing\UrlGenerator;
use App\Http\Requests;
use App\Question;
use App\QuizTopic;
use DB;
use Session;
use Auth;

class QuizTopicController extends Controller
{
    protected $url;

    public function __construct(UrlGenerator $url)
    {
        $this->middleware('auth');
        $this->url = $url;
    }

    public function index()
    {
        $menu = ['quiz_topic', 'quiz_topic'];
        $quiz = QuizTopic::orderBy('id', 'desc')->get();
        //dd($question);
        return view('quiz.index', compact('menu', 'quiz'));
    }

    public function create()
    {
       $menu = ['quiz_topic', 'quiz_topic'];
       return view('quiz.create', compact('menu'));
    }

    public function store(Request $request)
    {
        //dd($request->all());
        request()->validate([
            'quiz_title' => 'required',
            'quiz_topic' => 'required',
            'image' => 'required',
        ]);

        $url = $this->url->to('/');

        $imageName = time().'.'.request()->image->getClientOriginalExtension();

        request()->image->move(public_path('uploads/quiz'), $imageName);
        
        $imgpath =$url.'/uploads/quiz/'.$imageName;
        //dd($imgpath);

        $table = new QuizTopic();
        $table->quiz_title = $request->quiz_title;
        $table->quiz_topic = $request->quiz_topic;
        $table->image = $imgpath;
        $table->status = $request->status;

        $table->save();
        return redirect()->route('quiz.create')
                        ->with('success','New Quiz added');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        $quiz = QuizTopic::find($id);
        $quiz->delete();
        Session::flash('success', 'quiz has been deleted');
        return redirect()->route('quiz.index');
    }
}
