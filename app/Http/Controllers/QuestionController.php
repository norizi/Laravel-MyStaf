<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\QuestionType;
use App\Models\QuestionOption;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $question_type_id = $request->get('question_type_id');
        $question = $request->get('question');

        //dd($question);

        if (!empty($question_type_id) && !empty($question)) {
            
           Session::put('question_type_id', $question_type_id);
           Session::put('question', $question);
           $question_type_id = Session::get('question_type_id');
           $question = Session::get('question');

            $questions = Question::where('question_type_id', '=', $question_type_id)
            ->where('question', 'LIKE', '%'.$question.'%')
            ->orderby('id','DESC')
            ->paginate(10); 
        }else if (!empty($question_type_id)) {
             Session::put('question_type_id', $question_type_id);
             $question_type_id = Session::get('question_type_id');
            $questions = Question::where('question_type_id', '=', $question_type_id)
           
            ->paginate(10); 
        }elseif (!empty($question)) {
            Session::put('question', $question);
            
            $question = Session::get('question');
            $questions = Question::where('question', 'LIKE', '%'.$question.'%')
            ->orderby('id','ASC')
            ->paginate(10); 
        } else {
            $questions = Question::paginate(10);
        }

        

        $questionTypes = QuestionType::all();
    
        return view('question.index',compact('questions','questionTypes','question_type_id','question'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function editForm($id)
    {
        $questions = Question::find($id);
        //dd($questions);
        $question_types = QuestionType::all();
        return view('question.question_form',compact('questions','question_types'));
    }

    public function create()
    {
        $question_types = QuestionType::all();
        return view('question.question_form',compact('question_types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'question'=>'required', 
            'question_type_id'=>'required', 
        ]);

        $question = new Question([
            'question' => $request->get('question'), 
            'question_type_id' => $request->get('question_type_id'),
        ]);
        $question->save();
        return redirect('/question')->with('success', 'Berjaya disimpan !');
    }

    public function question_option_store(Request $request)
    {
        //dd($request->get('is_correct'));
        $request->validate([
            'question_option'=>'required', 
        ]);

        $questionOption = new QuestionOption([
            'question_option' => $request->get('question_option'), 
            'question_id' => $request->get('question_id'),
            'is_correct' => $request->get('is_correct'),
        ]);
        $questionOption->save();
        return redirect('/question')->with('success', 'Berjaya disimpan !');
    }

    public function  question_option_delete($id)
    {
        $questionOption = QuestionOption::findOrFail($id);

        $questionOption->delete();

        Session::flash('success', 'Berjaya dipadam!');

        return redirect()->route('question');
    }


    public function question_option_edit(Request $request)
    {
            $id = $request->get('question_option_id');
            $questionOption = QuestionOption::find($id);
            $questionOption->is_correct = $request->get('is_correct');
            $questionOption->question_option = $request->get('question_option'); 
            $questionOption->save();

        return redirect()->route('question')->with('success', 'Berjaya dikemaskini');;
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function show(Question $question)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $request->validate([
            'question'=>'required', 
            'question_type_id'=>'required', 
        ]);

        $id = $request->get('id');
            $question = Question::find($id);
         
            $question->question = $request->get('question'); 
            $question->question_type_id = $request->get('question_type_id');
            $question->save();

        return redirect()->route('question')->with('success', 'Berjaya dikemaskini');;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Question $question)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $question = Question::findOrFail($id);

        $question->delete();

        Session::flash('success', 'Berjaya dipadam!');

        return redirect()->route('question');
    }
}
