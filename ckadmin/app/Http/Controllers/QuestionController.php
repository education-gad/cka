<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Routing\UrlGenerator;
use App\Http\Requests;
use App\Question;
use App\QuestionOption;
use App\QuizTopic;
use App\PlayedQuiz;
use App\User;
use DB;
use Session;
use Auth;

class QuestionController extends Controller
{
    protected $url;

    public function __construct(UrlGenerator $url)
    {
         $this->middleware('auth');
        $this->url = $url;
    }

    public function index()
    {
        $menu = ['question', 'question'];
        $question = Question::with('option')->with('quiz')->with('user')->orderBy('id', 'desc')->get();
        //dd($question);
        return view('question.index', compact('menu', 'question'));
    }

    public function highestMarkByQuiz() {
        $max_mark = PlayedQuiz::where('quiz_id', 4)->max('obtain_point')->first();
    }

    public function create()
    {
        $menu = ['question', 'question'];
        $question = Question::orderBy('id', 'desc')->get();
        $quiz = QuizTopic::orderBy('id', 'desc')->get();
        //dd($quiz);
        return view('question.create', compact('menu', 'question', 'quiz'));
    }

    public function store(Request $request)
    {
        request()->validate([
            'question' => 'required',
            'point' => 'required',
            'quiz_topic_id' => 'required',
        ]);

        $url = $this->url->to('/');

        if ($request->image != null) {
            $imageName = time().'.'.request()->image->getClientOriginalExtension();

            request()->image->move(public_path('uploads/question'), $imageName);
            
            $imgpath =$url.'/uploads/question/'.$imageName;
            //dd($imgpath);

            $table = new Question();
            $table->quiz_topic_id = $request->quiz_topic_id;
            $table->question = $request->question;
            $table->question_explanation = $request->question_explanation;
            $table->point = $request->point;
            $table->image = $imgpath;
            $table->user_id = Auth::id();
            $table->status = $request->status;

            $table->save();
            return redirect()->route('question.create')
                            ->with('success','New Question added');
        }
        else
            {
            $table = new Question();
            $table->quiz_topic_id = $request->quiz_topic_id;
            $table->question = $request->question;
            $table->question_explanation = $request->question_explanation;
            $table->point = $request->point;
            $table->image = $request->image;
            $table->user_id = Auth::id();
            $table->status = $request->status;

            $table->save();
            return redirect()->route('question.create')
                            ->with('success','New Question added');
            }

    }

    public function qoStore(Request $request)
    {
        //dd($request->all());
        request()->validate([
            'question_option' => 'required',
            'option_1' => 'required',
            'option_2' => 'required',
            'option_3' => 'required',
            'option_4' => 'required',
        ]);

        $table = new QuestionOption();
        $table->question_id = $request->question_option;
        $table->option_1 = $request->option_1;
        $table->option_2 = $request->option_2;
        $table->option_3 = $request->option_3;
        $table->option_4 = $request->option_4;
        $table->answer = $request->answer;
        $table->user_id = Auth::id();

        $table->save();
        return redirect()->route('question.create')
                        ->with('success','Question Option Save');
    }

    public function palyedQuiz(Request $request) {

        $table = new PlayedQuiz();
        $table->quiz_id = $request->quiz_id;
        $table->user_id = $request->user_id;
        $table->right_ans = $request->right_ans;
        $table->wrong_ans = $request->wrong_ans;
        $table->total_question = $request->total_question;
        $table->obtain_point = $request->obtain_point;

        $table->save();
        return response()->json(['status' => 'success','message' => 'Played Quiz Score Updated']);
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }
    
    public function updateProfile(Request $request)
    {
        $id = $request->id;
        $data = User::find($id);
         $data->name = $request->name;
         $data->email = $request->email;
         $data->designation = $request->designation;
         $data->organization = $request->organization;
         $data->mobile = $request->mobile;
         $data->save();

             return response()->json([
            'status' => "success",
            'code' => "200",
            'data' =>  User::find($id)
        ], 200);
    }

    public function updateEmail(Request $request)
    {
        $id = $request->id;
        $data = User::find($id);
        $new_email = $request->email;
        if ($data->email != $new_email && $new_email != "") {
             $data->email = $new_email;
             $data->save();
             
             return response()->json([
            'status' => "success",
            'code' => "200",
            'data' =>  User::find($id)
        ], 200);
        }
        return response()->json(['status' => 'error','message' => 'We Could not Find the Email']);
    }

    public function updatePassword(Request $request)
    {
        $id = $request->id;
        $data = User::find($id);
        $new_pass = bcrypt($request->password);
        if ($data->password != $new_pass && $new_pass != "") {
             $data->password = $new_pass;
             $data->save();
             
             return response()->json([
            'status' => "success",
            'code' => "200",
            'data' =>  User::find($id)
        ], 200);
        }
        return response()->json(['status' => 'error']);
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        $question = Question::find($id);
        $question->delete();
        Session::flash('success', 'question has been deleted');
        return redirect()->route('question.index');
    }
}
