@extends('layouts.app')

@section('content')
<div class="container">
    
  <?php

  date_default_timezone_set("Asia/Kuala_Lumpur");
  ?>
  
   
  <h1><span class="badge badge-danger" id="demo"> 
    <?php 
     
    echo date("Y-m-d h:i:s"); ?>
  
  </span></h1>
   
 
 <h3> Bilangan Soalan yang dijawab : <span class="badge badge-success">{{$count}}/40 </span></h3>
 
 
     
      @foreach($userAnswers as $index => $userAnswer)
      
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">{{ $loop->iteration + $userAnswers->firstItem() - 1 }}. {!! $userAnswer->question !!}</h4>
         
          <?php
          //dd($userAnswers);
          $question_id = $userAnswer->question_id;
          $id = $userAnswer->id;
          /*
          $questionOptions = \App\Models\QuestionOption::where('user_answers.question_id',$question_id)
          ->join('questions', 'questions.id', '=', 'question_options.question_id')
          ->join('user_answers', 'user_answers.question_id', '=', 'questions.id')
          ->where('user_answers.id', $id)
          ->get();
          */
          $questionOptions = \App\Models\QuestionOption::where('question_id',$question_id) 
          ->get();

          //dd($questionOptions);
          ?>
          @if($questionOptions->first())
          <form method="POST" action="{{ route('user.exam_submit') }}">
          @csrf
          @foreach($questionOptions as $index => $questionOption)
                    
          <p class="card-text">
            <div class="form-check">
              <label class="form-check-label">
                <input type="radio" class="form-check-input" value="{{$questionOption->id}}" name="question_option_id" 
                @if($userAnswer->question_option_id==$questionOption->id)
                  <?php echo "checked"; ?>
                @endif
                required>
                {{$questionOption->question_option}} 
              </label>
            </div>
            
            </p>
            @endforeach
            <input type="hidden"   name="id" value="{{$userAnswer->id}}">
            <input type="hidden"   name="page" value="{{ $request->input('page') }}">
            <input type="submit" class="btn btn-primary " value="Simpan"> 

          </form>
          @endif
        </div>
      </div>


      @endforeach
	  
 
	  
	  
	  
    </tbody>
  </table>
<br>
  {!! $userAnswers->links() !!}
 
   


  
</div>
@endsection
