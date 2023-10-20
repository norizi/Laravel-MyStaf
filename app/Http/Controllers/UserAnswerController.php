<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\UserAnswer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class UserAnswerController extends Controller
{
    //
    public function __construct()
    {
        date_default_timezone_set("Asia/Kuala_Lumpur");
        //$this->start_date = "2022-12-16 16:40:00";
        //$this->endDate = "2022-12-16 17:51:00";

        $this->start_date = "2022-12-20 09:00:00";
        $this->endDate = "2022-12-20 10:30:00";

        //$this->start_date_subjective = "2022-12-16 17:00:00";
       // $this->endDate_subjective = "2022-12-16 18:05:00";

        $this->start_date_subjective = "2022-12-20 11:00:00";
        $this->endDate_subjective = "2022-12-20 12:45:00";
    }


    public function exam()
    {
       // dd($this->start_date);
        date_default_timezone_set("Asia/Kuala_Lumpur");
		 $currentDate = date('Y-m-d h:i:s');
        $currentDate = date('Y-m-d h:i:s', strtotime($currentDate));
        
        //$startDate = date('Y-m-d h:i:s', strtotime("2022-12-16 16:00:00"));
        //$endDate = date('Y-m-d h:i:s', strtotime("2022-12-16 17:30:00"));
        $startDate = date('Y-m-d h:i:s', strtotime($this->start_date));
        $endDate = date('Y-m-d h:i:s', strtotime($this->endDate));
        
        if (($currentDate >= $startDate) && ($currentDate <= $endDate)){
            //$msg = "Current date is between two dates";

        }else{
            $msg = "Maaf ! Peperiksaan belum bermula";  
            return redirect('/home')->with('msg', $msg);
        }
		
        $id = Auth::user()->id;
        $result = UserAnswer::where('user_id',$id )->first();
       
        if ($result) {
            echo "set soalan dah create";
            
        }else{
            
            //$questions = Question::inRandomOrder()->get()->where('question_type_id', 1)->random(50);
			$questions = Question::get()->where('question_type_id', 1);
            foreach($questions as $question){
                $question = new UserAnswer([
                    'question_id' => $question->id, 
                    'user_id' => $id,
                ]);
                $question->save();
            } 
           
            //$questionSubjectives = Question::get()->where('question_type_id', 2)->random(5);
			$questionSubjectives = Question::get()->where('question_type_id', 2);
            foreach($questionSubjectives as $questionSubjective){
                $questionSubjective = new UserAnswer([
                    'question_id' => $questionSubjective->id, 
                    'user_id' => $id,
                ]);
                $questionSubjective->save();
            }
           
            echo "set soalan baru jana";
        }
        

         

       // return view('user.exam',compact('questions'));
       return redirect('/user_exam')->with('success', 'Contact saved!');
    }

    public function user_exam(Request $request)
    {
        date_default_timezone_set("Asia/Kuala_Lumpur");
        //dd($this->start_date);
        $currentDate = date('Y-m-d h:i:s');
        $currentDate = date('Y-m-d h:i:s', strtotime($currentDate));
        
        $startDate = date('Y-m-d h:i:s', strtotime($this->start_date));
        $endDate = date('Y-m-d h:i:s', strtotime($this->endDate));
        
        if (($currentDate >= $startDate) && ($currentDate <= $endDate)){
            //$msg = "Current date is between two dates";

        }else{
            $msg = "Maaf ! Peperiksaan belum bermula";  
            return redirect('/home')->with('msg', $msg);
        }


        $id = Auth::user()->id;
        //$userAnswers = UserAnswer::where('user_id',$id )->paginate(1); 
       $userAnswers = DB::table('user_answers')
        ->join('questions', 'questions.id', '=', 'user_answers.question_id') 
        //->select('user_answers.id as id, questions.question as question, user_answers.question_id as question_id')
        ->select('user_answers.*', 'questions.question',)
        ->where('user_answers.user_id', $id)
        ->where('questions.question_type_id', 1)
        ->paginate(1);
        $request = $request;

        $user_jawab = UserAnswer::where('user_id',$id )->whereNotNull('question_option_id')->get(); 
        $count = $user_jawab->count();

       return view('user.exam',compact('userAnswers','request','count'));
    }

    public function examSubmit(Request $request)
    {
        $currentURL =  url()->previous();
        $page = $request->page;
        // dd($page);   
            $id = $request->get('id');
            $userAnswer = UserAnswer::find($id);
            $userAnswer->question_option_id = $request->get('question_option_id'); 
            $userAnswer->save();

           // return redirect('/user_exam' ,['page' =>$page])->with('success', 'Contact saved!');
           return redirect()->back();
    }

    public function user_exam_subjective(Request $request)
    {
        //dd($this->endDate_subjective);
        //return redirect('/home')->with('success', 'Saved!');
         

        $currentDate = date('Y-m-d h:i:s');
        $currentDate = date('Y-m-d h:i:s', strtotime($currentDate));
        
       // $startDate = date('Y-m-d h:i:s', strtotime($this->start_date));
        //$endDate = date('Y-m-d h:i:s', strtotime($this->endDate));

        $startDate = date('Y-m-d h:i:s', strtotime($this->start_date_subjective));
       
        $endDate = date('Y-m-d h:i:s', strtotime($this->endDate_subjective));
        //dd($currentDate);
        //dd($endDate);
        if (($currentDate >= $startDate) && ($currentDate <= $endDate)){
            //$msg = "Current date is between two dates";

        }else{
            $msg = "Maaf ! Peperiksaan belum bermula";  
            return redirect('/home')->with('msg', $msg);
        }

		
		$id = Auth::user()->id;

        $check = UserAnswer::where('user_id',$id)->first(); 
       // dd($check);
        if(!$check){
            return redirect('/exam')->with('error', 'Sila jawab soalan subjektif!');
        }

        
       // $userAnswers = UserAnswer::where('user_id',$id )->paginate(1); 
        $questions = $query = DB::table('questions')
        ->join('user_answers', 'questions.id', '=', 'user_answers.question_id') 
        ->select('questions.*', 'user_answers.answer',)
        ->where('user_answers.user_id', $id)
        ->where('questions.question_type_id', 2)
        ->paginate(1);
        //$request = $request;

        $soalanSubjective = Question::where('question_type_id','2')->get(); 
        $countSoalan = $soalanSubjective->count();
        //dd($countSoalan);

        $userJawab = UserAnswer::where('user_id',$id )
        ->join('questions','questions.id', '=','user_answers.question_id')
        ->where('user_answers.answer','!=','')
        ->where('question_type_id','2')->get(); 

        $count = $userJawab->count();

       // dd($questions);
       return view('user.exam_subjective',compact('questions','request','count','countSoalan'));
    }

    public function subjectiveStore(Request $request)
    {
        
        $request->validate([
            'answer'=>'required'
        ]);
        
        $currentURL =  url()->previous();
        $user_id = Auth::user()->id; 
        // dd($page);   
            $question_id = $request->get('question_id');
            $userAnswer = UserAnswer::where('question_id', $question_id)->where('user_id', $user_id)->first();
            //dd($userAnswer);
            if(empty($userAnswer->question_id)){              
                //echo "save";
                $userAnswer = new UserAnswer;
                $userAnswer->question_id = $request->get('question_id'); 
                $userAnswer->answer = $request->get('answer');
                $userAnswer->user_id = $user_id; 
                $userAnswer->save();
            }else{
                echo "edit";
                DB::table('user_answers')
                ->where('user_id', $user_id)
                ->where('question_id', $question_id)
                ->update(['answer' => $request->get('answer')]);
                
            }
            //$userAnswer->question_option_id = $request->get('question_option_id'); 
            //$userAnswer->save();

           // return redirect('/user_exam' ,['page' =>$page])->with('success', 'Contact saved!');
           return redirect()->back();
    }
}
